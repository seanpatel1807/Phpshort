<?php

namespace App\Http\Controllers;
use App\Models\Pages;

use Illuminate\Http\Request;

class PageController extends Controller
{   
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');

        $pages = Pages::when($searchTerm, function ($query) use ($searchTerm) {
            $query->where('name', 'like', '%' . $searchTerm . '%');
        })->get();

        return view('pages.index', ['page' => $pages, 'searchTerm' => $searchTerm]);
    }

    public function create()
    {
        return view('pages.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string',
            'visibility' => 'required',
            'content' => 'required|string|max:1000',
        ]);

        Pages::create($validatedData);

        return redirect()->route('pages.index')->with('success', 'Page created successfully');
    }

    public function edit($id)
    {
        $pages = Pages::find($id);

        return view('pages.edit', ['page' => $pages]);
    }

    public function update(Request $request,$id)
    {
        $pages = Pages::find($id);

        // Validation logic here (similar to create/store)

        $pages->update([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'visibility' => $request->input('visibility'),
            'content' => $request->input('content'),
            
        ]);

        return redirect()->route('pages.index', $id)->with('success', 'Page updated successfully');
    }

    public function destroy($id)
    {
        $pages = Pages::find($id);
        $pages->delete();

        return redirect()->route('pages.index')->with('success', 'Page deleted successfully');
    }
}
