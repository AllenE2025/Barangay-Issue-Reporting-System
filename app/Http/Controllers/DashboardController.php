<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->isAdmin()) {
            // Admin Dashboard Data
            $totalIssues = Issue::count();
            $pendingIssues = Issue::where('status', 'pending')->count();
            $inProgressIssues = Issue::where('status', 'in_progress')->count();
            $resolvedIssues = Issue::where('status', 'resolved')->count();

            $recentIssues = Issue::with('user')
                ->latest()
                ->take(10)
                ->get();

            $issuesByCategory = Issue::selectRaw('category, count(*) as count')
                ->groupBy('category')
                ->get();

            return Inertia::render('Dashboard', [
                'isAdmin' => true,
                'stats' => [
                    'total' => $totalIssues,
                    'pending' => $pendingIssues,
                    'in_progress' => $inProgressIssues,
                    'resolved' => $resolvedIssues,
                ],
                'recentIssues' => $recentIssues,
                'issuesByCategory' => $issuesByCategory,
            ]);
        } else {
            // User Dashboard Data
            $totalIssues = $user->issues()->count();
            $pendingIssues = $user->issues()->where('status', 'pending')->count();
            $inProgressIssues = $user->issues()->where('status', 'in_progress')->count();
            $resolvedIssues = $user->issues()->where('status', 'resolved')->count();

            $recentIssues = $user->issues()
                ->latest()
                ->take(5)
                ->get();

            return Inertia::render('Dashboard', [
                'isAdmin' => false,
                'stats' => [
                    'total' => $totalIssues,
                    'pending' => $pendingIssues,
                    'in_progress' => $inProgressIssues,
                    'resolved' => $resolvedIssues,
                ],
                'recentIssues' => $recentIssues,
            ]);
        }
    }
}
