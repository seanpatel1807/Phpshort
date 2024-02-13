<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'original_url' => 'required|url',
        ]);

        $existingLink = Link::where('original_url', $request->input('original_url'))->first();

        if ($existingLink) {
            $shortUrl = $existingLink->short_url;
            $message = 'This URL already has a short link.';
        } else {
            $shortUrl = Link::generateShortUrl($request->input('original_url'));
            $message = null;
        }

        // Fetch all links
        $allLinks = Link::all();
        return view('user.link', compact('shortUrl', 'message', 'allLinks'));
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
        return view('user.link', compact('allLinks'));
    }

    public function delete($id)
    {
        $link = Link::find($id);

        if (!$link) {
            return redirect()->back()->withErrors(['Link not found.']);
        }

        $link->delete();

        $allLinks = Link::all();

        return view('user.link', compact('allLinks'))->with('success', 'Link deleted successfully.');
    }
}
