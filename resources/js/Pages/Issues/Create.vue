<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { ref } from 'vue';
import { PhotoIcon, XMarkIcon, PencilSquareIcon } from '@heroicons/vue/24/outline';

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
    const newPhotos = files.slice(0, 3 - form.photos.length);
    newPhotos.forEach(file => {
        form.photos.push(file);
        const reader = new FileReader();
        reader.onload = (e) => {
            photoPreviews.value.push(e.target?.result as string);
        };
        reader.readAsDataURL(file);
    });
    target.value = '';
};

const removePhoto = (index: number) => {
    form.photos.splice(index, 1);
    photoPreviews.value.splice(index, 1);
};

const submit = () => {
    form.post(route('issues.store'));
};

const categories = ['Infrastructure', 'Sanitation', 'Safety', 'Noise', 'Environment', 'Other'];
</script>

<template>

    <Head title="Report an Issue" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Report an Issue</h2>
        </template>

        <div class="create-wrap">
            <div class="create-container">

                <!-- Page intro -->
                <div class="create-intro">
                    <div class="create-intro-icon">
                        <PencilSquareIcon class="create-intro-svg" />
                    </div>
                    <div>
                        <h3 class="create-intro-title">Submit a New Report</h3>
                        <p class="create-intro-sub">Fill in the details below and we'll notify the barangay officials
                            right
                            away.</p>
                    </div>
                </div>

                <!-- Form Card -->
                <div class="create-card">
                    <form @submit.prevent="submit" class="create-form">

                        <!-- Two column: Title + Category -->
                        <div class="form-row-2">
                            <!-- Title -->
                            <div class="field">
                                <InputLabel for="title" value="Issue Title" class="field-label" />
                                <TextInput id="title" v-model="form.title" type="text"
                                    class="mt-1 block w-full field-input" required autofocus
                                    placeholder="Brief description of the issue" />
                                <InputError class="mt-2" :message="form.errors.title" />
                            </div>

                            <!-- Category -->
                            <div class="field">
                                <InputLabel for="category" value="Category" class="field-label" />
                                <div class="select-wrap" style="margin-top: 0.25rem;">
                                    <select id="category" v-model="form.category" class="field-input select-input"
                                        required>
                                        <option value="">Select a category</option>
                                        <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
                                    </select>
                                </div>
                                <InputError class="mt-2" :message="form.errors.category" />
                            </div>
                        </div>

                        <!-- Location -->
                        <div class="field">
                            <InputLabel for="location" value="Location" class="field-label" />
                            <TextInput id="location" v-model="form.location" type="text"
                                class="mt-1 block w-full field-input" required
                                placeholder="Where in the barangay is this issue?" />
                            <InputError class="mt-2" :message="form.errors.location" />
                        </div>

                        <!-- Description -->
                        <div class="field">
                            <InputLabel for="description" value="Description" class="field-label" />
                            <textarea id="description" v-model="form.description" class="field-input field-textarea"
                                rows="5" required
                                placeholder="Provide detailed information about the issue..."></textarea>
                            <InputError class="mt-2" :message="form.errors.description" />
                        </div>

                        <!-- Photos -->
                        <div class="field">
                            <InputLabel value="Photos (Optional)" class="field-label" />
                            <p class="field-hint">Add up to 3 photos to help illustrate the issue</p>

                            <!-- Previews -->
                            <div v-if="photoPreviews.length > 0" class="photo-grid">
                                <div v-for="(preview, index) in photoPreviews" :key="index" class="photo-thumb-wrap">
                                    <img :src="preview" alt="Preview" class="photo-thumb" />
                                    <button type="button" @click="removePhoto(index)" class="photo-remove">
                                        <XMarkIcon class="photo-remove-icon" />
                                    </button>
                                </div>
                            </div>

                            <!-- Upload zone -->
                            <div v-if="form.photos.length < 3">
                                <label for="photos" class="upload-zone">
                                    <PhotoIcon class="upload-icon" />
                                    <span class="upload-label">Click to upload photos</span>
                                    <span class="upload-hint">PNG, JPG up to 5MB &nbsp;·&nbsp; {{ 3 - form.photos.length
                                        }}
                                        remaining</span>
                                    <input id="photos" type="file" accept="image/jpeg,image/jpg,image/png" multiple
                                        class="hidden" @change="handlePhotoUpload" />
                                </label>
                            </div>

                            <InputError class="mt-2" :message="(form.errors as any).photos" />
                        </div>

                        <!-- Divider -->
                        <div class="form-divider"></div>

                        <!-- Submit -->
                        <div class="form-footer">
                            <p class="form-footer-note">Your report will be reviewed by barangay officials.</p>
                            <PrimaryButton class="submit-btn" :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing">
                                <PencilSquareIcon class="btn-icon" />
                                Submit Report
                            </PrimaryButton>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>
/* Layout */
.create-wrap {
    padding: 2.5rem 0 3rem;
}

