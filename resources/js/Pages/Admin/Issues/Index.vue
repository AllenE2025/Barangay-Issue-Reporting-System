<script setup lang="ts">
import { Link, Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {
    ClipboardDocumentListIcon,
    MapPinIcon,
    CalendarIcon,
    TagIcon,
    UserCircleIcon,
    HashtagIcon
} from '@heroicons/vue/24/outline';

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
        email: string;
    };
}

defineProps<{
    issues: Issue[];
}>();
</script>

<template>

    <Head title="Admin - All Issues" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">All Issues</h2>
        </template>

        <div class="admin-wrap">
            <div class="admin-container">

                <!-- Toolbar -->
                <div class="admin-toolbar">
                    <div class="admin-toolbar-left">
                        <p class="admin-count">
                            <span class="admin-count-num">{{ issues.length }}</span>
                            total {{ issues.length === 1 ? 'issue' : 'issues' }}
                        </p>
                    </div>
                    <!-- Status legend -->
                    <div class="status-legend">
                        <span class="legend-item"><span class="legend-dot dot-pending"></span>Pending</span>
                        <span class="legend-item"><span class="legend-dot dot-progress"></span>In Progress</span>
                        <span class="legend-item"><span class="legend-dot dot-resolved"></span>Resolved</span>
                    </div>
                </div>

                <!-- Empty State -->
                <div v-if="issues.length === 0" class="admin-empty">
                    <div class="empty-icon-wrap">
                        <ClipboardDocumentListIcon class="empty-icon" />
                    </div>
                    <h3 class="empty-title">No issues reported yet</h3>
                    <p class="empty-sub">When community members submit reports, they'll appear here.</p>
                </div>

                <!-- Issues Table Card -->
                <div v-else class="admin-table-card">
                    <div class="admin-table-wrap">
                        <table class="admin-table">
                            <thead>
                                <tr class="admin-thead-row">
                                    <th class="admin-th admin-th-id">
                                        <HashtagIcon class="th-icon" />
                                    </th>
                                    <th class="admin-th">Title</th>
                                    <th class="admin-th">Submitted By</th>
                                    <th class="admin-th">Category</th>
                                    <th class="admin-th">Location</th>
                                    <th class="admin-th">Status</th>
                                    <th class="admin-th">Date</th>
                                    <th class="admin-th admin-th-action">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="issue in issues" :key="issue.id" class="admin-row">
                                    <!-- ID -->
                                    <td class="admin-td admin-td-id">
                                        <span class="issue-id">#{{ issue.id }}</span>
                                    </td>

                                    <!-- Title -->
                                    <td class="admin-td">
                                        <p class="issue-title-cell">{{ issue.title }}</p>
                                        <p class="issue-desc-cell">{{ issue.description }}</p>
                                    </td>

                                    <!-- User -->
                                    <td class="admin-td">
                                        <div class="user-cell">
                                            <div class="user-avatar">
                                                {{ issue.user.name.charAt(0).toUpperCase() }}
                                            </div>
                                            <div>
                                                <p class="user-name">{{ issue.user.name }}</p>
                                                <p class="user-email">{{ issue.user.email }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Category -->
                                    <td class="admin-td">
                                        <span class="category-pill">
                                            <TagIcon class="pill-icon" />
                                            {{ issue.category }}
                                        </span>
                                    </td>

                                    <!-- Location -->
                                    <td class="admin-td">
                                        <span class="location-cell">
                                            <MapPinIcon class="cell-icon" />
                                            {{ issue.location }}
                                        </span>
                                    </td>

                                    <!-- Status -->
                                    <td class="admin-td">
                                        <span class="status-badge" :class="{
                                            'status-pending': issue.status === 'pending',
                                            'status-progress': issue.status === 'in_progress',
                                            'status-resolved': issue.status === 'resolved'
                                        }">
                                            {{ issue.status.replace('_', ' ') }}
                                        </span>
                                    </td>

                                    <!-- Date -->
                                    <td class="admin-td">
                                        <span class="date-cell">
                                            <CalendarIcon class="cell-icon" />
                                            {{ new Date(issue.created_at).toLocaleDateString('en-US', {
                                                month: 'short',
                                            day:
                                            'numeric', year: 'numeric' }) }}
                                        </span>
                                    </td>

                                    <!-- Action -->
                                    <td class="admin-td admin-td-action">
                                        <Link :href="route('admin.issues.show', issue.id)" class="view-btn">
                                            View
                                        </Link>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>
