<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Cart;
use App\Models\Order;
use App\Models\PublishingTracking;
use App\Models\Royalty;
use App\Models\PublishingSubmission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $user = $request->user();

        $carts = Cart::where('user_id', $user->id)
            ->with('book')
            ->latest()
            ->get();

        $orders = Order::where('user_id', $user->id)
            ->with('items')
            ->latest()
            ->get();

        $trackings = collect();
        $royalties = collect();

        if ($user->role === 'penulis') {
            $trackings = PublishingTracking::where('user_id', $user->id)
                ->latest()
                ->get();

            $royalties = Royalty::where('user_id', $user->id)
                ->latest()
                ->get();
        }

        // Semua user yang sudah membeli paket dan di-approve admin
        // tetap bisa melihat pengajuan penerbitannya di profil
        $submissions = PublishingSubmission::with('authors')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return view('profile.edit', [
            'user' => $user,
            'carts' => $carts,
            'orders' => $orders,
            'trackings' => $trackings,
            'royalties' => $royalties,
            'submissions' => $submissions,
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}