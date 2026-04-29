<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Package;

class PaymentController extends Controller
{

public function create($id)
{
    $package = Package::findOrFail($id);

    return view(
        'landing.payment',
        compact('package')
    );
}

public function store(Request $request)
{

    $proofName = null;

    if($request->hasFile('proof')){

        $proofName =
        time().'.'.
        $request->proof->extension();

        $request->proof->move(
            public_path('payments'),
            $proofName
        );

    }

    Payment::create([

        'package_id' => $request->package_id,

        'name' => $request->name,

        'phone' => $request->phone,

        'proof' => $proofName,

        'status' => 'pending'

    ]);

    return redirect('/payment-success');

}

}