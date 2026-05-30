<?php

namespace App\Http\Controllers;

use App\Models\PublishingSubmission;
use App\Models\PublishingAuthor;
use Illuminate\Http\Request;

class PublishingSubmissionController extends Controller
{
    public function edit(PublishingSubmission $submission)
    {
        if ($submission->user_id !== auth()->id()) {
            abort(403);
        }

        $submission->load('authors');

        return view('publishing-submissions.edit', compact('submission'));
    }

    public function update(Request $request, PublishingSubmission $submission)
    {
        if ($submission->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'book_title' => 'required|string|max:255',
            'manuscript_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',

            'authors' => 'required|array|min:1|max:5',
            'authors.*.name' => 'required|string|max:255',
            'authors.*.phone' => 'nullable|string|max:30',
            'authors.*.nik' => 'nullable|string|max:30',
            'authors.*.address' => 'nullable|string',
            'authors.*.email' => 'nullable|email|max:255',
        ]);

        $data = [
            'book_title' => $request->book_title,
            'status' => 'naskah_dikirim',
        ];

        if ($request->hasFile('manuscript_file')) {
            $data['manuscript_file'] = $request->file('manuscript_file')
                ->store('manuscripts', 'public');
        }

        $submission->update($data);

        $submission->authors()->delete();

        foreach ($request->authors as $index => $author) {
            PublishingAuthor::create([
                'publishing_submission_id' => $submission->id,
                'name' => $author['name'],
                'phone' => $author['phone'] ?? null,
                'nik' => $author['nik'] ?? null,
                'address' => $author['address'] ?? null,
                'email' => $author['email'] ?? null,
                'order' => $index + 1,
            ]);
        }

        return redirect()->route('profile.edit')
            ->with('success', 'Naskah berhasil dikirim dan menunggu pengecekan admin.');
    }
}