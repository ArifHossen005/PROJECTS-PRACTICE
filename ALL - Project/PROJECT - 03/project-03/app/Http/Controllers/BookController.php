<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class BookController extends Controller
{

    public function index()
    {
        $books = DB::table('books')
            ->join('authors', 'books.author_id', '=', 'authors.id')
            ->join('categories', 'books.category_id', '=', 'categories.id')
            ->select(
                'books.*',
                'authors.name as author_name',
                'categories.name as category_name'
            )
            ->latest('books.created_at')
            ->paginate(10);

        return view('books.index', compact('books'));
    }


    public function create()
    {

        $authors    = DB::table('authors')->pluck('name', 'id');
        $categories = DB::table('categories')->pluck('name', 'id');

        return view('books.create', compact('authors', 'categories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'isbn'        => 'required|string|unique:books,isbn',
            'author_id'   => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'published_at' => 'nullable|date',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);


        $coverImagePath = null;
        if ($request->hasFile('cover_image')) {
            $coverImagePath = $request->file('cover_image')->store('covers', 'public');
        }

        DB::table('books')->insert([
            'title'        => $request->title,
            'isbn'         => $request->isbn,
            'author_id'    => $request->author_id,
            'category_id'  => $request->category_id,
            'description'  => $request->description,
            'published_at' => $request->published_at,
            'cover_image'  => $coverImagePath,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        return redirect()->route('books.index')
            ->with('success', 'Book created successfully!');
    }


    public function show($id)
    {
        $book = DB::table('books')
            ->join('authors', 'books.author_id', '=', 'authors.id')
            ->join('categories', 'books.category_id', '=', 'categories.id')
            ->select('books.*', 'authors.name as author_name', 'categories.name as category_name')
            ->where('books.id', $id)
            ->first();

        if (!$book) {
            return redirect()->route('books.index')->with('error', 'Book not found.');
        }

        return view('books.show', compact('book'));
    }


    public function edit($id)
    {
        $book = DB::table('books')->where('id', $id)->first();

        if (!$book) {
            return redirect()->route('books.index')->with('error', 'Book not found.');
        }

        $authors    = DB::table('authors')->get();
        $categories = DB::table('categories')->get();

        return view('books.edit', compact('book', 'authors', 'categories'));
    }


    public function update(Request $request, $id)
    {

        $request->validate([
            'title'       => 'required|string|max:255',
            'isbn'        => 'required|string|unique:books,isbn,' . $id,
            'author_id'   => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'published_at' => 'nullable|date',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $book = DB::table('books')->where('id', $id)->first();
        $coverImagePath = $book->cover_image; // পুরনো image path রাখো

        if ($request->hasFile('cover_image')) {
            if ($coverImagePath) {
                Storage::disk('public')->delete($coverImagePath);
            }
            $coverImagePath = $request->file('cover_image')->store('covers', 'public');
        }

        DB::table('books')->where('id', $id)->update([
            'title'        => $request->title,
            'isbn'         => $request->isbn,
            'author_id'    => $request->author_id,
            'category_id'  => $request->category_id,
            'description'  => $request->description,
            'published_at' => $request->published_at,
            'cover_image'  => $coverImagePath,
            'updated_at'   => now(),
        ]);

        return redirect()->route('books.index')
            ->with('success', 'Book updated successfully!');
    }


    public function destroy($id)
    {
        $book = DB::table('books')->where('id', $id)->first();

        if ($book && $book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }

        DB::table('books')->where('id', $id)->delete();

        return redirect()->route('books.index')
            ->with('success', 'Book deleted successfully!');
    }
}
