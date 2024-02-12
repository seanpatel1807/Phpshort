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
        } else {
            $shortUrl = Link::generateShortUrl($request->input('original_url'));
        }

        return view('user.link', compact('shortUrl'));
    }

    public function redirect($shortUrl)

    {
       
        $link = Link::where('short_url', $shortUrl)->first();

        if ($link) {
            return redirect($link->original_url);
        }

        abort(404);
    }
}
