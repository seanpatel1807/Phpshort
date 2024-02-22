<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Link;
use App\Models\Space;
use App\Models\Pixel;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    public function create(Request $request)
    {
        $originalUrls = explode("\n", $request->input('original_url'));
        $originalUrls = array_map('trim', $originalUrls);
        foreach ($originalUrls as $originalUrl){
            
        $existingLink = Link::where('original_url',$originalUrl )->first();

        if ($existingLink) {
            $shortUrl = $existingLink->short_url;
            $message = 'This URL already has a short link.';
        } else {
            $shortUrl = Link::generateShortUrl($request->all(),$originalUrl );
            $message = null;
        }
    }
        $allLinks = Link::all();
        $allSpaces = Space::all();
        $allPixels = Pixel::all();
        return view('user.link', compact('shortUrl', 'message', 'allLinks', 'allSpaces','allPixels'));
    }



    public function redirect($shortUrl)
    {
        $link = Link::where('short_url', $shortUrl)->first();

        if ($link && ($link->expiration_date === null || now() < $link->expiration_date)) {
            $link->click_count++;
            $link->save();

            return redirect($link->original_url);
        }
        abort(404);
    }

    public function index()
    {
        $allLinks = Link::all();
        $allSpaces = Space::all();
        $allPixels = Pixel::all();
        return view('user.link', compact('allLinks', 'allSpaces','allPixels'));
    }

    public function delete($id)
    {
        $link = Link::find($id);

        if (!$link) {
            return redirect()->back()->withErrors(['Link not found.']);
        }

        $link->delete();

        $allLinks = Link::all();

        return  redirect()->back();
    }

    public function edit($id)
    {
        $link = Link::find($id);

        if (!$link) {
            return redirect()->back()->withErrors(['Link not found.']);
        }

        $allSpaces = Space::all();
        $allPixels = Pixel::all();
        return view('edit_link', compact('link', 'allSpaces','allPixels'));
    }

    public function update(Request $request, $id)
    {
        $link = Link::find($id);

        if (!$link) {
            return redirect()->back()->withErrors(['Link not found.']);
        }
        
        $link->original_url = $request->input('original_url');
        $link->spaces_id = $request->input('space_id');
        $link->short_url = $request->input('short_url');
        $link->pixels_id = $request->input('pixels_id');

        

        $link->save();

        return redirect()->back()->with('success', 'Link updated successfully.');
    }
}
