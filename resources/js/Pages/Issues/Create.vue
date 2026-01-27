<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    title: '',
    description: '',
    category: '',
    location: '',
});

const submit = () => {
    form.post(route('issues.store'));
};

const categories = [
    'Infrastructure',
    'Sanitation',
    'Safety',
    'Noise',
    'Environment',
    'Other'
];
</script>

<template>

    <Head title="Report an Issue" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Report an Issue
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submit">
                            <!-- Title -->
                            <div>
                                <InputLabel for="title" value="Title" />
                                <TextInput id="title" v-model="form.title" type="text" class="mt-1 block w-full"
                                    required autofocus placeholder="Brief description of the issue" />
                                <InputError class="mt-2" :message="form.errors.title" />
                            </div>

                            <!-- Category -->
                            <div class="mt-4">
                                <InputLabel for="category" value="Category" />
                                <select id="category" v-model="form.category"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    required>
                                    <option value="">Select a category</option>
                                    <option v-for="cat in categories" :key="cat" :value="cat">
                                        {{ cat }}
                                    </option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.category" />
                            </div>

                            <!-- Location -->
                            <div class="mt-4">
                                <InputLabel for="location" value="Location" />
                                <TextInput id="location" v-model="form.location" type="text" class="mt-1 block w-full"
                                    required placeholder="Where in the barangay is this issue?" />
                                <InputError class="mt-2" :message="form.errors.location" />
                            </div>

                            <!-- Description -->
                            <div class="mt-4">
                                <InputLabel for="description" value="Description" />
                                <textarea id="description" v-model="form.description"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    rows="5" required
                                    placeholder="Provide detailed information about the issue"></textarea>
                                <InputError class="mt-2" :message="form.errors.description" />
                            </div>

                            <!-- Submit Button -->
                            <div class="mt-6 flex items-center justify-end gap-4">
                                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Submit Issue
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>