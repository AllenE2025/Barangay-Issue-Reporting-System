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
        $issues= $user->issues()->with('user')->latest()->get();

        return Inertia::render('Issues/Index', ['issues' => $issues,]);
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
            'location' => 'required|string|max:255'
        ]);

        $request->user()->issues()->create($validated);

        return redirect()->route('issues.index')->with('success', 'Issue submitted!');
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
