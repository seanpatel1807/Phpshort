<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Link;
use App\Models\Space;
use App\Models\Pixel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class LinkController extends Controller
{
    public function create(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'original_url' => 'required|url',
        ]);
    
        // Check if validation fails
        if ($validator->fails()) {
           
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    
    
        $originalUrls = explode("\n", $request->input('original_url'));
        $originalUrls = array_map('trim', $originalUrls);

        foreach ($originalUrls as $originalUrl) {
            $existingLink = Link::where('original_url', $originalUrl)->first();

            if ($existingLink) {
                $shortUrl = $existingLink->short_url;
                $message = 'This URL already has a short link.';
            } else {
                $data = $request->all();
                $click_limit = $request->input('click_limit');
                $data['access_type'] = $request->input('access_type', 'public');
                $data['password'] = ($data['access_type'] == 'password') ? encrypt($request->input('password')) : null;

                // Check if the authenticated user is disabled
                $user = auth()->user();
                if ($user && $user->is_disabled) {
                    abort(403, 'User is disabled.');
                }

                $shortUrl = Link::generateShortUrl($data, $originalUrl);
                $message = null;
            }
        }

        $allLinks = Link::all();
        $allSpaces = Space::all();
        $allPixels = Pixel::all();

        return redirect()->route('user.link', compact('shortUrl', 'message', 'allLinks', 'allSpaces', 'allPixels'));
    }

    public function redirect($shortUrl, Request $request)
{
    $link = Link::where('short_url', $shortUrl)->lockForUpdate()->first();

    if ($link) {
        // Check if the user associated with the link is disabled
        $user = $link->user;
        if ($user && $user->is_disabled) {
            abort(403, 'User is disabled.');
        }

        if ($link->expiration_date !== null && now() >= $link->expiration_date) {
            abort(404);
        }

        $clickLimit = $link->click_limit;

        if ($clickLimit !== null) {
            // Check if the link has exceeded the click limit
            if ($link->click_count == $clickLimit) {
                return view('click_limit');
            }
            
        }

        switch ($link->access_type) {
            case 'password':
                return view('password_form', compact('link'));
                break;

            case 'private':
                if (auth()->check()) {
                    // Check if the authenticated user is the owner of the link
                    if ($link->user_id !== auth()->user()->id) {
                        abort(403, 'Unauthorized access to private link');
                    }

                    // Increment the click count for private links
                    $link->click_count++;
                    $link->save();
                    
                    return redirect($link->original_url);
                } else {
                    $link->click_count--;
                    abort(403,'private link');
                }
                break;

            default:
                // Public link, update click count and redirect
                $link->click_count++;
                $link->save();
                
                return redirect($link->original_url);
        }
    }

    abort(404);
}


    public function index()
    {
        // Only fetch links associated with the authenticated user
        $user = auth()->user();

        // Check if the user is disabled
        if ($user && $user->is_disabled) {
            abort(403, 'User is disabled.');
        }

        $allLinks = Link::where('user_id', $user->id)->get();
        $allSpaces = Space::all();
        $allPixels = Pixel::all();
        return view('user.link', compact('allLinks', 'allSpaces', 'allPixels'));
    }

    public function delete($id)
    {
        $link = Link::find($id);

        if (!$link) {
            return redirect()->back()->withErrors(['Link not found.']);
        }

        // Check if the authenticated user is disabled
        $user = auth()->user();
        if ($user && $user->is_disabled) {
            abort(403, 'User is disabled.');
        }

        $link->delete();

        $allLinks = Link::all();

        return  redirect()->back()->with('success', 'Deleted successfully');
    }

    public function edit($id)
    {
        $link = Link::find($id);
        $user = auth()->user();

        if ($user && $user->is_disabled) {
            abort(403, 'User is disabled.');
        }

        if (!$link) {
            return redirect()->back()->withErrors(['Link not found.']);
        }
        $allSpaces = Space::all();
        $allPixels = Pixel::all();
        return view('edit_link', compact('link', 'allSpaces', 'allPixels'))->with('success', 'Updated');
    }

    public function update(Request $request, $id)
{
    $link = Link::find($id);

    if (!$link) {
        return redirect()->back()->withErrors(['Link not found.']);
    }

    $request->validate([
        'original_url' => 'required|url',
        'password' => $request->input('access_type') === 'password' ? 'required' : '',
    ]);

    // Check if the authenticated user is disabled
    $user = auth()->user();
    if ($user && $user->is_disabled) {
        abort(403, 'User is disabled.');
    }

    $link->original_url = $request->input('original_url', $link->original_url);
    $link->spaces_id = $request->input('space_id', $link->spaces_id);
    $link->short_url = $request->input('short_url', $link->short_url);
    $link->pixels_id = $request->input('pixels_id', $link->pixels_id);

    $oldClickLimit = $link->click_limit;
    $newClickLimit = $request->input('click_limit', $oldClickLimit);
    $link->click_limit = $newClickLimit;

    if ($newClickLimit != $oldClickLimit) {

        $link->click_count = 0;
    }

    $link->expiration_date = $request->input('expiration_date', $link->expiration_date);
    $link->password = $request->input('password', $link->password);
    $link->access_type = $request->input('access_type', $link->access_type);

    $link->save();

    return redirect(route('user.link'))->with('success', 'Link updated successfully.');
}

    public function checkPassword($shortUrl, Request $request)
    {
        $link = Link::where('short_url', $shortUrl)->first();

        if ($link) {
            $providedPassword = $request->input('password');
            if (decrypt($link->password) === $providedPassword) {

                $link->click_count++;
                $link->save();
                return redirect($link->original_url);
            } else {

                return redirect()->back()->with('error', 'Incorrect password');
            }
        }

        abort(404);
    }
}
