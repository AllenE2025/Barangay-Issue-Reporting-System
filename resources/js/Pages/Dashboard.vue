<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import {
    ClipboardDocumentListIcon,
    ClockIcon,
    ArrowPathIcon,
    CheckCircleIcon,
    PlusCircleIcon,
    EyeIcon,
    ArrowTrendingUpIcon,
    ArrowTrendingDownIcon
} from '@heroicons/vue/24/outline';
import DoughnutChart from '@/Components/Charts/DoughnutChart.vue';
import LineChart from '@/Components/Charts/LineChart.vue';
import BarChart from '@/Components/Charts/BarChart.vue';

interface Issue {
    id: number;
    title: string;
    category: string;
    location: string;
    status: string;
    created_at: string;
    user?: {
        name: string;
        email: string;
    };
}

interface CategoryCount {
    category: string;
    count: number;
}

interface StatusCount {
    status: string;
    count: number;
}

interface TimeSeriesData {
    date: string;
    count: number;
}

interface Props {
    isAdmin: boolean;
    stats: {
        total: number;
        pending: number;
        in_progress: number;
        resolved: number;
        thisMonth?: number;
        lastMonth?: number;
    };
    recentIssues: Issue[];
    issuesByCategory?: CategoryCount[];
    issuesByStatus?: StatusCount[];
    issuesOverTime?: TimeSeriesData[];
}

const props = defineProps<Props>();

const categoryChartData = computed(() => {
    if (!props.issuesByCategory) return null;
    const colors = ['#0F4C75', '#1a6898', '#F59E0B', '#C2714F', '#10b981', '#8b5cf6'];
    return {
        labels: props.issuesByCategory.map(item => item.category),
        datasets: [{
            data: props.issuesByCategory.map(item => item.count),
            backgroundColor: colors.slice(0, props.issuesByCategory.length),
        }]
    };
});

const statusChartData = computed(() => {
    if (!props.issuesByStatus) return null;
    const colors = { 'Pending': '#F59E0B', 'In Progress': '#0F4C75', 'Resolved': '#10b981' };
    return {
        labels: props.issuesByStatus.map(item => item.status),
        datasets: [{
            label: 'Issues by Status',
            data: props.issuesByStatus.map(item => item.count),
            backgroundColor: props.issuesByStatus.map(item => colors[item.status as keyof typeof colors]),
        }]
    };
});

const timeSeriesChartData = computed(() => {
    if (!props.issuesOverTime) return null;
    return {
        labels: props.issuesOverTime.map(item => {
            const date = new Date(item.date);
            return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
        }),
        datasets: [{
            label: 'Issues Reported',
            data: props.issuesOverTime.map(item => item.count),
            borderColor: '#0F4C75',
            backgroundColor: 'rgba(15, 76, 117, 0.08)',
            tension: 0.4,
        }]
    };
});

