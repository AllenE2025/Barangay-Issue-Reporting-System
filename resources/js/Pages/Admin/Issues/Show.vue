<script setup lang="ts">
import { Head, useForm, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import {
    UserCircleIcon,
    CalendarIcon,
    TagIcon,
    MapPinIcon,
    DocumentTextIcon,
    PhotoIcon,
    ArrowLeftIcon,
    CheckCircleIcon,
    ClockIcon,
    ArrowPathIcon
} from '@heroicons/vue/24/outline';

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
                Issue #{{ issue.id }} — {{ issue.title }}
            </h2>
        </template>

        <div class="show-wrap">
            <div class="show-container">

                <!-- Back link -->
                <Link :href="route('admin.issues.index')" class="back-link">
                    <ArrowLeftIcon class="back-icon" />
                    Back to All Issues
                </Link>

                <!-- Top: Issue title + current status -->
                <div class="show-hero">
                    <div class="show-hero-left">
                        <span class="show-id">#{{ issue.id }}</span>
                        <h1 class="show-title">{{ issue.title }}</h1>
                    </div>
                    <span class="status-badge status-badge-lg" :class="{
                        'status-pending': issue.status === 'pending',
                        'status-progress': issue.status === 'in_progress',
                        'status-resolved': issue.status === 'resolved'
                    }">
                        <ClockIcon v-if="issue.status === 'pending'" class="status-icon" />
                        <ArrowPathIcon v-else-if="issue.status === 'in_progress'" class="status-icon" />
                        <CheckCircleIcon v-else class="status-icon" />
                        {{ issue.status.replace('_', ' ') }}
                    </span>
                </div>

                <div class="show-grid">

                    <!-- LEFT COLUMN -->
                    <div class="show-left">

                        <!-- Details Card -->
                        <div class="show-card">
                            <h3 class="show-card-title">
                                <DocumentTextIcon class="card-title-icon" />
                                Issue Details
                            </h3>

                            <div class="details-grid">
                                <!-- Submitted by -->
                                <div class="detail-item">
                                    <p class="detail-label">Submitted By</p>
                                    <div class="user-cell">
                                        <div class="user-avatar">{{ issue.user.name.charAt(0).toUpperCase() }}</div>
                                        <div>
                                            <p class="user-name">{{ issue.user.name }}</p>
                                            <p class="user-email">{{ issue.user.email }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Date -->
                                <div class="detail-item">
                                    <p class="detail-label">Date Submitted</p>
                                    <div class="detail-value-row">
                                        <CalendarIcon class="detail-icon" />
                                        <span class="detail-value">{{ new Date(issue.created_at).toLocaleString('en-US',
                                            {
                                            month: 'short', day: 'numeric', year: 'numeric', hour: '2-digit', minute:
                                            '2-digit'
                                            }) }}</span>
                                    </div>
                                </div>

                                <!-- Category -->
                                <div class="detail-item">
                                    <p class="detail-label">Category</p>
                                    <span class="category-pill">
                                        <TagIcon class="pill-icon" />
                                        {{ issue.category }}
                                    </span>
                                </div>

                                <!-- Location -->
                                <div class="detail-item">
                                    <p class="detail-label">Location</p>
                                    <div class="detail-value-row">
                                        <MapPinIcon class="detail-icon" />
                                        <span class="detail-value">{{ issue.location }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="description-block">
                                <p class="detail-label">Description</p>
                                <p class="description-text">{{ issue.description }}</p>
                            </div>
                        </div>

                        <!-- Photos Card -->
                        <div v-if="issue.photos && issue.photos.length > 0" class="show-card">
                            <h3 class="show-card-title">
                                <PhotoIcon class="card-title-icon" />
                                Photos
                                <span class="photo-count">{{ issue.photos.length }}</span>
                            </h3>
                            <div class="photos-grid">
                                <a v-for="photo in issue.photos" :key="photo.id" :href="`/storage/${photo.path}`"
                                    target="_blank" rel="noopener noreferrer" class="photo-link">
                                    <img :src="`/storage/${photo.path}`" :alt="photo.filename" class="photo-img" />
                                    <div class="photo-overlay">
                                        <span class="photo-overlay-text">View Full</span>
                                    </div>
                                </a>
                            </div>
                        </div>

                    </div>

                    <!-- RIGHT COLUMN: Update form -->
                    <div class="show-right">
                        <div class="show-card update-card">
                            <h3 class="show-card-title">
                                <ArrowPathIcon class="card-title-icon" />
                                Update Status
                            </h3>

                            <form @submit.prevent="submit" class="update-form">

                                <!-- Status select -->
                                <div class="field">
                                    <InputLabel for="status" value="Status" class="field-label" />
                                    <div class="select-wrap" style="margin-top: 0.25rem;">
                                        <select id="status" v-model="form.status" class="field-input select-input"
                                            required>
                                            <option value="pending">Pending</option>
                                            <option value="in_progress">In Progress</option>
                                            <option value="resolved">Resolved</option>
                                        </select>
                                    </div>
                                    <InputError class="mt-2" :message="form.errors.status" />
                                </div>

                                <!-- Status preview chips -->
                                <div class="status-chips">
                                    <span class="status-chip"
                                        :class="form.status === 'pending' ? 'chip-active-pending' : 'chip-inactive'">
                                        <ClockIcon class="chip-icon" /> Pending
                                    </span>
                                    <span class="status-chip"
                                        :class="form.status === 'in_progress' ? 'chip-active-progress' : 'chip-inactive'">
                                        <ArrowPathIcon class="chip-icon" /> In Progress
                                    </span>
                                    <span class="status-chip"
                                        :class="form.status === 'resolved' ? 'chip-active-resolved' : 'chip-inactive'">
                                        <CheckCircleIcon class="chip-icon" /> Resolved
                                    </span>
                                </div>

                                <!-- Admin notes -->
                                <div class="field">
                                    <InputLabel for="admin_notes" value="Admin Notes" class="field-label" />
                                    <textarea id="admin_notes" v-model="form.admin_notes"
                                        class="field-input field-textarea" rows="5"
                                        placeholder="Add notes about actions taken or updates..."></textarea>
                                    <InputError class="mt-2" :message="form.errors.admin_notes" />
                                </div>

                                <!-- Existing notes display -->
                                <div v-if="issue.admin_notes" class="existing-notes">
                                    <p class="existing-notes-label">Previous Notes</p>
                                    <p class="existing-notes-text">{{ issue.admin_notes }}</p>
                                </div>

                                <!-- Submit -->
                                <PrimaryButton class="submit-btn" :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing">
                                    <CheckCircleIcon class="btn-icon" />
                                    Update Issue
                                </PrimaryButton>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>
/* Layout */
.show-wrap {
    padding: 2rem 0 3rem;
}

.show-container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 1.5rem;
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

/* Back link */
.back-link {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-muted);
    text-decoration: none;
    transition: color 0.2s;
}

.back-link:hover {
    color: var(--primary);
}

.back-icon {
    width: 15px;
    height: 15px;
    transition: transform 0.2s;
}

.back-link:hover .back-icon {
    transform: translateX(-2px);
}

/* Hero row */
.show-hero {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 1rem;
    flex-wrap: wrap;
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 1.5rem;
}

.show-hero-left {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.show-id {
    font-size: 0.78rem;
    font-weight: 700;
    color: var(--text-muted);
    font-family: monospace;
}

.show-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.4rem;
    font-weight: 800;
    color: var(--text);
    margin: 0;
    line-height: 1.2;
}

/* Two-column grid */
.show-grid {
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 1.5rem;
    align-items: flex-start;
}

@media (max-width: 768px) {
    .show-grid {
        grid-template-columns: 1fr;
    }
}

.show-left {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.show-right {
    display: flex;
    flex-direction: column;
}

/* Cards */
.show-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 1.75rem;
}

.show-card-title {
    display: flex;
    align-items: center;
    gap: 8px;
    font-family: 'Playfair Display', serif;
    font-size: 1.05rem;
    font-weight: 800;
    color: var(--text);
    margin: 0 0 1.5rem;
}

.card-title-icon {
    width: 18px;
    height: 18px;
    color: var(--primary);
    flex-shrink: 0;
}

.photo-count {
    margin-left: auto;
    background: rgba(15, 76, 117, 0.08);
    color: var(--primary);
    font-size: 0.72rem;
    font-weight: 700;
    font-family: 'Source Sans 3', sans-serif;
    padding: 2px 8px;
    border-radius: 999px;
}

/* Details grid */
.details-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.25rem;
    margin-bottom: 1.5rem;
}

