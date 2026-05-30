<?php

namespace App\Http\Controllers;

use App\Models\Royalty;
use App\Models\User;
use Illuminate\Http\Request;

class AdminRoyaltyController extends Controller
{
    public function index()
    {
        $royalties = Royalty::with('user')
            ->latest()
            ->get();

        return view('admin.royalties.index', compact('royalties'));
    }

    public function create()
    {
        $users = User::orderBy('name')->get();

        return view('admin.royalties.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_title' => 'required|string|max:255',
            'sold_qty' => 'required|integer|min:0',
            'total_sales' => 'required|numeric|min:0',
            'royalty_percent' => 'required|numeric|min:0|max:100',
            'status' => 'required|string',
        ]);

        $royaltyAmount = $request->total_sales * ($request->royalty_percent / 100);

        Royalty::create([
            'user_id' => $request->user_id,
            'book_title' => $request->book_title,
            'sold_qty' => $request->sold_qty,
            'total_sales' => $request->total_sales,
            'royalty_percent' => $request->royalty_percent,
            'royalty_amount' => $royaltyAmount,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.royalties.index')
            ->with('success', 'Data royalti berhasil ditambahkan.');
    }

    public function edit(Royalty $royalty)
    {
        $users = User::orderBy('name')->get();

        return view('admin.royalties.edit', compact('royalty', 'users'));
    }

    public function update(Request $request, Royalty $royalty)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_title' => 'required|string|max:255',
            'sold_qty' => 'required|integer|min:0',
            'total_sales' => 'required|numeric|min:0',
            'royalty_percent' => 'required|numeric|min:0|max:100',
            'status' => 'required|string',
        ]);

        $royaltyAmount = $request->total_sales * ($request->royalty_percent / 100);

        $royalty->update([
            'user_id' => $request->user_id,
            'book_title' => $request->book_title,
            'sold_qty' => $request->sold_qty,
            'total_sales' => $request->total_sales,
            'royalty_percent' => $request->royalty_percent,
            'royalty_amount' => $royaltyAmount,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.royalties.index')
            ->with('success', 'Data royalti berhasil diperbarui.');
    }

    public function destroy(Royalty $royalty)
    {
        $royalty->delete();

        return back()->with('success', 'Data royalti berhasil dihapus.');
    }
}