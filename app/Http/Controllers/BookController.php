<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();

        return view('admin.books.index',
        compact('books'));
    }

    public function create()
    {
        return view('admin.books.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        if ($request->hasFile('cover')) {

            $data['cover'] =
            $request->file('cover')
            ->store('books','public');

        }

        Book::create($data);

        return redirect('/admin/books');
    }
    public function edit($id)
{
    $book = Book::findOrFail($id);

    return view('admin.books.edit',
    compact('book'));
}

public function update(Request $request, $id)
{
    $book = Book::findOrFail($id);

    $data = $request->all();

    if ($request->hasFile('cover')) {

        $data['cover'] =
        $request->file('cover')
        ->store('books','public');

    }

    $book->update($data);

    return redirect('/admin/books');
}

public function destroy($id)
{
    $book = Book::findOrFail($id);

    $book->delete();

    return redirect('/admin/books');
}
}