@media (max-width: 500px) {
    .details-grid {
        grid-template-columns: 1fr;
    }
}

.detail-item {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.detail-label {
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    color: var(--text-muted);
    margin: 0;
}

.detail-value-row {
    display: flex;
    align-items: center;
    gap: 5px;
}

.detail-icon {
    width: 14px;
    height: 14px;
    color: var(--text-muted);
    flex-shrink: 0;
}

.detail-value {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text);
}

/* User cell */
.user-cell {
    display: flex;
    align-items: center;
    gap: 9px;
}

.user-avatar {
    width: 32px;
    height: 32px;
    flex-shrink: 0;
    background: var(--primary);
    color: white;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.85rem;
    font-weight: 700;
}

.user-name {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text);
    margin: 0 0 1px;
}

.user-email {
    font-size: 0.72rem;
    color: var(--text-muted);
    margin: 0;
}

/* Category pill */
.category-pill {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    background: rgba(15, 76, 117, 0.07);
    color: var(--primary);
    border: 1px solid rgba(15, 76, 117, 0.14);
    padding: 4px 10px;
    border-radius: 999px;
    font-size: 0.78rem;
    font-weight: 600;
}

.pill-icon {
    width: 12px;
    height: 12px;
}

/* Description */
.description-block {
    border-top: 1px solid var(--border);
    padding-top: 1.25rem;
}

