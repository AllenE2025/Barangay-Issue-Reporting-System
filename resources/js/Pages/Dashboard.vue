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

// Chart data for category distribution
const categoryChartData = computed(() => {
    if (!props.issuesByCategory) return null;

    const colors = [
        '#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899'
    ];

    return {
        labels: props.issuesByCategory.map(item => item.category),
        datasets: [{
            data: props.issuesByCategory.map(item => item.count),
            backgroundColor: colors.slice(0, props.issuesByCategory.length),
        }]
    };
});

// Chart data for status distribution
const statusChartData = computed(() => {
    if (!props.issuesByStatus) return null;

    const colors = {
        'Pending': '#f59e0b',
        'In Progress': '#3b82f6',
        'Resolved': '#10b981'
    };

    return {
        labels: props.issuesByStatus.map(item => item.status),
        datasets: [{
            label: 'Issues by Status',
            data: props.issuesByStatus.map(item => item.count),
            backgroundColor: props.issuesByStatus.map(item => colors[item.status as keyof typeof colors]),
        }]
    };
});

// Chart data for issues over time
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
            borderColor: '#3b82f6',
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            tension: 0.4,
        }]
    };
});

// Calculate month-over-month change
const monthlyChange = computed(() => {
    if (!props.stats.thisMonth || !props.stats.lastMonth) return null;

    const change = props.stats.thisMonth - props.stats.lastMonth;
    const percentChange = props.stats.lastMonth > 0
        ? ((change / props.stats.lastMonth) * 100).toFixed(1)
        : 0;

    return {
        value: change,
        percent: percentChange,
        isIncrease: change > 0
    };
});
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ isAdmin ? 'Admin Dashboard' : 'My Dashboard' }}
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                    <!-- Total Issues -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                    <ClipboardDocumentListIcon class="h-6 w-6 text-white" />
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">
                                            Total Issues
                                        </dt>
                                        <dd class="flex items-baseline">
                                            <div class="text-3xl font-semibold text-gray-900">
                                                {{ stats.total }}
                                            </div>
                                            <div v-if="monthlyChange"
                                                class="ml-2 flex items-baseline text-sm font-semibold"
                                                :class="monthlyChange.isIncrease ? 'text-red-600' : 'text-green-600'">
                                                <ArrowTrendingUpIcon v-if="monthlyChange.isIncrease"
                                                    class="h-4 w-4 mr-0.5" />
                                                <ArrowTrendingDownIcon v-else class="h-4 w-4 mr-0.5" />
                                                {{ Math.abs(Number(monthlyChange.percent)) }}%
                                            </div>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Issues -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                                    <ClockIcon class="h-6 w-6 text-white" />
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">
                                            Pending
                                        </dt>
                                        <dd class="text-3xl font-semibold text-gray-900">
                                            {{ stats.pending }}
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- In Progress Issues -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-blue-600 rounded-md p-3">
                                    <ArrowPathIcon class="h-6 w-6 text-white" />
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">
                                            In Progress
                                        </dt>
                                        <dd class="text-3xl font-semibold text-gray-900">
                                            {{ stats.in_progress }}
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Resolved Issues -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                    <CheckCircleIcon class="h-6 w-6 text-white" />
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">
                                            Resolved
                                        </dt>
                                        <dd class="text-3xl font-semibold text-gray-900">
                                            {{ stats.resolved }}
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Row (Admin Only) -->
                <div v-if="isAdmin" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Issues by Category -->
                    <div v-if="categoryChartData" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Issues by Category</h3>
                            <DoughnutChart :data="categoryChartData" />
                        </div>
                    </div>

                    <!-- Issues by Status -->
                    <div v-if="statusChartData" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Issues by Status</h3>
                            <BarChart :data="statusChartData" />
                        </div>
                    </div>
                </div>

                <!-- Issues Over Time (Admin Only) -->
                <div v-if="isAdmin && timeSeriesChartData" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Issues Reported (Last 30 Days)</h3>
                        <LineChart :data="timeSeriesChartData" />
                    </div>
                </div>

                <!-- User Status Chart (For Regular Users) -->
                <div v-if="!isAdmin && statusChartData && stats.total > 0"
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">My Issues by Status</h3>
                        <div class="max-w-md mx-auto">
                            <DoughnutChart :data="statusChartData" />
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                        <div class="flex flex-wrap gap-4">
                            <Link v-if="!isAdmin" :href="route('issues.create')"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                <PlusCircleIcon class="h-5 w-5" />
                                Report New Issue
                            </Link>
                            <Link :href="isAdmin ? route('admin.issues.index') : route('issues.index')"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                <EyeIcon class="h-5 w-5" />
                                {{ isAdmin ? 'View All Issues' : 'View My Issues' }}
                            </Link>
                        </div>
                    </div>
                </div>

                <!-- Recent Issues -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">
                            {{ isAdmin ? 'Recent Issues (All Users)' : 'My Recent Issues' }}
                        </h3>

                        <div v-if="recentIssues.length === 0" class="text-center py-8 text-gray-500">
                            <p>No issues yet.</p>
                            <Link v-if="!isAdmin" :href="route('issues.create')"
                                class="text-blue-600 hover:underline mt-2 inline-block">
                                Report your first issue
                            </Link>
                        </div>

                        <div v-else class="space-y-4">
                            <div v-for="issue in recentIssues" :key="issue.id"
                                class="border rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h4 class="font-medium text-gray-900">{{ issue.title }}</h4>
                                        <div class="mt-1 text-sm text-gray-500 space-x-4">
                                            <span>{{ issue.category }}</span>
                                            <span>{{ issue.location }}</span>
                                            <span v-if="isAdmin && issue.user">by {{ issue.user.name }}</span>
                                        </div>
                                        <p class="text-xs text-gray-400 mt-1">
                                            {{ new Date(issue.created_at).toLocaleDateString() }}
                                        </p>
                                    </div>
                                    <div class="ml-4">
                                        <span :class="{
                                            'bg-yellow-100 text-yellow-800': issue.status === 'pending',
                                            'bg-blue-100 text-blue-800': issue.status === 'in_progress',
                                            'bg-green-100 text-green-800': issue.status === 'resolved'
                                        }" class="px-2 py-1 rounded text-xs font-medium">
                                            {{ issue.status.replace('_', ' ') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>