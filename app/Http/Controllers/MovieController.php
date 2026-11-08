<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MovieController extends Controller
{
    private array $directors = [
        'Cathy Garcia-Sampana',
        'Antoinette Jadaone',
        'Jerrold Tarog',
        'Erik Matti',
    ];

    public function index(Request $request)
    {
        DB::enableQueryLog();

        $genre = $request->query('genre', 'all');
        $director = $request->query('director', 'all');

        $query = Movie::with('genre');

        if ($genre !== 'all') {
            $query->where('genre_id', $genre);
        }

        if ($director !== 'all') {
            $query->where('director', $director);
        }

        $movies = $query->get();
        $genres = Genre::all();

        return view('movies.index', compact(
            'movies',
            'genres',
            'genre',
            'director'
        ));
    }

    public function create()
    {
        return view('movies.create', [
            'directors' => $this->directors,
            'genres' => Genre::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'director' => 'required|in:' . implode(',', $this->directors),
            'genre_id' => 'required|exists:genres,id',
            'year' => 'required|numeric|min:1900|max:2026',
        ]);

        Movie::create($validated);

        return redirect()->route('movies.index')
            ->with('success', 'Movie added successfully.');
    }

    public function show(Movie $movie)
    {
        return view('movies.show', ['item' => $movie]);
    }

    public function edit(Movie $movie)
    {
        $genres = Genre::all();

        return view('movies.edit', compact('movie', 'genres'))
            ->with('directors', $this->directors);
    }

    public function update(Request $request, Movie $movie)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'director' => 'required|in:' . implode(',', $this->directors),
            'genre_id' => 'required|exists:genres,id',
            'year' => 'required|numeric|min:1900|max:2026',
        ]);

        $movie->update($validated);

        Log::info('Movie updated', [
            'id' => $movie->id,
        ]);

        return redirect()->route('movies.index')
            ->with('success', 'Movie updated successfully.');
    }

    public function destroy(Movie $movie)
{
    abort_if($movie->genre->movies()->count() === 1, 403);

    $movie->delete();

    return redirect()->route('movies.index')
        ->with('success', 'Movie deleted successfully.');
}

    public function featured()
    {
        $item = Movie::findOrFail(1);

        return view('movies.featured', ['item' => $item]);
    }
}
