<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookCatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query();

        // pencarian judul / penulis
        if ($request->search) {

            $query->where(function ($q) use ($request) {

                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('author', 'like', '%' . $request->search . '%');

            });

        }

        // filter kategori
        if ($request->kategori) {

            $query->where('kategori', $request->kategori);

        }

        // filter keilmuan
        if ($request->keilmuan) {

            $query->where('keilmuan', $request->keilmuan);

        }

        $books = $query->latest()
                       ->paginate(12)
                       ->withQueryString();

        // data kategori unik
        $kategoris = Book::whereNotNull('kategori')
            ->where('kategori', '!=', '')
            ->select('kategori')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        // data keilmuan unik
        $keilmuans = Book::whereNotNull('keilmuan')
            ->where('keilmuan', '!=', '')
            ->select('keilmuan')
            ->distinct()
            ->orderBy('keilmuan')
            ->pluck('keilmuan');

        return view('landing.books-catalog', compact(
            'books',
            'kategoris',
            'keilmuans'
        ));
    }
}