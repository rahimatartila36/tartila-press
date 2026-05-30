<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\BookChapterItem;

class AdminPaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['package', 'book'])
        ->latest()
        ->get();

         return view('admin.payments.index', compact('payments'));
    }
    

    public function approve($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->status = 'approved';
        $payment->save();

        return back()->with('success', 'Pembayaran disetujui');
    }

    public function reject($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->status = 'rejected';
        $payment->save();

        return back()->with('success', 'Pembayaran ditolak');
    }

    public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required',
    ]);

    $payment = Payment::findOrFail($id);

    $payment->update([
        'status' => $request->status,
    ]);

    if ($payment->type === 'book_chapter' && $payment->book_chapter_item_id) {
        $chapterItem = \App\Models\BookChapterItem::find($payment->book_chapter_item_id);

        if ($chapterItem) {
            if ($request->status === 'sudah bayar') {
                $chapterItem->update([
                    'status' => 'sold',
                ]);
            }

            if ($request->status === 'belum bayar' || $request->status === 'rejected') {
                $chapterItem->update([
                    'status' => 'available',
                ]);
            }

            if ($request->status === 'pending') {
                $chapterItem->update([
                    'status' => 'pending',
                ]);
            }
        }
    }

    return back()->with('success', 'Status pembayaran berhasil diperbarui.');
}

    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();

        return back()->with('success', 'Data pembayaran berhasil dihapus.');
    }

}