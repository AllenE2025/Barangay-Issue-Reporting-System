<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Issue;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AdminIssueController extends Controller
{
    // Show all issues for admin
    public function index(): Response
    {
        $issues = Issue::with('user', 'photos')->latest()->get();

        return Inertia::render('Admin/Issues/Index', [
            'issues' => $issues,
        ]);
    }

    // Show single issue detail for admin
    public function show(Issue $issue): Response
    {
        return Inertia::render('Admin/Issues/Show', [
            'issue' => $issue->load('user', 'photos'),
        ]);
    }

    // Update issue status
    public function update(Request $request, Issue $issue)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,resolved',
            'admin_notes' => 'nullable|string',
        ]);

        $issue->update($validated);

        return redirect()->back()->with('success', 'Issue updated successfully!');
    }
}
