<template>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Barangay Issues</h1>

        <!-- Submit button -->
        <Link href="/issues/create" class="mb-4 inline-block bg-blue-500 text-white px-4 py-2 rounded">
            Submit New Issue
        </Link>

        <!-- Issues Table -->
        <table class="min-w-full border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2">Title</th>
                    <th class="border px-4 py-2">Submitted By</th>
                    <th class="border px-4 py-2">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="issue in issues" :key="issue.id">
                    <td class="border px-4 py-2">
                        <Link :href="`/issues/${issue.id}`">{{ issue.title }}</Link>
                    </td>
                    <td class="border px-4 py-2">{{ issue.user.name }}</td>
                    <td class="border px-4 py-2">{{ issue.status }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AuthenticatedLayout.vue';

interface Issue {
    id: number;
    title: string;
    status: string;
    user: { name: string; };
}

// Props passed from Laravel controller
const props = defineProps<{ issues: Issue[]; }>();

// Use layout with navigation
defineOptions({
    layout: AppLayout,
});
</script>

<style scoped>
/* optional styling here */
</style>
