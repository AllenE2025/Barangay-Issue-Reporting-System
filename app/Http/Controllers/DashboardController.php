<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->isAdmin()) {
            return $this->adminDashboard();
        } else {
            return $this->userDashboard($user);
        }
    }

    private function adminDashboard(): Response
    {
        // Basic stats
        $totalIssues = Issue::count();
        $pendingIssues = Issue::where('status', 'pending')->count();
        $inProgressIssues = Issue::where('status', 'in_progress')->count();
        $resolvedIssues = Issue::where('status', 'resolved')->count();

        // Recent issues
        $recentIssues = Issue::with('user')
            ->latest()
            ->take(10)
            ->get();

        // Issues by category
        $issuesByCategory = Issue::select('category', DB::raw('count(*) as count'))
            ->groupBy('category')
            ->get();

        // Issues over time (last 30 days)
        $issuesOverTime = Issue::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('count(*) as count')
        )
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Issues by status (for chart)
        $issuesByStatus = [
            ['status' => 'Pending', 'count' => $pendingIssues],
            ['status' => 'In Progress', 'count' => $inProgressIssues],
            ['status' => 'Resolved', 'count' => $resolvedIssues],
        ];

        // Monthly comparison
        $thisMonth = Issue::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $lastMonth = Issue::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();

        return Inertia::render('Dashboard', [
            'isAdmin' => true,
            'stats' => [
                'total' => $totalIssues,
                'pending' => $pendingIssues,
                'in_progress' => $inProgressIssues,
                'resolved' => $resolvedIssues,
                'thisMonth' => $thisMonth,
                'lastMonth' => $lastMonth,
            ],
            'recentIssues' => $recentIssues,
            'issuesByCategory' => $issuesByCategory,
            'issuesByStatus' => $issuesByStatus,
            'issuesOverTime' => $issuesOverTime,
        ]);
    }

    private function userDashboard($user): Response
    {
        // Basic stats
        $totalIssues = $user->issues()->count();
        $pendingIssues = $user->issues()->where('status', 'pending')->count();
        $inProgressIssues = $user->issues()->where('status', 'in_progress')->count();
        $resolvedIssues = $user->issues()->where('status', 'resolved')->count();

        // Recent issues
        $recentIssues = $user->issues()
            ->latest()
            ->take(5)
            ->get();

        // Issues by status (for chart)
        $issuesByStatus = [
            ['status' => 'Pending', 'count' => $pendingIssues],
            ['status' => 'In Progress', 'count' => $inProgressIssues],
            ['status' => 'Resolved', 'count' => $resolvedIssues],
        ];

        return Inertia::render('Dashboard', [
            'isAdmin' => false,
            'stats' => [
                'total' => $totalIssues,
                'pending' => $pendingIssues,
                'in_progress' => $inProgressIssues,
                'resolved' => $resolvedIssues,
            ],
            'recentIssues' => $recentIssues,
            'issuesByStatus' => $issuesByStatus,
        ]);
    }
}