/* Layout */
.admin-wrap {
    padding: 2.5rem 0 3rem;
}

.admin-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 1.5rem;
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}

/* Toolbar */
.admin-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
}

.admin-count {
    font-size: 0.875rem;
    color: var(--text-muted);
    margin: 0;
}

.admin-count-num {
    font-family: 'Playfair Display', serif;
    font-size: 1.1rem;
    font-weight: 800;
    color: var(--text);
    margin-right: 4px;
}

.admin-toolbar-left {
    display: flex;
    align-items: center;
    gap: 1rem;
}

/* Status legend */
.status-legend {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 0.78rem;
    color: var(--text-muted);
    font-weight: 500;
}

.legend-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    flex-shrink: 0;
}

.dot-pending {
    background: #f59e0b;
}

.dot-progress {
    background: var(--primary);
}

.dot-resolved {
    background: #10b981;
}

/* Empty state */
.admin-empty {
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
    max-width: 360px;
    line-height: 1.6;
    margin: 0;
}

/* Table card */
.admin-table-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 14px;
    overflow: hidden;
}

.admin-table-wrap {
    overflow-x: auto;
}

.admin-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 900px;
}

/* Table head */
.admin-thead-row {
    background: var(--bg);
    border-bottom: 2px solid var(--border);
}

.admin-th {
    padding: 12px 16px;
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.07em;
    color: var(--text-muted);
    text-align: left;
    white-space: nowrap;
    font-family: 'Source Sans 3', sans-serif;
}

.admin-th-id {
    width: 56px;
}

.admin-th-action {
    width: 80px;
    text-align: center;
}

.th-icon {
    width: 14px;
    height: 14px;
    color: var(--text-muted);
}

/* Table rows */
.admin-row {
    border-bottom: 1px solid var(--border);
    transition: background 0.15s;
}

.admin-row:last-child {
    border-bottom: none;
}

.admin-row:hover {
    background: rgba(15, 76, 117, 0.02);
}

.admin-td {
    padding: 14px 16px;
    vertical-align: middle;
    font-size: 0.875rem;
    color: var(--text);
}

.admin-td-id {
    color: var(--text-muted);
}

.admin-td-action {
    text-align: center;
}

/* ID */
.issue-id {
    font-size: 0.78rem;
    font-weight: 700;
    color: var(--text-muted);
    font-family: monospace;
}

/* Title cell */
.issue-title-cell {
    font-weight: 600;
    color: var(--text);
    margin: 0 0 2px;
    font-size: 0.875rem;
    max-width: 220px;
}

.issue-desc-cell {
    font-size: 0.78rem;
    color: var(--text-muted);
    margin: 0;
    max-width: 220px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

/* User cell */
.user-cell {
    display: flex;
    align-items: center;
    gap: 9px;
}

.user-avatar {
    width: 30px;
    height: 30px;
    flex-shrink: 0;
    background: var(--primary);
    color: white;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
    font-weight: 700;
}

.user-name {
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--text);
    margin: 0 0 1px;
    white-space: nowrap;
}

.user-email {
    font-size: 0.72rem;
    color: var(--text-muted);
    margin: 0;
    white-space: nowrap;
}

/* Category pill */
.category-pill {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    background: rgba(15, 76, 117, 0.07);
    color: var(--primary);
    border: 1px solid rgba(15, 76, 117, 0.14);
    padding: 3px 10px;
    border-radius: 999px;
    font-size: 0.75rem;
    font-weight: 600;
    white-space: nowrap;
}

.pill-icon {
    width: 12px;
    height: 12px;
}

/* Location / Date */
.location-cell,
.date-cell {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 0.82rem;
    color: var(--text-muted);
    white-space: nowrap;
}

.cell-icon {
    width: 13px;
    height: 13px;
    flex-shrink: 0;
}

/* Status badges */
.status-badge {
    display: inline-block;
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

/* View button */
.view-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 5px 14px;
    border-radius: 7px;
    font-size: 0.78rem;
    font-weight: 600;
    color: var(--primary);
    background: rgba(15, 76, 117, 0.07);
    border: 1px solid rgba(15, 76, 117, 0.14);
    text-decoration: none;
    transition: all 0.2s;
    white-space: nowrap;
}

.view-btn:hover {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
}
</style>