<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\User;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('user')
            ->latest()
            ->get();

        return view('admin.books.index', compact('books'));
    }

    public function create()
    {
        $users = User::whereIn('role', ['penulis', 'user'])
            ->orderBy('name')
            ->get();

        return view('admin.books.create', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'nullable|exists:users,id',

            'title' => 'required|string|max:255',
            'author' => 'required|string',
            'year' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'isbn' => 'nullable|string|max:255',
            'editor' => 'nullable|string',
            'penyunting' => 'nullable|string',
            'desain' => 'nullable|string',
            'penerbit' => 'nullable|string',

            'kategori' => 'nullable|string|max:255',
            'keilmuan' => 'nullable|string|max:255',

            'tahun_terbit' => 'nullable|string|max:255',
            'harga' => 'nullable|numeric',
            'diskon' => 'nullable|numeric|min:0|max:100',
        ]);

        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('books', 'public');
        }

        Book::create($data);

        return redirect('/admin/books')
            ->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $book = Book::findOrFail($id);

        $users = User::whereIn('role', ['penulis', 'user'])
            ->orderBy('name')
            ->get();

        return view('admin.books.edit', compact('book', 'users'));
    }

    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $data = $request->validate([
            'user_id' => 'nullable|exists:users,id',

            'title' => 'required|string|max:255',
            'author' => 'required|string',
            'year' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'isbn' => 'nullable|string|max:255',
            'editor' => 'nullable|string',
            'penyunting' => 'nullable|string',
            'desain' => 'nullable|string',
            'penerbit' => 'nullable|string',

            'kategori' => 'nullable|string|max:255',
            'keilmuan' => 'nullable|string|max:255',

            'tahun_terbit' => 'nullable|string|max:255',
            'harga' => 'nullable|numeric',
            'diskon' => 'nullable|numeric|min:0|max:100',
        ]);

        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('books', 'public');
        }

        $book->update($data);

        return redirect('/admin/books')
            ->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);

        $book->delete();

        return redirect('/admin/books')
            ->with('success', 'Buku berhasil dihapus.');
    }
}