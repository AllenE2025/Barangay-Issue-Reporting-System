<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import {
    ClipboardDocumentListIcon,
    ClockIcon,
    ArrowPathIcon,
    CheckCircleIcon,
    PlusCircleIcon,
    EyeIcon
} from '@heroicons/vue/24/outline';

// ... rest of your interfaces stay the same
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

interface Props {
    isAdmin: boolean;
    stats: {
        total: number;
        pending: number;
        in_progress: number;
        resolved: number;
    };
    recentIssues: Issue[];
    issuesByCategory?: CategoryCount[];
}

const props = defineProps<Props>();
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
                                        <dd class="text-3xl font-semibold text-gray-900">
                                            {{ stats.total }}
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
                                class="border rounded-lg p-4 hover:bg-gray-50">
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

                <!-- Issues by Category (Admin Only) -->
                <div v-if="isAdmin && issuesByCategory" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Issues by Category</h3>
                        <div class="space-y-3">
                            <div v-for="item in issuesByCategory" :key="item.category"
                                class="flex justify-between items-center">
                                <span class="text-gray-700">{{ item.category }}</span>
                                <span class="bg-gray-100 px-3 py-1 rounded-full text-sm font-medium">
                                    {{ item.count }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>