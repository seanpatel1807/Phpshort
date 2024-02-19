<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Link;
use App\Models\Space;
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
            $shortUrl = Link::generateShortUrl($request->all());
            $message = null;
        }

        $allLinks = Link::all();
        $allSpaces = Space::all();

        return view('user.link', compact('shortUrl', 'message', 'allLinks', 'allSpaces'));
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

        return view('user.link', compact('allLinks', 'allSpaces'));
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

        return view('edit_link', compact('link', 'allSpaces'));
    }

    public function update(Request $request, $id)
    {
        $link = Link::find($id);

        if (!$link) {
            return redirect()->back()->withErrors(['Link not found.']);
        }

        $request->validate([
            'original_url' => 'required|url',
            'short_url'=> 'required',
            'space_name'=>'required',
        ]);

        $link->original_url = $request->input('original_url');
        $link->short_url = $request->input('short_url');
        $link->spaces_id = $request->input('space_name');


        $link->save();

        return redirect()->back()->with('success', 'Link updated successfully.');
    }
}
