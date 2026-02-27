<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AuthorController extends Controller
{

    public function index()
    {

        $authors = DB::table('authors')->latest()->paginate(10);

        return view('authors.index', compact('authors'));
    }


    public function create()
    {
        return view('authors.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'bio'  => 'required|string',  // text field, কোনো max নেই
        ]);

        DB::table('authors')->insert([
            'name'       => $request->name,
            'bio'        => $request->bio,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('authors.index')
            ->with('success', 'Author created successfully!');
    }


    public function edit($id)
    {
        $author = DB::table('authors')->where('id', $id)->first();

        if (!$author) {
            return redirect()->route('authors.index')->with('error', 'Author not found.');
        }

        return view('authors.edit', compact('author'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'bio'  => 'required|string',
        ]);

        DB::table('authors')->where('id', $id)->update([
            'name'       => $request->name,
            'bio'        => $request->bio,
            'updated_at' => now(),
        ]);

        return redirect()->route('authors.index')
            ->with('success', 'Author updated successfully!');
    }


    public function destroy($id)
    {
        DB::table('authors')->where('id', $id)->delete();

        return redirect()->route('authors.index')
            ->with('success', 'Author deleted successfully!');
    }
}
