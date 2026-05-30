<?php

namespace App\Http\Controllers;

use App\Models\BookChapter;
use Illuminate\Http\Request;

class BookChapterController extends Controller
{
    public function index(Request $request)
{
    $fields = BookChapter::whereNotNull('field')
        ->where('field', '!=', '')
        ->select('field')
        ->distinct()
        ->pluck('field');

    $bookChapters = BookChapter::with(['items', 'package'])
        ->when($request->filled('field'), function ($query) use ($request) {
            $query->where('field', $request->field);
        })
        ->latest()
        ->get();

    return view('landing.book-chapters.index', compact(
        'bookChapters',
        'fields'
    ));
}

    public function show($id)
    {
        $bookChapter = BookChapter::with(['items', 'package'])->findOrFail($id);

        return view('landing.book-chapters.show', compact('bookChapter'));
    }
}