.description-text {
    font-size: 0.9rem;
    color: var(--text);
    line-height: 1.75;
    margin: 0.5rem 0 0;
}

/* Photos */
.photos-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 0.75rem;
}

.photo-link {
    display: block;
    position: relative;
    border-radius: 10px;
    overflow: hidden;
}

.photo-img {
    width: 100%;
    height: 140px;
    object-fit: cover;
    display: block;
    transition: transform 0.3s;
}

.photo-overlay {
    position: absolute;
    inset: 0;
    background: rgba(15, 76, 117, 0);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s;
}

.photo-overlay-text {
    color: white;
    font-size: 0.78rem;
    font-weight: 700;
    opacity: 0;
    transition: opacity 0.2s;
}

.photo-link:hover .photo-img {
    transform: scale(1.03);
}

.photo-link:hover .photo-overlay {
    background: rgba(15, 76, 117, 0.45);
}

.photo-link:hover .photo-overlay-text {
    opacity: 1;
}

/* Update form card */
.update-card {
    position: sticky;
    top: 80px;
}

.update-form {
    display: flex;
    flex-direction: column;
    gap: 1.1rem;
}

/* Status badge — large variant */
.status-badge-lg {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    border-radius: 999px;
    font-size: 0.82rem;
    font-weight: 700;
    text-transform: capitalize;
    font-family: 'Source Sans 3', sans-serif;
}

.status-icon {
    width: 14px;
    height: 14px;
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

/* Status chips (visual preview) */
.status-chips {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
}

.status-chip {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 4px 10px;
    border-radius: 999px;
    font-size: 0.72rem;
    font-weight: 600;
    font-family: 'Source Sans 3', sans-serif;
    transition: all 0.15s;
    cursor: default;
}

.chip-icon {
    width: 12px;
    height: 12px;
}

.chip-inactive {
    background: var(--bg);
    color: var(--text-muted);
    border: 1px solid var(--border);
    opacity: 0.5;
}

.chip-active-pending {
    background: #fef3c7;
    color: #92400e;
    border: 1px solid #fde68a;
    opacity: 1;
}

.chip-active-progress {
    background: rgba(15, 76, 117, 0.1);
    color: var(--primary);
    border: 1px solid rgba(15, 76, 117, 0.2);
    opacity: 1;
}

.chip-active-resolved {
    background: #d1fae5;
    color: #065f46;
    border: 1px solid #a7f3d0;
    opacity: 1;
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

.field-input,
input[type="text"].field-input {
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

.field-input:focus {
    border-color: var(--primary) !important;
    box-shadow: 0 0 0 3px rgba(15, 76, 117, 0.1) !important;
    background: white !important;
}

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

/* Existing notes */
.existing-notes {
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: 9px;
    padding: 0.875rem 1rem;
}

.existing-notes-label {
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    color: var(--text-muted);
    margin: 0 0 4px;
}

.existing-notes-text {
    font-size: 0.85rem;
    color: var(--text);
    margin: 0;
    line-height: 1.6;
}

/* Submit */
.submit-btn {
    width: 100% !important;
    justify-content: center !important;
    background: var(--primary) !important;
    border-color: var(--primary) !important;
    border-radius: 10px !important;
    padding: 12px 24px !important;
    font-family: 'Source Sans 3', sans-serif !important;
    font-size: 0.9rem !important;
    font-weight: 600 !important;
    display: flex !important;
    align-items: center !important;
    gap: 8px !important;
    transition: all 0.2s !important;
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