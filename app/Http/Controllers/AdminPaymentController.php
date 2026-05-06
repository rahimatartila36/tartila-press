<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

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
        $payment = Payment::findOrFail($id);
        $payment->status = $request->status;
        $payment->save();

        return back()->with('success', 'Status pembayaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();

        return back()->with('success', 'Data pembayaran berhasil dihapus.');
    }

}