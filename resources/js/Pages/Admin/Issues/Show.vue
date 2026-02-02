<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';

interface Photo {
    id: number;
    filename: string;
    path: string;
}

interface Issue {
    id: number;
    title: string;
    description: string;
    category: string;
    location: string;
    status: string;
    admin_notes: string | null;
    created_at: string;
    photos?: Photo[];
    user: {
        name: string;
        email: string;
    };
}

const props = defineProps<{
    issue: Issue;
}>();

const form = useForm({
    status: props.issue.status,
    admin_notes: props.issue.admin_notes || '',
});

const submit = () => {
    form.patch(route('admin.issues.update', props.issue.id));
};
</script>

<template>

    <Head title="Issue Details" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Issue #{{ issue.id }} - {{ issue.title }}
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">
                <!-- Issue Details -->
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Issue Details</h3>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Submitted By</p>
                                <p class="font-medium">{{ issue.user.name }}</p>
                                <p class="text-sm text-gray-500">{{ issue.user.email }}</p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-600">Date Submitted</p>
                                <p class="font-medium">{{ new Date(issue.created_at).toLocaleString() }}</p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-600">Category</p>
                                <p class="font-medium">{{ issue.category }}</p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-600">Location</p>
                                <p class="font-medium">{{ issue.location }}</p>
                            </div>
                        </div>

                        <div class="mt-4">
                            <p class="text-sm text-gray-600">Description</p>
                            <p class="mt-2 text-gray-900">{{ issue.description }}</p>
                        </div>
                    </div>
                </div>

                <!-- Photos Section -->
                <div v-if="issue.photos && issue.photos.length > 0" class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Photos</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            <div v-for="photo in issue.photos" :key="photo.id" class="group relative">
                                <a :href="`/storage/${photo.path}`" target="_blank" rel="noopener noreferrer"
                                    class="block">
                                    <img :src="`/storage/${photo.path}`" :alt="photo.filename"
                                        class="w-full h-48 object-cover rounded-lg border-2 border-gray-200 group-hover:border-blue-500 transition" />
                                    <div
                                        class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition rounded-lg pointer-events-none">
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Update Status Form -->
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Update Issue Status</h3>

                        <form @submit.prevent="submit">
                            <!-- Status -->
                            <div>
                                <InputLabel for="status" value="Status" />
                                <select id="status" v-model="form.status"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    required>
                                    <option value="pending">Pending</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="resolved">Resolved</option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.status" />
                            </div>

                            <!-- Admin Notes -->
                            <div class="mt-4">
                                <InputLabel for="admin_notes" value="Admin Notes" />
                                <textarea id="admin_notes" v-model="form.admin_notes"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    rows="4" placeholder="Add notes about actions taken or updates..."></textarea>
                                <InputError class="mt-2" :message="form.errors.admin_notes" />
                            </div>

                            <!-- Submit Button -->
                            <div class="mt-6 flex items-center justify-end">
                                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Update Issue
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>