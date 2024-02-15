<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Space;

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

        Space::create([
            'space_name' => $request->input('value'),
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
    
}
