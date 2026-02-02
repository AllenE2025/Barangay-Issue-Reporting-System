<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\Issue;
use Inertia\Response;

class IssueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $issues = $user->issues()->with('user', 'photos')->latest()->get();

        return Inertia::render('Issues/Index', [
            'issues' => $issues,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Issues/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'location' => 'required|string|max:255',
            'photos.*' => 'nullable|image|mimes:jpeg,jpg,png|max:5120', // 5MB max per image
        ]);

    // Create the issue
        /** @var \App\Models\User $user */
        $user = $request->user();
        $issue = $user->issues()->create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'location' => $validated['location'],
        ]);

        // Handle photo uploads
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                // Store the photo in storage/app/public/issue-photos
                $path = $photo->store('issue-photos', 'public');

                // Save photo info to database
                $issue->photos()->create([
                    'filename' => $photo->getClientOriginalName(),
                    'path' => $path,
                    'size' => $photo->getSize(),
                ]);
            }
        }

        return redirect()->route('issues.index')->with('success', 'Issue submitted successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Issue $issue)
    {
        return inertia::render('Issues/Show', [
            'issue' => $issue->load('user'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