const monthlyChange = computed(() => {
    if (!props.stats.thisMonth || !props.stats.lastMonth) return null;
    const change = props.stats.thisMonth - props.stats.lastMonth;
    const percentChange = props.stats.lastMonth > 0
        ? ((change / props.stats.lastMonth) * 100).toFixed(1)
        : 0;
    return { value: change, percent: percentChange, isIncrease: change > 0 };
});
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ isAdmin ? 'Issues Overview' : 'My Issues Overview' }}
            </h2>
        </template>

        <div class="dash-wrap">
            <div class="dash-container">

                <!-- Stats Cards -->
                <div class="stats-grid">

                    <!-- Total -->
                    <div class="stat-card">
                        <div class="stat-icon-wrap stat-icon-primary">
                            <ClipboardDocumentListIcon class="stat-icon" />
                        </div>
                        <div class="stat-body">
                            <p class="stat-label">Total Issues</p>
                            <div class="stat-value-row">
                                <span class="stat-value">{{ stats.total }}</span>
                                <span v-if="monthlyChange" class="stat-change"
                                    :class="monthlyChange.isIncrease ? 'stat-change-up' : 'stat-change-down'">
                                    <ArrowTrendingUpIcon v-if="monthlyChange.isIncrease" class="change-icon" />
                                    <ArrowTrendingDownIcon v-else class="change-icon" />
                                    {{ Math.abs(Number(monthlyChange.percent)) }}%
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Pending -->
                    <div class="stat-card">
                        <div class="stat-icon-wrap stat-icon-amber">
                            <ClockIcon class="stat-icon" />
                        </div>
                        <div class="stat-body">
                            <p class="stat-label">Pending</p>
                            <span class="stat-value">{{ stats.pending }}</span>
                        </div>
                    </div>

                    <!-- In Progress -->
                    <div class="stat-card">
                        <div class="stat-icon-wrap stat-icon-blue">
                            <ArrowPathIcon class="stat-icon" />
                        </div>
                        <div class="stat-body">
                            <p class="stat-label">In Progress</p>
                            <span class="stat-value">{{ stats.in_progress }}</span>
                        </div>
                    </div>

                    <!-- Resolved -->
                    <div class="stat-card">
                        <div class="stat-icon-wrap stat-icon-green">
                            <CheckCircleIcon class="stat-icon" />
                        </div>
                        <div class="stat-body">
                            <p class="stat-label">Resolved</p>
                            <span class="stat-value">{{ stats.resolved }}</span>
                        </div>
                    </div>
                </div>

                <!-- Charts Row (Admin) -->
                <div v-if="isAdmin" class="charts-grid">
                    <div v-if="categoryChartData" class="dash-card">
                        <h3 class="dash-card-title">Issues by Category</h3>
                        <DoughnutChart :data="categoryChartData" />
                    </div>
                    <div v-if="statusChartData" class="dash-card">
                        <h3 class="dash-card-title">Issues by Status</h3>
                        <BarChart :data="statusChartData" />
                    </div>
                </div>

                <!-- Time Series (Admin) -->
                <div v-if="isAdmin && timeSeriesChartData" class="dash-card">
                    <h3 class="dash-card-title">Issues Reported — Last 30 Days</h3>
                    <LineChart :data="timeSeriesChartData" />
                </div>

                <!-- User Status Chart -->
                <div v-if="!isAdmin && statusChartData && stats.total > 0" class="dash-card">
                    <h3 class="dash-card-title">My Issues by Status</h3>
                    <div style="max-width: 360px; margin: 0 auto;">
                        <DoughnutChart :data="statusChartData" />
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="dash-card">
                    <h3 class="dash-card-title">Quick Actions</h3>
                    <div class="actions-row">
                        <Link v-if="!isAdmin" :href="route('issues.create')" class="action-btn action-btn-primary">
                            <PlusCircleIcon class="action-icon" />
                            Report New Issue
                        </Link>
                        <Link :href="isAdmin ? route('admin.issues.index') : route('issues.index')"
                            class="action-btn action-btn-secondary">
                            <EyeIcon class="action-icon" />
                            {{ isAdmin ? 'View All Issues' : 'View My Issues' }}
                        </Link>
                    </div>
                </div>

                <!-- Recent Issues -->
                <div class="dash-card">
                    <h3 class="dash-card-title">
                        {{ isAdmin ? 'Recent Issues (All Users)' : 'My Recent Issues' }}
                    </h3>

                    <!-- Empty state -->
                    <div v-if="recentIssues.length === 0" class="empty-state">
                        <ClipboardDocumentListIcon class="empty-icon" />
                        <p class="empty-title">No issues yet.</p>
                        <Link v-if="!isAdmin" :href="route('issues.create')" class="empty-link">
                            Report your first issue →
                        </Link>
                    </div>

                    <!-- Issues list -->
                    <div v-else class="issues-list">
                        <div v-for="issue in recentIssues" :key="issue.id" class="issue-row">
                            <div class="issue-row-body">
                                <div class="issue-row-main">
                                    <h4 class="issue-row-title">{{ issue.title }}</h4>
                                    <div class="issue-row-meta">
                                        <span class="meta-tag">{{ issue.category }}</span>
                                        <span class="meta-sep">·</span>
                                        <span>{{ issue.location }}</span>
                                        <template v-if="isAdmin && issue.user">
                                            <span class="meta-sep">·</span>
                                            <span>{{ issue.user.name }}</span>
                                        </template>
                                    </div>
                                    <p class="issue-row-date">
                                        {{ new Date(issue.created_at).toLocaleDateString('en-US', {
                                            month: 'short', day:
                                        'numeric', year: 'numeric' }) }}
                                    </p>
                                </div>
                                <div>
                                    <span class="status-badge" :class="{
                                        'status-pending': issue.status === 'pending',
                                        'status-progress': issue.status === 'in_progress',
                                        'status-resolved': issue.status === 'resolved'
                                    }">
                                        {{ issue.status.replace('_', ' ') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>
/* Dashboard layout */
.dash-wrap {
    padding: 2.5rem 0 3rem;
}

.dash-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1.5rem;
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

/* Stats grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.stat-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: all 0.25s;
}

.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 30px rgba(15, 76, 117, 0.09);
}

.stat-icon-wrap {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.stat-icon-primary {
    background: linear-gradient(135deg, var(--primary), #1a6898);
}

.stat-icon-amber {
    background: linear-gradient(135deg, #d97706, var(--accent));
}

.stat-icon-blue {
    background: linear-gradient(135deg, #1d4ed8, #3b82f6);
}

.stat-icon-green {
    background: linear-gradient(135deg, #059669, #10b981);
}

.stat-icon {
    width: 22px;
    height: 22px;
    color: white;
}

.stat-body {
    flex: 1;
    min-width: 0;
}

.stat-label {
    font-size: 0.8rem;
    font-weight: 600;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin: 0 0 4px;
}

.stat-value-row {
    display: flex;
    align-items: baseline;
    gap: 8px;
}

.stat-value {
    font-family: 'Playfair Display', serif;
    font-size: 2rem;
    font-weight: 800;
    color: var(--text);
    line-height: 1;
}

.stat-change {
    display: flex;
    align-items: center;
    gap: 2px;
    font-size: 0.78rem;
    font-weight: 600;
}

.stat-change-up {
    color: #dc2626;
}

.stat-change-down {
    color: #16a34a;
}

.change-icon {
    width: 13px;
    height: 13px;
}

/* Charts */
.charts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
}

/* Generic card */
.dash-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 1.75rem;
}

