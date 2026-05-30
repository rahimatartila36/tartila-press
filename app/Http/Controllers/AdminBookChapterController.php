<?php

namespace App\Http\Controllers;

use App\Models\BookChapter;
use App\Models\Package;
use Illuminate\Http\Request;

class AdminBookChapterController extends Controller
{
    public function index()
    {
        $bookChapters = BookChapter::withCount('items')
            ->with('package')
            ->latest()
            ->get();

        return view('admin.book-chapters.index', compact('bookChapters'));
    }

    public function create()
    {
         $packages = Package::where('category', 'Book Chapter')
        ->where('is_active', true)
        ->get();

     return view('admin.book-chapters.create', compact('packages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cover' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'title' => 'required|string|max:255',
            'package_id' => 'nullable|exists:packages,id',
            'category' => 'nullable|string|max:255',
            'field' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'estimated_publish' => 'nullable|string|max:255',
            'package_id' => 'required|exists:packages,id',
        ]);

        $coverName = null;

        if ($request->hasFile('cover')) {
            $coverName = time() . '_' . $request->cover->getClientOriginalName();
            $request->cover->move(public_path('book-chapters'), $coverName);
        }

        BookChapter::create([
            'cover' => $coverName,
            'title' => $request->title,
            'package_id' => $request->package_id,
            'category' => $request->category,
            'field' => $request->field,
            'description' => $request->description,
            'estimated_publish' => $request->estimated_publish,
        ]);

        return redirect('/admin/book-chapters')
            ->with('success', 'Buku Book Chapter berhasil ditambahkan.');
    }

    public function edit($id)
    {
      $packages = Package::where('category', 'Book Chapter')
        ->where('is_active', true)
        ->get();

    return view('admin.book-chapters.edit', compact('bookChapter', 'packages'));
    }

    public function update(Request $request, $id)
    {
        $bookChapter = BookChapter::findOrFail($id);

        $request->validate([
            'cover' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'title' => 'required|string|max:255',
            'package_id' => 'nullable|exists:packages,id',
            'category' => 'nullable|string|max:255',
            'field' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'estimated_publish' => 'nullable|string|max:255',
            'package_id' => 'required|exists:packages,id',
        ]);

        $coverName = $bookChapter->cover;

        if ($request->hasFile('cover')) {
            $coverName = time() . '_' . $request->cover->getClientOriginalName();
            $request->cover->move(public_path('book-chapters'), $coverName);
        }

        $bookChapter->update([
            'cover' => $coverName,
            'title' => $request->title,
            'package_id' => $request->package_id,
            'category' => $request->category,
            'field' => $request->field,
            'description' => $request->description,
            'estimated_publish' => $request->estimated_publish,
        ]);

        return redirect('/admin/book-chapters')
            ->with('success', 'Buku Book Chapter berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $bookChapter = BookChapter::findOrFail($id);
        $bookChapter->delete();

        return redirect('/admin/book-chapters')
            ->with('success', 'Buku Book Chapter berhasil dihapus.');
    }
}