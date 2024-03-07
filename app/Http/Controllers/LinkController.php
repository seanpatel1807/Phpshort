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
    $originalUrls = array_map('trim', explode("\n", $request->input('original_url')));

    foreach ($originalUrls as $originalUrl) {
        $existingLink = Link::where('original_url', $originalUrl)
            ->where('user_id', auth()->id())
            ->first();

        if ($existingLink) {
            $shortUrl = $existingLink->short_url;
            return redirect()->back()->withErrors(['duplicate_link' => "This URL $shortUrl has already been shortened."]);
        } else {
            $data = $request->all();
            $clickLimit = $request->input('click_limit');
            $data['access_type'] = $request->input('access_type', 'public');
            $data['password'] = ($data['access_type'] == 'password') ? encrypt($request->input('password')) : null;


            $user = auth()->user();
            if ($user && $user->is_disabled) {
                auth()->logout();
                return redirect(route('login'))->with('logout', 'You have been logged out due to account disability.');
            }

            $shortUrl = Link::generateShortUrl($data, $originalUrl);
            $message = null;
        }
    }

    $allLinks = Link::all();
    $allSpaces = Space::all();
    $allPixels = Pixel::all();

    return redirect()->route('user.link', compact('shortUrl', 'allLinks', 'allSpaces', 'allPixels'));
}

    public function redirect($shortUrl, Request $request)
    {
        $link = Link::where('short_url', $shortUrl)->lockForUpdate()->first();

        if ($link) {
            $user = $link->user;
            if ($user && $user->is_disabled) {
                auth()->logout();
                return redirect(route('login'))->with('logout', 'You have been logged out due to account disability.');
            }

            if ($link->expiration_date !== null && now() >= $link->expiration_date) {
                abort(404);
            }

            $clickLimit = $link->click_limit;

            if ($clickLimit !== null && $link->click_count == $clickLimit) {
                return view('click_limit');
            }

            switch ($link->access_type) {
                case 'password':
                    if (auth()->check()) {
                        if ($link->user_id === auth()->user()->id) {
                            $link->click_count++;
                            $link->save();
                            return redirect($link->original_url);
                        }
                    } else {
                        return view('password_form', compact('link'));
                    }
                    break;

                case 'private':
                    if (auth()->check()) {
                        if ($link->user_id !== auth()->user()->id) {
                            abort(403, 'Unauthorized access to private link');
                        }

                        $link->click_count++;
                        $link->save();

                        return redirect($link->original_url);
                    } else {
                        $link->click_count--;
                        abort(403, 'Private link');
                    }
                    break;

                default:
                    $link->click_count++;
                    $link->save();

                    return redirect($link->original_url);
            }
        }

        abort(404);
    }

    public function index()
    {
        $user = auth()->user();

        if ($user && $user->is_disabled) {
            auth()->logout();
            return redirect(route('login'))->with('logout', 'You have been logged out due to account disability.');
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

        $user = auth()->user();
        if ($user && $user->is_disabled) {
            auth()->logout();
            return redirect(route('login'))->with('logout', 'You have been logged out due to account disability.');
        }

        $link->delete();
        $allLinks = Link::all();

        return redirect()->back()->with('success', 'Deleted successfully');
    }

    public function edit($id)
    {
        $link = Link::find($id);
        $user = auth()->user();

        if ($user && $user->is_disabled) {
            auth()->logout();
            return redirect(route('login'))->with('logout', 'You have been logged out due to account disability.');
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
        'original_url' => 'required|unique:links,original_url,' . $id,
        'password' => $request->input('access_type') === 'password' ? 'required' : '',
        'expiration_date' => 'nullable|date|after:now',
    ]);

    $user = auth()->user();
    if ($user && $user->is_disabled) {
        auth()->logout();
        return redirect(route('login'))->with('logout', 'You have been logged out due to account disability.');
    }

    $link->original_url = $request->input('original_url', $link->original_url);
    $link->space_id = $request->input('space_id', $link->space_id);
    $link->short_url = $request->input('short_url', $link->short_url);
    $link->pixels_id = $request->input('pixels_id', $link->pixels_id);

    $oldClickLimit = $link->click_limit;
    $newClickLimit = $request->input('click_limit', $oldClickLimit);
    $link->click_limit = $newClickLimit;

    $oldClickCount = $link->click_count;

    if ($newClickLimit != $oldClickLimit || $oldClickCount >= $oldClickLimit) {
        $link->click_count = 0;
    }

    $expirationDate = $request->input('expiration_date', $link->expiration_date);

    if ($expirationDate !== null && now() >= $expirationDate) {
        return redirect()->route('edit.link', $id)->with('expiration_prompt', true);
    }

    $link->expiration_date = $expirationDate;
    $link->access_type = $request->input('access_type', $link->access_type);
    
    $password = $request->input('password');
    $link->password = ($password && $link->access_type === 'password') ? encrypt($password) : null;
    
    $link->save();

    return redirect(route('user.link'))->with('success', 'Link updated successfully.');
}

    public function checkPassword($shortUrl, Request $request)
    {
        $link = Link::where('short_url', $shortUrl)->first();

        if ($link) {
            $providedPassword = $request->input('password');

            try {
                $decryptedPassword = decrypt($link->password);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                $decryptedPassword = $link->password;
            }

            if ($decryptedPassword === $providedPassword) {
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
