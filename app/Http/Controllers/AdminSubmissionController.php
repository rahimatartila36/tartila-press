<?php

namespace App\Http\Controllers;

use App\Models\PublishingSubmission;
use Illuminate\Http\Request;

class AdminSubmissionController extends Controller
{
    public function index()
    {
        $submissions = PublishingSubmission::with(['user', 'package', 'authors'])
            ->latest()
            ->get();

        return view('admin.submissions.index', compact('submissions'));
    }

    public function show(PublishingSubmission $submission)
    {
        $submission->load(['user', 'package', 'authors']);

        return view('admin.submissions.show', compact('submission'));
    }

    public function updateStatus(Request $request, PublishingSubmission $submission)
    {
        $request->validate([
            'status' => 'required|string|max:255',
        ]);

        $submission->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Status submission berhasil diperbarui.');
    }
}