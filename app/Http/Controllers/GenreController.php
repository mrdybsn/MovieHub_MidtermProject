<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;

class GenreController extends Controller
{
    /**
     * Display the genres page
     * Shows all genres in the database
     */
    public function index()
    {
        $genres = Genre::latest()->get();
        return view('genre', compact('genres'));
    }

    /**
     * Store a new genre in database
     * Validates input then creates genre
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        Genre::create($validated);
        return redirect()->back()->with('success', 'Genre added successfully.');
    }

    /**
     * Update an existing genre
     * Finds genre by ID and updates it
     */
    public function update(Request $request, Genre $genre)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $genre->update($validated);
        return redirect()->back()->with('success', 'Genre updated successfully.');
    }

    /**
     * Delete a genre from database
     * Removes genre by ID
     */
    public function destroy(Genre $genre)
    {
        $genre->delete();
        return redirect()->back()->with('success', 'Genre deleted successfully.');
    }
}