.create-container {
    max-width: 780px;
    margin: 0 auto;
    padding: 0 1.5rem;
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

/* Intro banner */
.create-intro {
    display: flex;
    align-items: center;
    gap: 1rem;
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 1.25rem 1.5rem;
}

.create-intro-icon {
    width: 46px;
    height: 46px;
    flex-shrink: 0;
    background: linear-gradient(135deg, var(--primary), #1a6898);
    border-radius: 11px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 14px rgba(15, 76, 117, 0.2);
}

.create-intro-svg {
    width: 22px;
    height: 22px;
    color: white;
}

.create-intro-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.05rem;
    font-weight: 800;
    color: var(--text);
    margin: 0 0 2px;
}

.create-intro-sub {
    font-size: 0.85rem;
    color: var(--text-muted);
    margin: 0;
}

/* Form card */
.create-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 2rem;
}

/* Form */
.create-form {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}

.form-row-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.25rem;
}

@media (max-width: 580px) {
    .form-row-2 {
        grid-template-columns: 1fr;
    }
}

/* Fields */
.field {
    display: flex;
    flex-direction: column;
}

.field-label {
    font-size: 0.875rem !important;
    font-weight: 600 !important;
    color: var(--text) !important;
    margin-bottom: 0.35rem;
}

.field-hint {
    font-size: 0.775rem;
    color: var(--text-muted);
    margin: 0 0 0.6rem;
}

/* Inputs */
.field-input,
input[type="text"].field-input,
input[type="email"].field-input {
    border: 1px solid var(--border) !important;
    border-radius: 9px !important;
    padding: 10px 14px !important;
    font-family: 'Source Sans 3', sans-serif !important;
    font-size: 0.9rem !important;
    color: var(--text) !important;
    background: var(--bg) !important;
    transition: border-color 0.2s, box-shadow 0.2s !important;
    outline: none !important;
    width: 100% !important;
    box-sizing: border-box !important;
}

.field-input:focus,
input[type="text"].field-input:focus {
    border-color: var(--primary) !important;
    box-shadow: 0 0 0 3px rgba(15, 76, 117, 0.1) !important;
    background: white !important;
}

/* Textarea */
.field-textarea {
    resize: vertical;
    min-height: 120px;
    line-height: 1.6 !important;
}

.field-textarea:focus {
    border-color: var(--primary) !important;
    box-shadow: 0 0 0 3px rgba(15, 76, 117, 0.1) !important;
    background: white !important;
}

/* Select */
.select-wrap {
    position: relative;
}

.select-input {
    appearance: none !important;
    cursor: pointer !important;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='%236b7280'%3E%3Cpath fill-rule='evenodd' d='M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z' clip-rule='evenodd'/%3E%3C/svg%3E") !important;
    background-repeat: no-repeat !important;
    background-position: right 12px center !important;
    background-size: 16px !important;
    padding-right: 36px !important;
}

/* Photo grid */
.photo-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 0.75rem;
    margin-bottom: 0.75rem;
}

.photo-thumb-wrap {
    position: relative;
}

.photo-thumb {
    width: 100%;
    height: 110px;
    object-fit: cover;
    border-radius: 10px;
    border: 1px solid var(--border);
    display: block;
}

.photo-remove {
    position: absolute;
    top: 6px;
    right: 6px;
    background: rgba(220, 38, 38, 0.9);
    color: white;
    border: none;
    border-radius: 6px;
    padding: 4px;
    cursor: pointer;
    opacity: 0;
    transition: opacity 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
}

.photo-thumb-wrap:hover .photo-remove {
    opacity: 1;
}

.photo-remove-icon {
    width: 14px;
    height: 14px;
}

/* Upload zone */
.upload-zone {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 6px;
    width: 100%;
    height: 110px;
    border: 2px dashed var(--border);
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.2s;
    background: var(--bg);
}

.upload-zone:hover {
    border-color: var(--primary);
    background: rgba(15, 76, 117, 0.03);
}

.upload-icon {
    width: 28px;
    height: 28px;
    color: var(--text-muted);
}

.upload-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text);
}

.upload-hint {
    font-size: 0.775rem;
    color: var(--text-muted);
}

/* Divider */
.form-divider {
    height: 1px;
    background: var(--border);
    margin: 0.25rem 0;
}

/* Footer */
.form-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
}

.form-footer-note {
    font-size: 0.8rem;
    color: var(--text-muted);
    margin: 0;
}

/* Submit button */
.submit-btn {
    display: inline-flex !important;
    align-items: center !important;
    gap: 7px !important;
    background: var(--primary) !important;
    border-color: var(--primary) !important;
    border-radius: 10px !important;
    padding: 11px 24px !important;
    font-family: 'Source Sans 3', sans-serif !important;
    font-size: 0.9rem !important;
    font-weight: 600 !important;
    transition: all 0.2s !important;
    white-space: nowrap;
}

.submit-btn:hover:not(:disabled) {
    background: var(--primary-dark) !important;
    border-color: var(--primary-dark) !important;
    transform: translateY(-1px) !important;
    box-shadow: 0 6px 18px rgba(15, 76, 117, 0.28) !important;
}

.btn-icon {
    width: 17px;
    height: 17px;
}
</style>