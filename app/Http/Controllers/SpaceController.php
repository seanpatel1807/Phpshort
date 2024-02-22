<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Space;
use Illuminate\Support\Facades\DB;


class SpaceController extends Controller
{
    public function create()
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

    public function index(Request $request)
    {
        $query = $request->input('query');
        
        $spaces = Space::withCount('links')
            ->when($query, function ($query) use ($request) {
                $query->where('space_name', 'like', '%' . $request->input('query') . '%');
            })
            ->get();
        
        return view('user.space', compact('spaces', 'query'));
    }
    
    public function destroy($id)
    {
        $space = Space::find($id);

        if (!$space) {
            return redirect()->back()->with('error', 'Space not found!');
        }

        $space->delete();
        return redirect()->back()->with('success', 'Space deleted successfully!');
    }
    public function data(Request $request)
    {
        $query = $request->input('query');
    
        $user = DB::table('spaces')
            ->join('users', 'users.id', '=', 'spaces.users_id')
            ->select(
                'spaces.*',
                'users.name as user_name',
                'users.email as user_email',
                DB::raw('(SELECT COUNT(*) FROM links WHERE links.spaces_id = spaces.id) as links_count')
            )
            ->when($query, function ($query) use ($request) {
                $query->where('users.name', 'like', '%' . $request->input('query') . '%')
                      ->orWhere('space_name', 'like', '%' . $request->input('query') . '%')
                      ->orWhere(DB::raw('(SELECT COUNT(*) FROM links WHERE links.spaces_id = spaces.id)'), 'like', '%' . $request->input('query') . '%');
            })
            ->get();
    
        return view('spaces', compact('user', 'query'));
    }
    
    public function edit($id)
{
    $space = Space::find($id);

    if (!$space) {
        return redirect()->back()->withErrors(['Space not found.']);
    }

    return view('edit_space', compact('space'));
}
public function update(Request $request, $id)
    {
        $space = Space::find($id);

        if (!$space) {
            return redirect()->back()->withErrors(['Link not found.']);
        }

        $request->validate([
            'space_name' => 'required',
        ]);

        $space->space_name = $request->input('space_name');
        
        $space->save();

        return redirect()->back()->with('success', 'Link updated successfully.');
    }
}
