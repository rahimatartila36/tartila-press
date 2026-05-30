<?php

namespace App\Http\Controllers;

use App\Models\BookChapter;
use App\Models\BookChapterItem;
use Illuminate\Http\Request;

class AdminBookChapterItemController extends Controller
{
    public function index($bookChapterId)
    {
        $bookChapter = BookChapter::with(['items', 'package'])->findOrFail($bookChapterId);

        return view('admin.book-chapter-items.index', compact('bookChapter'));
    }

    public function store(Request $request, $bookChapterId)
    {
        $bookChapter = BookChapter::findOrFail($bookChapterId);

        $request->validate([
            'chapter_title' => 'required|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'status' => 'required|in:available,pending,sold',
        ]);

        BookChapterItem::create([
            'book_chapter_id' => $bookChapter->id,
            'chapter_title' => $request->chapter_title,
            'price' => $request->price,
            'discount' => $request->discount,
            'status' => $request->status,
        ]);

        return back()->with('success', 'Bab berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $item = BookChapterItem::findOrFail($id);

        $request->validate([
            'chapter_title' => 'required|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'status' => 'required|in:available,pending,sold',
        ]);

        $item->update([
            'chapter_title' => $request->chapter_title,
            'price' => $request->price,
            'discount' => $request->discount,
            'status' => $request->status,
        ]);

        return back()->with('success', 'Bab berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $item = BookChapterItem::findOrFail($id);
        $item->delete();

        return back()->with('success', 'Bab berhasil dihapus.');
    }
}