.dash-card-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--text);
    margin: 0 0 1.25rem;
}

/* Quick actions */
.actions-row {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
}

.action-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 10px 20px;
    border-radius: 9px;
    font-size: 0.875rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
    font-family: 'Source Sans 3', sans-serif;
}

.action-btn-primary {
    background: var(--primary);
    color: white;
    border: 2px solid var(--primary);
}

.action-btn-primary:hover {
    background: var(--primary-dark);
    border-color: var(--primary-dark);
    transform: translateY(-1px);
    box-shadow: 0 5px 16px rgba(15, 76, 117, 0.25);
}

.action-btn-secondary {
    background: transparent;
    color: var(--text);
    border: 2px solid var(--border);
}

.action-btn-secondary:hover {
    border-color: var(--primary);
    color: var(--primary);
    transform: translateY(-1px);
}

.action-icon {
    width: 17px;
    height: 17px;
}

/* Empty state */
.empty-state {
    text-align: center;
    padding: 3rem 1rem;
}

.empty-icon {
    width: 40px;
    height: 40px;
    color: var(--border);
    margin: 0 auto 0.75rem;
}

.empty-title {
    color: var(--text-muted);
    font-size: 1rem;
    margin: 0 0 0.5rem;
}

.empty-link {
    color: var(--primary);
    font-weight: 600;
    font-size: 0.875rem;
    text-decoration: none;
}

.empty-link:hover {
    text-decoration: underline;
}

/* Issues list */
.issues-list {
    display: flex;
    flex-direction: column;
    gap: 0;
}

.issue-row {
    padding: 1rem 0;
    border-bottom: 1px solid var(--border);
    transition: background 0.15s;
    border-radius: 0;
}

.issue-row:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.issue-row:first-child {
    padding-top: 0;
}

.issue-row:hover {
    background: rgba(15, 76, 117, 0.02);
    margin: 0 -0.5rem;
    padding-left: 0.5rem;
    padding-right: 0.5rem;
    border-radius: 8px;
}

.issue-row-body {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 1rem;
}

.issue-row-main {
    flex: 1;
    min-width: 0;
}

.issue-row-title {
    font-weight: 600;
    color: var(--text);
    font-size: 0.9rem;
    margin: 0 0 4px;
}

.issue-row-meta {
    display: flex;
    align-items: center;
    gap: 5px;
    flex-wrap: wrap;
    font-size: 0.8rem;
    color: var(--text-muted);
    margin-bottom: 3px;
}

.meta-tag {
    background: rgba(15, 76, 117, 0.07);
    color: var(--primary);
    padding: 1px 8px;
    border-radius: 999px;
    font-size: 0.75rem;
    font-weight: 600;
}

.meta-sep {
    color: var(--border);
}

.issue-row-date {
    font-size: 0.75rem;
    color: #9ca3af;
    margin: 0;
}

/* Status badges */
.status-badge {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 999px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: capitalize;
    white-space: nowrap;
}

.status-pending {
    background: #fef3c7;
    color: #92400e;
}

.status-progress {
    background: rgba(15, 76, 117, 0.1);
    color: var(--primary);
}

.status-resolved {
    background: #d1fae5;
    color: #065f46;
}
</style>