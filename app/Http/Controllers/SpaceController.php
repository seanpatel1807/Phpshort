<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Space;
use Illuminate\Support\Facades\DB;


class SpaceController extends Controller
{
    public function showForm()
    {
        return view('user.new');
    }

    public function store(Request $request)
    {   
        $request->validate([
            'value' => 'required|string|max:255',
        ]);
         
        $user = auth()->user();
        Space::create([
            'space_name' => $request->input('value'),
            'users_id' => $user->id,
        ]);

        return redirect()->back()->with('success', 'Value stored successfully!');
    }

    public function showSpaces()
    {
        $spaces = Space::withCount('links')->get();
        return view('user.space', compact('spaces'));
    }
    public function deleteSpace($id)
    {
        $space = Space::find($id);

        if (!$space) {
            return redirect()->back()->with('error', 'Space not found!');
        }

        $space->delete();
        return redirect()->back()->with('success', 'Space deleted successfully!');
    }
    public function data()
    {

    $user = DB::table('spaces')
    ->join('users', 'users.id', '=', 'spaces.users_id')
    ->select(
        'spaces.*',
        'users.name as user_name',
        'users.email as user_email',
        DB::raw('(SELECT COUNT(*) FROM links WHERE links.spaces_id = spaces.id) as links_count')
    )
    ->get();
       
        return view('spaces', compact('user'));
    }
}
