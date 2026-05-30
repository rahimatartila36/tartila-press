<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\BookChapterItem;
use App\Models\PublishingSubmission;

class AdminPaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with([
                'package',
                'book',
                'bookChapterItem'
            ])
            ->latest()
            ->get();

        return view('admin.payments.index', compact('payments'));
    }

    public function approve($id)
    {
        $payment = Payment::findOrFail($id);

        $payment->update([
            'status' => 'approved',
        ]);

        if ($payment->type === 'package') {

            if (!$payment->user_id) {
                return back()->with(
                    'error',
                    'Pembayaran disetujui, tetapi user_id kosong. Pengajuan penerbitan tidak bisa dibuat.'
                );
            }

            if (!$payment->package_id) {
                return back()->with(
                    'error',
                    'Pembayaran disetujui, tetapi package_id kosong. Pengajuan penerbitan tidak bisa dibuat.'
                );
            }

            PublishingSubmission::firstOrCreate(
                [
                    'payment_id' => $payment->id,
                ],
                [
                    'user_id' => $payment->user_id,
                    'package_id' => $payment->package_id,
                    'status' => 'menunggu_upload_naskah',
                ]
            );
        }

        if ($payment->type === 'book_chapter' && $payment->book_chapter_item_id) {
            $chapterItem = BookChapterItem::find($payment->book_chapter_item_id);

            if ($chapterItem) {
                $chapterItem->update([
                    'status' => 'sold',
                ]);
            }
        }

        return back()->with(
            'success',
            'Pembayaran berhasil disetujui.'
        );
    }

    public function reject($id)
    {
        $payment = Payment::findOrFail($id);

        $payment->update([
            'status' => 'rejected',
        ]);

        if ($payment->type === 'book_chapter' && $payment->book_chapter_item_id) {
            $chapterItem = BookChapterItem::find($payment->book_chapter_item_id);

            if ($chapterItem) {
                $chapterItem->update([
                    'status' => 'available',
                ]);
            }
        }

        return back()->with('success', 'Pembayaran ditolak.');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $payment = Payment::findOrFail($id);

        $payment->update([
            'status' => $request->status,
        ]);

        if ($payment->type === 'package' && in_array($request->status, ['approved', 'sudah bayar'])) {

            if (!$payment->user_id) {
                return back()->with(
                    'error',
                    'Status pembayaran diperbarui, tetapi user_id kosong. Pengajuan penerbitan tidak bisa dibuat.'
                );
            }

            if (!$payment->package_id) {
                return back()->with(
                    'error',
                    'Status pembayaran diperbarui, tetapi package_id kosong. Pengajuan penerbitan tidak bisa dibuat.'
                );
            }

            PublishingSubmission::firstOrCreate(
                [
                    'payment_id' => $payment->id,
                ],
                [
                    'user_id' => $payment->user_id,
                    'package_id' => $payment->package_id,
                    'status' => 'menunggu_upload_naskah',
                ]
            );
        }

        if ($payment->type === 'book_chapter' && $payment->book_chapter_item_id) {
            $chapterItem = BookChapterItem::find($payment->book_chapter_item_id);

            if ($chapterItem) {
                if ($request->status === 'approved' || $request->status === 'sudah bayar') {
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