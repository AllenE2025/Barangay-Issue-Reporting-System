<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { ref } from 'vue';
import { PhotoIcon, XMarkIcon } from '@heroicons/vue/24/outline';

const form = useForm({
    title: '',
    description: '',
    category: '',
    location: '',
    photos: [] as File[],
});

const photoPreviews = ref<string[]>([]);

const handlePhotoUpload = (event: Event) => {
    const target = event.target as HTMLInputElement;
    const files = Array.from(target.files || []);

    // Limit to 3 photos
    const newPhotos = files.slice(0, 3 - form.photos.length);

    newPhotos.forEach(file => {
        // Add to form
        form.photos.push(file);

        // Create preview
        const reader = new FileReader();
        reader.onload = (e) => {
            photoPreviews.value.push(e.target?.result as string);
        };
        reader.readAsDataURL(file);
    });

    // Clear input
    target.value = '';
};

const removePhoto = (index: number) => {
    form.photos.splice(index, 1);
    photoPreviews.value.splice(index, 1);
};

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

                            <!-- Photos Upload -->
                            <div class="mt-4">
                                <InputLabel value="Photos (Optional)" />
                                <p class="text-sm text-gray-500 mb-2">Add up to 3 photos to help illustrate the issue
                                </p>

                                <!-- Photo Previews -->
                                <div v-if="photoPreviews.length > 0" class="grid grid-cols-3 gap-4 mb-4">
                                    <div v-for="(preview, index) in photoPreviews" :key="index" class="relative group">
                                        <img :src="preview" alt="Preview"
                                            class="w-full h-32 object-cover rounded-lg border-2 border-gray-300" />
                                        <button type="button" @click="removePhoto(index)"
                                            class="absolute top-2 right-2 bg-red-500 text-white p-1 rounded-full hover:bg-red-600 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <XMarkIcon class="h-4 w-4" />
                                        </button>
                                    </div>
                                </div>

                                <!-- Upload Button -->
                                <div v-if="form.photos.length < 3">
                                    <label for="photos"
                                        class="flex items-center justify-center w-full h-32 px-4 transition bg-white border-2 border-gray-300 border-dashed rounded-lg appearance-none cursor-pointer hover:border-gray-400 focus:outline-none">
                                        <div class="flex flex-col items-center space-y-2">
                                            <PhotoIcon class="w-8 h-8 text-gray-400" />
                                            <span class="font-medium text-gray-600">
                                                Click to upload photos
                                            </span>
                                            <span class="text-xs text-gray-500">
                                                PNG, JPG up to 5MB ({{ 3 - form.photos.length }} remaining)
                                            </span>
                                        </div>
                                        <input id="photos" type="file" accept="image/jpeg,image/jpg,image/png" multiple
                                            class="hidden" @change="handlePhotoUpload" />
                                    </label>
                                </div>

                                <InputError class="mt-2" :message="form.errors.photos" />
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