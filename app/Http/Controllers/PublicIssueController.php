<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PublicIssueController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Issue::with('user')
            ->where('status', 'resolved'); // Only show resolved issues

        // Filter by category if provided
        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%')
                    ->orWhere('location', 'like', '%' . $request->search . '%');
            });
        }

        // Get resolved issues
        $issues = $query->latest('updated_at')->paginate(12);

        // Get statistics
        $stats = [
            'resolved' => Issue::where('status', 'resolved')->count(),
            'in_progress' => Issue::where('status', 'in_progress')->count(),
            'pending' => Issue::where('status', 'pending')->count(),
            'avg_resolution_days' => $this->getAverageResolutionTime(),
        ];

        // Get categories for filter
        $categories = Issue::select('category')
            ->distinct()
            ->pluck('category');

        return Inertia::render('Public/Issues', [
            'issues' => $issues,
            'stats' => $stats,
            'categories' => $categories,
            'filters' => [
                'search' => $request->search,
                'category' => $request->category ?? 'all',
            ],
        ]);
    }

    private function getAverageResolutionTime()
    {
        $resolved = Issue::where('status', 'resolved')
            ->whereNotNull('updated_at')
            ->get();

        if ($resolved->isEmpty()) {
            return 0;
        }

        $totalDays = $resolved->sum(function ($issue) {
            return $issue->created_at->diffInDays($issue->updated_at);
        });

        return round($totalDays / $resolved->count(), 1);
    }
}
