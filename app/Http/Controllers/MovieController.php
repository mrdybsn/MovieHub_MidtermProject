<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Genre;

class MovieController extends Controller
{
    /**
     * Display dashboard with movies and genres
     */
    public function index()
    {
        $movies = Movie::with('genre')->latest()->get();
        $genres = Genre::all();
        $activeGenres = Genre::count();

        return view('dashboard', compact('movies', 'genres', 'activeGenres'));
    }

    /**
     * Store a new movie
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'release_year' => 'required|integer|min:1900|max:' . (date('Y') + 5),
            'director' => 'required|string|max:255',
            'genre_id' => 'required|exists:genres,id',
        ]);

        Movie::create($validated);

        return redirect()->back()->with('success', 'Movie added successfully.');
    }

    /**
     * Update an existing movie
     */
    public function update(Request $request, Movie $movie)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'release_year' => 'required|integer|min:1900|max:' . (date('Y') + 5),
            'director' => 'required|string|max:255',
            'genre_id' => 'required|exists:genres,id',
        ]);

        $movie->update($validated);

        return redirect()->back()->with('success', 'Movie updated successfully.');
    }

    /**
     * Delete a movie
     */
    public function destroy(Movie $movie)
    {
        $movie->delete();
        return redirect()->back()->with('success', 'Movie deleted successfully.');
    }
}