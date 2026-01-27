<script setup lang="ts">
import { Link, Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

interface Issue {
    id: number;
    title: string;
    description: string;
    category: string;
    location: string;
    status: string;
    created_at: string;
    user: {
        name: string;
    };
}

defineProps<{
    issues: Issue[];
}>();
</script>

<template>

    <Head title="My Issues" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                My Issues
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <!-- Submit button -->
                        <Link :href="route('issues.create')"
                            class="mb-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Submit New Issue
                        </Link>

                        <!-- Issues Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full border">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="border px-4 py-2 text-left">Title</th>
                                        <th class="border px-4 py-2 text-left">Category</th>
                                        <th class="border px-4 py-2 text-left">Location</th>
                                        <th class="border px-4 py-2 text-left">Status</th>
                                        <th class="border px-4 py-2 text-left">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="issues.length === 0">
                                        <td colspan="5" class="border px-4 py-2 text-center text-gray-500">
                                            No issues yet. Submit your first issue!
                                        </td>
                                    </tr>
                                    <tr v-for="issue in issues" :key="issue.id" class="hover:bg-gray-50">
                                        <td class="border px-4 py-2">
                                            {{ issue.title }}
                                        </td>
                                        <td class="border px-4 py-2">{{ issue.category }}</td>
                                        <td class="border px-4 py-2">{{ issue.location }}</td>
                                        <td class="border px-4 py-2">
                                            <span :class="{
                                                'bg-yellow-100 text-yellow-800': issue.status === 'pending',
                                                'bg-blue-100 text-blue-800': issue.status === 'in_progress',
                                                'bg-green-100 text-green-800': issue.status === 'resolved'
                                            }" class="px-2 py-1 rounded text-sm">
                                                {{ issue.status.replace('_', ' ') }}
                                            </span>
                                        </td>
                                        <td class="border px-4 py-2 text-sm text-gray-500">
                                            {{ new Date(issue.created_at).toLocaleDateString() }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>