<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import {
    MagnifyingGlassIcon,
    CheckCircleIcon,
    ClockIcon,
    MapPinIcon,
    CalendarIcon,
    FunnelIcon,
    DocumentTextIcon
} from '@heroicons/vue/24/outline';

interface Issue {
    id: number;
    title: string;
    description: string;
    category: string;
    location: string;
    status: string;
    admin_notes: string | null;
    created_at: string;
    updated_at: string;
    user: {
        name: string;
    };
}

interface Props {
    issues: {
        data: Issue[];
        links: any[];
        current_page: number;
        last_page: number;
    };
    stats: {
        resolved: number;
        in_progress: number;
        pending: number;
        avg_resolution_days: number;
    };
    categories: string[];
    filters: {
        search?: string;
        category: string;
    };
}

const props = defineProps<Props>();

const search = ref(props.filters.search || '');
const category = ref(props.filters.category || 'all');

// Debounced search
let searchTimeout: NodeJS.Timeout;
watch(search, (value) => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        router.get('/community-progress',
            { search: value, category: category.value },
            { preserveState: true, replace: true }
        );
    }, 500);
});

watch(category, (value) => {
    router.get('/community-progress',
        { search: search.value, category: value },
        { preserveState: true, replace: true }
    );
});

const getDaysToResolve = (created: string, updated: string) => {
    const start = new Date(created);
    const end = new Date(updated);
    const days = Math.ceil((end.getTime() - start.getTime()) / (1000 * 60 * 60 * 24));
    return days;
};
</script>

<template>

    <Head title="Community Progress" />

    <div class="min-h-screen bg-gray-50">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <Link :href="route('home')" class="text-xl font-bold text-gray-900 place-items-center flex gap-2">
                            <DocumentTextIcon class="h-6 w-6 text-blue-600" />
                            Barangay Issue System
                        </Link>
                    </div>
                    <div class="flex items-center space-x-4">
                        <Link :href="route('login')"
                            class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                            Log in
                        </Link>
                        <Link :href="route('register')"
                            class="bg-blue-600 text-white hover:bg-blue-700 px-4 py-2 rounded-md text-sm font-medium">
                            Register
                        </Link>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h1 class="text-4xl font-bold mb-4">Community Progress Dashboard</h1>
                    <p class="text-xl text-blue-100">
                        See what we've accomplished together
                    </p>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 text-center">
                        <div class="text-3xl font-bold mb-2">{{ stats.resolved }}</div>
                        <div class="text-blue-100">Issues Resolved</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 text-center">
                        <div class="text-3xl font-bold mb-2">{{ stats.in_progress }}</div>
                        <div class="text-blue-100">In Progress</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 text-center">
                        <div class="text-3xl font-bold mb-2">{{ stats.pending }}</div>
                        <div class="text-blue-100">Pending</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 text-center">
                        <div class="text-3xl font-bold mb-2">{{ stats.avg_resolution_days }}</div>
                        <div class="text-blue-100">Avg Days to Resolve</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Filters -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
                <div class="flex flex-col md:flex-row gap-4">
                    <!-- Search -->
                    <div class="flex-1">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <MagnifyingGlassIcon class="h-5 w-5 text-gray-400" />
                            </div>
                            <input v-model="search" type="text" placeholder="Search resolved issues..."
                                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                        </div>
                    </div>

                    <!-- Category Filter -->
                    <div class="md:w-64">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <FunnelIcon class="h-5 w-5 text-gray-400" />
                            </div>
                            <select v-model="category"
                                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="all">All Categories</option>
                                <option v-for="cat in categories" :key="cat" :value="cat">
                                    {{ cat }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Results Count -->
            <div class="mb-6">
                <p class="text-gray-600">
                    Showing <span class="font-medium">{{ issues.data.length }}</span> resolved issues
                </p>
            </div>

            <!-- Issues Grid -->
            <div v-if="issues.data.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div v-for="issue in issues.data" :key="issue.id"
                    class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow p-6">
                    <!-- Status Badge -->
                    <div class="flex items-center gap-2 mb-3">
                        <CheckCircleIcon class="h-5 w-5 text-green-600" />
                        <span class="text-sm font-medium text-green-600">Resolved</span>
                    </div>

                    <!-- Title -->
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">
                        {{ issue.title }}
                    </h3>

                    <!-- Location & Category -->
                    <div class="space-y-2 mb-4 text-sm text-gray-600">
                        <div class="flex items-center gap-2">
                            <MapPinIcon class="h-4 w-4" />
                            <span>{{ issue.location }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs font-medium">
                                {{ issue.category }}
                            </span>
                        </div>
                    </div>

                    <!-- Timeline -->
                    <div class="border-t pt-4 space-y-2 text-sm text-gray-600">
                        <div class="flex items-center gap-2">
                            <CalendarIcon class="h-4 w-4" />
                            <span>Reported: {{ new Date(issue.created_at).toLocaleDateString() }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <CheckCircleIcon class="h-4 w-4" />
                            <span>Resolved: {{ new Date(issue.updated_at).toLocaleDateString() }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <ClockIcon class="h-4 w-4" />
                            <span class="font-medium text-green-600">
                                {{ getDaysToResolve(issue.created_at, issue.updated_at) }} days
                            </span>
                        </div>
                    </div>

                    <!-- Admin Notes -->
                    <div v-if="issue.admin_notes" class="mt-4 p-3 bg-gray-50 rounded text-sm text-gray-700">
                        <p class="font-medium text-gray-900 mb-1">Resolution:</p>
                        <p>{{ issue.admin_notes }}</p>
                    </div>
                </div>
            </div>

            <!-- No Results -->
            <div v-else class="bg-white rounded-lg shadow-sm p-12 text-center">
                <p class="text-gray-500 text-lg">No resolved issues found.</p>
                <p class="text-gray-400 text-sm mt-2">Try adjusting your filters or search terms.</p>
            </div>

            <!-- Pagination -->
            <div v-if="issues.last_page > 1" class="mt-8 flex justify-center">
                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                    <Link v-for="link in issues.links" :key="link.label" :href="link.url" :class="[
                        'relative inline-flex items-center px-4 py-2 border text-sm font-medium',
                        link.active
                            ? 'z-10 bg-blue-600 border-blue-600 text-white'
                            : 'bg-white border-gray-300 text-gray-700 hover:bg-gray-50'
                    ]" v-html="link.label" />
                </nav>
            </div>
        </div>

        <!-- Footer CTA -->
        <div class="bg-blue-600 py-12 mt-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
                <h2 class="text-3xl font-bold mb-4">Have an Issue to Report?</h2>
                <p class="text-xl text-blue-100 mb-8">
                    Help us continue improving our community
                </p>
                <Link :href="route('register')"
                    class="inline-block bg-white text-blue-600 hover:bg-blue-50 px-8 py-3 rounded-md font-semibold">
                    Get Started
                </Link>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-gray-800 py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <p class="text-center text-gray-400 text-sm">
                    © 2026 Barangay Issue Reporting System. Transparency for our community.
                </p>
            </div>
        </footer>
    </div>
</template>