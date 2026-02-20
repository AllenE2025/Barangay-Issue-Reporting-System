<script setup lang="ts">
import { Link, Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { PhotoIcon, PlusCircleIcon, ClipboardDocumentListIcon, MapPinIcon, CalendarIcon, TagIcon } from '@heroicons/vue/24/outline';

interface Photo {
    id: number;
    filename: string;
    path: string;
    url: string;
}

interface Issue {
    id: number;
    title: string;
    description: string;
    category: string;
    location: string;
    status: string;
    created_at: string;
    photos?: Photo[];
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
            <h2 class="text-xl font-semibold leading-tight text-gray-800">My Issues</h2>
        </template>

        <div class="issues-wrap">
            <div class="issues-container">

                <!-- Toolbar -->
                <div class="issues-toolbar">
                    <p class="issues-count">
                        <span class="issues-count-num">{{ issues.length }}</span>
                        {{ issues.length === 1 ? 'issue' : 'issues' }} reported
                    </p>
                    <Link :href="route('issues.create')" class="btn-new">
                        <PlusCircleIcon class="btn-icon" />
                        Submit New Issue
                    </Link>
                </div>

                <!-- Empty State -->
                <div v-if="issues.length === 0" class="empty-state">
                    <div class="empty-icon-wrap">
                        <ClipboardDocumentListIcon class="empty-icon" />
                    </div>
                    <h3 class="empty-title">No issues yet</h3>
                    <p class="empty-sub">You haven't submitted any reports. Help improve the barangay by reporting your
                        first
                        issue.</p>
                    <Link :href="route('issues.create')" class="btn-new">
                        <PlusCircleIcon class="btn-icon" />
                        Submit Your First Issue
                    </Link>
                </div>

                <!-- Issues List -->
                <div v-else class="issues-list">
                    <div v-for="issue in issues" :key="issue.id" class="issue-card">

                        <!-- Photos strip (if any) -->
                        <div v-if="issue.photos && issue.photos.length > 0" class="issue-photos">
                            <img v-for="photo in issue.photos.slice(0, 3)" :key="photo.id"
                                :src="`/storage/${photo.path}`" :alt="photo.filename" class="issue-photo" />
                            <div v-if="issue.photos.length > 3" class="issue-photo-more">
                                +{{ issue.photos.length - 3 }}
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="issue-body">
                            <div class="issue-body-main">

                                <!-- Title row -->
                                <div class="issue-title-row">
                                    <h3 class="issue-title">{{ issue.title }}</h3>
                                    <span class="status-badge" :class="{
                                        'status-pending': issue.status === 'pending',
                                        'status-progress': issue.status === 'in_progress',
                                        'status-resolved': issue.status === 'resolved'
                                    }">
                                        {{ issue.status.replace('_', ' ') }}
                                    </span>
                                </div>

                                <!-- Meta row -->
                                <div class="issue-meta">
                                    <span class="meta-item">
                                        <TagIcon class="meta-icon" />
                                        {{ issue.category }}
                                    </span>
                                    <span class="meta-sep">·</span>
                                    <span class="meta-item">
                                        <MapPinIcon class="meta-icon" />
                                        {{ issue.location }}
                                    </span>
                                    <span class="meta-sep">·</span>
                                    <span class="meta-item">
                                        <CalendarIcon class="meta-icon" />
                                        {{ new Date(issue.created_at).toLocaleDateString('en-US', {
                                            month: 'short', day:
                                        'numeric', year: 'numeric' }) }}
                                    </span>
                                </div>

                                <!-- Description preview -->
                                <p class="issue-desc">{{ issue.description }}</p>

                            </div>

                            <!-- No photos indicator -->
                            <div v-if="!issue.photos || issue.photos.length === 0" class="no-photos">
                                <PhotoIcon class="no-photos-icon" />
                                <span>No photos</span>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>
/* Layout */
.issues-wrap {
    padding: 2.5rem 0 3rem;
}

.issues-container {
    max-width: 860px;
    margin: 0 auto;
    padding: 0 1.5rem;
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}

/* Toolbar */
.issues-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
}

.issues-count {
    font-size: 0.875rem;
    color: var(--text-muted);
    margin: 0;
}

.issues-count-num {
    font-family: 'Playfair Display', serif;
    font-size: 1.1rem;
    font-weight: 800;
    color: var(--text);
    margin-right: 4px;
}

/* New issue button */
.btn-new {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: var(--primary);
    color: white;
    padding: 9px 20px;
    border-radius: 9px;
    font-size: 0.875rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
    font-family: 'Source Sans 3', sans-serif;
    border: 2px solid var(--primary);
}

.btn-new:hover {
    background: var(--primary-dark);
    border-color: var(--primary-dark);
    transform: translateY(-1px);
    box-shadow: 0 5px 16px rgba(15, 76, 117, 0.25);
}

.btn-icon {
    width: 17px;
    height: 17px;
}

/* Empty state */
.empty-state {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 4rem 2rem;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.75rem;
}

.empty-icon-wrap {
    width: 60px;
    height: 60px;
    background: rgba(15, 76, 117, 0.06);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 0.5rem;
}

.empty-icon {
    width: 28px;
    height: 28px;
    color: var(--primary);
    opacity: 0.5;
}

.empty-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.3rem;
    font-weight: 800;
    color: var(--text);
    margin: 0;
}

.empty-sub {
    font-size: 0.9rem;
    color: var(--text-muted);
    max-width: 400px;
    line-height: 1.6;
    margin: 0;
}

/* Issues list */
.issues-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

/* Issue card */
.issue-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 14px;
    overflow: hidden;
    transition: all 0.25s;
}

.issue-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 30px rgba(15, 76, 117, 0.09);
    border-color: rgba(15, 76, 117, 0.18);
}

/* Photos strip */
.issue-photos {
    display: flex;
    gap: 3px;
    height: 100px;
    overflow: hidden;
    border-bottom: 1px solid var(--border);
}

.issue-photo {
    flex: 1;
    min-width: 0;
    object-fit: cover;
    display: block;
}

.issue-photo-more {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 60px;
    background: rgba(15, 76, 117, 0.08);
    font-size: 0.8rem;
    font-weight: 700;
    color: var(--primary);
}

/* Card body */
.issue-body {
    padding: 1.25rem 1.5rem;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 1rem;
}

.issue-body-main {
    flex: 1;
    min-width: 0;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

/* Title row */
.issue-title-row {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.issue-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.05rem;
    font-weight: 700;
    color: var(--text);
    margin: 0;
    line-height: 1.3;
}

/* Status badges */
.status-badge {
    display: inline-block;
    flex-shrink: 0;
    padding: 3px 10px;
    border-radius: 999px;
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: capitalize;
    white-space: nowrap;
    font-family: 'Source Sans 3', sans-serif;
    letter-spacing: 0.03em;
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

/* Meta */
.issue-meta {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 5px;
    font-size: 0.8rem;
    color: var(--text-muted);
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 3px;
}

.meta-icon {
    width: 13px;
    height: 13px;
    flex-shrink: 0;
}

.meta-sep {
    color: var(--border);
}

/* Description preview */
.issue-desc {
    font-size: 0.875rem;
    color: var(--text-muted);
    line-height: 1.6;
    margin: 0;
    display: -webkit-box;
    line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* No photos */
.no-photos {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
    padding: 0.5rem 0.75rem;
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: 9px;
    font-size: 0.72rem;
    color: var(--text-muted);
    flex-shrink: 0;
    white-space: nowrap;
}

.no-photos-icon {
    width: 18px;
    height: 18px;
    color: var(--border);
}
</style>