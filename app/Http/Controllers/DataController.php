<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Link;

class DataController extends Controller
{
    public function data()
    {
        $users = User::all();
        $links = Link::all();

        return view('links', compact('users', 'links'));
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
}
