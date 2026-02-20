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

    <div class="min-h-screen page-bg">

        <!-- Navigation -->
        <nav class="nav-bar">
            <div class="container">
                <div class="nav-inner">
                    <Link :href="route('home')" class="nav-brand">
                        <div class="brand-icon">
                            <DocumentTextIcon class="icon-sm" />
                        </div>
                        <div>
                            <span class="brand-name">Barangay Issue System</span>
                        </div>
                    </Link>
                    <div class="nav-actions">
                        <Link :href="route('login')" class="nav-link">Log in</Link>
                        <Link :href="route('register')" class="nav-btn">Register</Link>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="hero-section">
            <div class="hero-orb hero-orb-1"></div>
            <div class="hero-orb hero-orb-2"></div>
            <div class="hero-grid"></div>

            <div class="container" style="position: relative; z-index: 1;">
                <div class="hero-text anim-fade-up anim-d1">
                    <span class="hero-badge">
                        <span class="badge-dot"></span>
                        Transparency Dashboard
                    </span>
                    <h1 class="hero-title">Community Progress</h1>
                    <p class="hero-subtitle">See what we've accomplished together</p>
                </div>

                <!-- Stats Cards -->
                <div class="stats-grid anim-fade-up anim-d2">
                    <div class="stat-card">
                        <div class="stat-num stat-green">{{ stats.resolved }}</div>
                        <div class="stat-label">Issues Resolved</div>
                        <div class="stat-bar stat-bar-green"></div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-num stat-amber">{{ stats.in_progress }}</div>
                        <div class="stat-label">In Progress</div>
                        <div class="stat-bar stat-bar-amber"></div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-num stat-white">{{ stats.pending }}</div>
                        <div class="stat-label">Pending</div>
                        <div class="stat-bar stat-bar-white"></div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-num stat-white">{{ stats.avg_resolution_days }}</div>
                        <div class="stat-label">Avg Days to Resolve</div>
                        <div class="stat-bar stat-bar-white"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="container" style="padding: 3rem 1.5rem;">

            <!-- Filters -->
            <div class="filter-card anim-fade-up anim-d3">
                <div class="filter-inner">
                    <!-- Search -->
                    <div class="search-wrap">
                        <MagnifyingGlassIcon class="input-icon" />
                        <input v-model="search" type="text" placeholder="Search resolved issues..."
                            class="text-input" />
                    </div>
                    <!-- Category Filter -->
                    <div class="select-wrap">
                        <FunnelIcon class="input-icon" />
                        <select v-model="category" class="text-input select-input">
                            <option value="all">All Categories</option>
                            <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Results Count -->
            <div class="results-count anim-fade-up anim-d4">
                Showing <strong>{{ issues.data.length }}</strong> resolved issues
            </div>

            <!-- Issues Grid -->
            <div v-if="issues.data.length > 0" class="issues-grid">
                <div v-for="issue in issues.data" :key="issue.id" class="issue-card">
                    <!-- Status Badge -->
                    <div class="issue-status">
                        <CheckCircleIcon class="status-icon" />
                        <span class="status-label">Resolved</span>
                    </div>

                    <!-- Title -->
                    <h3 class="issue-title">{{ issue.title }}</h3>

                    <!-- Location & Category -->
                    <div class="issue-meta">
                        <div class="meta-row">
                            <MapPinIcon class="meta-icon" />
                            <span>{{ issue.location }}</span>
                        </div>
                        <div class="meta-row">
                            <span class="category-badge">{{ issue.category }}</span>
                        </div>
                    </div>

                    <!-- Timeline -->
                    <div class="timeline">
                        <div class="timeline-row">
                            <CalendarIcon class="meta-icon" />
                            <span>Reported: {{ new Date(issue.created_at).toLocaleDateString() }}</span>
                        </div>
                        <div class="timeline-row">
                            <CheckCircleIcon class="meta-icon" />
                            <span>Resolved: {{ new Date(issue.updated_at).toLocaleDateString() }}</span>
                        </div>
                        <div class="timeline-row">
                            <ClockIcon class="meta-icon" />
                            <span class="days-label">
                                {{ getDaysToResolve(issue.created_at, issue.updated_at) }} days
                            </span>
                        </div>
                    </div>

                    <!-- Admin Notes -->
                    <div v-if="issue.admin_notes" class="admin-notes">
                        <p class="notes-heading">Resolution:</p>
                        <p class="notes-body">{{ issue.admin_notes }}</p>
                    </div>
                </div>
            </div>

            <!-- No Results -->
            <div v-else class="no-results">
                <p class="no-results-title">No resolved issues found.</p>
                <p class="no-results-sub">Try adjusting your filters or search terms.</p>
            </div>

            <!-- Pagination -->
            <div v-if="issues.last_page > 1" class="pagination">
                <nav class="pagination-nav">
                    <Link v-for="link in issues.links" :key="link.label" :href="link.url" :class="[
                        'page-link',
                        link.active ? 'page-link-active' : 'page-link-default'
                    ]" v-html="link.label" />
                </nav>
            </div>
        </div>

        <!-- Footer CTA -->
        <div class="cta-section">
            <div class="cta-orb cta-orb-1"></div>
            <div class="cta-orb cta-orb-2"></div>
            <div class="container" style="text-align: center; position: relative; z-index: 1;">
                <span class="cta-badge">Take Action</span>
                <h2 class="cta-title">Have an Issue to Report?</h2>
                <p class="cta-sub">Help us continue improving our community</p>
                <Link :href="route('register')" class="btn-accent">Get Started — It's Free</Link>
            </div>
        </div>

        <!-- Footer -->
        <footer class="footer">
            <div class="container footer-inner">
                <div class="footer-brand">
                    <div class="brand-icon brand-icon-sm">
                        <DocumentTextIcon class="icon-xs" />
                    </div>
                    <span class="footer-brand-name">Barangay Issue System</span>
                </div>
                <p class="footer-copy">© 2026 Barangay Issue Reporting System. Transparency for our community.</p>
            </div>
        </footer>
    </div>
</template>

<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=Source+Sans+3:wght@300;400;500;600&display=swap');

:root {
    --primary: #0F4C75;
    --primary-dark: #0a3554;
    --accent: #F59E0B;
    --accent-hover: #D97706;
    --terracotta: #C2714F;
    --bg: #FAFAF7;
    --bg-card: #FFFFFF;
    --text: #1a1a2e;
    --text-muted: #6b7280;
    --border: #e8e4dc;
}

/* Base */
.page-bg {
    background: var(--bg);
    font-family: 'Source Sans 3', sans-serif;
    color: var(--text);
}

.container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 1.5rem;
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(24px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes floatA {

    0%,
    100% {
        transform: translateY(0);
    }

    50% {
        transform: translateY(-16px);
    }
}

@keyframes floatB {

    0%,
    100% {
        transform: translateY(0);
    }

    50% {
        transform: translateY(-10px);
    }
}

.anim-fade-up {
    animation: fadeInUp 0.65s ease forwards;
}

.anim-d1 {
    animation-delay: 0.05s;
    opacity: 0;
}

.anim-d2 {
    animation-delay: 0.2s;
    opacity: 0;
}

.anim-d3 {
    animation-delay: 0.1s;
    opacity: 0;
}

.anim-d4 {
    animation-delay: 0.2s;
    opacity: 0;
}

/* Nav */
.nav-bar {
    background: rgba(250, 250, 247, 0.93);
    backdrop-filter: blur(12px);
    border-bottom: 1px solid var(--border);
    position: sticky;
    top: 0;
    z-index: 100;
}

.nav-inner {
    display: flex;
    justify-content: space-between;
    align-items: center;
    height: 64px;
}

.nav-brand {
    display: flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
}

.brand-icon {
    width: 36px;
    height: 36px;
    background: var(--primary);
    border-radius: 9px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.brand-icon-sm {
    width: 28px;
    height: 28px;
    border-radius: 7px;
}

.brand-name {
    font-family: 'Playfair Display', serif;
    font-size: 1.05rem;
    font-weight: 800;
    color: var(--text);
}

.icon-sm {
    width: 20px;
    height: 20px;
    color: white;
}

.icon-xs {
    width: 15px;
    height: 15px;
    color: white;
}

.nav-actions {
    display: flex;
    align-items: center;
    gap: 8px;
}

.nav-link {
    color: #4b5563;
    font-weight: 500;
    font-size: 0.9rem;
    padding: 8px 14px;
    border-radius: 8px;
    transition: all 0.2s;
    text-decoration: none;
}

.nav-link:hover {
    color: var(--primary);
    background: rgba(15, 76, 117, 0.06);
}

.nav-btn {
    background: var(--primary);
    color: white;
    font-weight: 600;
    font-size: 0.9rem;
    padding: 8px 20px;
    border-radius: 8px;
    transition: all 0.2s;
    text-decoration: none;
}

.nav-btn:hover {
    background: var(--primary-dark);
    transform: translateY(-1px);
}

/* Hero */
.hero-section {
    background: linear-gradient(135deg, var(--primary) 0%, #0a3554 60%, #0d3d65 100%);
    padding: 4rem 1.5rem 3rem;
    position: relative;
    overflow: hidden;
}

.hero-orb {
    position: absolute;
    border-radius: 50%;
    pointer-events: none;
    filter: blur(60px);
}

.hero-orb-1 {
    width: 350px;
    height: 350px;
    background: rgba(245, 158, 11, 0.08);
    top: -80px;
    right: 5%;
    animation: floatA 9s ease-in-out infinite;
}

.hero-orb-2 {
    width: 250px;
    height: 250px;
    background: rgba(255, 255, 255, 0.04);
    bottom: -60px;
    left: 5%;
    animation: floatB 11s ease-in-out infinite;
}

.hero-grid {
    position: absolute;
    inset: 0;
    background-image: radial-gradient(circle, rgba(255, 255, 255, 0.05) 1px, transparent 1px);
    background-size: 32px 32px;
    pointer-events: none;
}

.hero-text {
    text-align: center;
    margin-bottom: 3rem;
}

.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(245, 158, 11, 0.15);
    border: 1px solid rgba(245, 158, 11, 0.3);
    color: #fcd34d;
    font-size: 0.78rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    padding: 5px 16px;
    border-radius: 999px;
    margin-bottom: 1.25rem;
}

.badge-dot {
    width: 6px;
    height: 6px;
    background: var(--accent);
    border-radius: 50%;
    display: inline-block;
}

.hero-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2rem, 5vw, 3.5rem);
    font-weight: 800;
    color: white;
    margin: 0 0 0.75rem;
    line-height: 1.1;
}

.hero-subtitle {
    color: rgba(255, 255, 255, 0.7);
    font-size: 1.05rem;
    font-weight: 300;
    margin: 0;
}

/* Stats */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.stat-card {
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 14px;
    padding: 1.5rem;
    text-align: center;
    position: relative;
    overflow: hidden;
    transition: transform 0.2s, background 0.2s;
}

.stat-card:hover {
    transform: translateY(-4px);
    background: rgba(255, 255, 255, 0.13);
}

.stat-num {
    font-family: 'Playfair Display', serif;
    font-size: 2.2rem;
    font-weight: 800;
    margin-bottom: 0.25rem;
}

.stat-green {
    color: #6ee7b7;
}

.stat-amber {
    color: #fcd34d;
}

.stat-white {
    color: white;
}

.stat-label {
    color: rgba(255, 255, 255, 0.65);
    font-size: 0.85rem;
}

.stat-bar {
    height: 3px;
    border-radius: 2px;
    margin-top: 1rem;
    opacity: 0.4;
}

.stat-bar-green {
    background: #6ee7b7;
}

.stat-bar-amber {
    background: #fcd34d;
}

.stat-bar-white {
    background: white;
}

/* Filters */
.filter-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
}

.filter-inner {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
}

.search-wrap {
    flex: 1;
    min-width: 200px;
    position: relative;
}

.select-wrap {
    width: 240px;
    position: relative;
}

.input-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    width: 18px;
    height: 18px;
    color: var(--text-muted);
    pointer-events: none;
}

.text-input {
    width: 100%;
    padding: 10px 12px 10px 38px;
    border: 1px solid var(--border);
    border-radius: 9px;
    font-family: 'Source Sans 3', sans-serif;
    font-size: 0.9rem;
    color: var(--text);
    background: var(--bg);
    transition: border-color 0.2s, box-shadow 0.2s;
    outline: none;
    box-sizing: border-box;
}

.text-input:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(15, 76, 117, 0.1);
}

.select-input {
    appearance: none;
    cursor: pointer;
}

/* Results count */
.results-count {
    color: var(--text-muted);
    font-size: 0.9rem;
    margin-bottom: 1.5rem;
}

.results-count strong {
    color: var(--text);
}

/* Issues Grid */
.issues-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.25rem;
}

.issue-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 1.5rem;
    transition: all 0.25s ease;
    position: relative;
    overflow: hidden;
}

.issue-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #10b981, #6ee7b7);
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.3s ease;
}

.issue-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 16px 40px rgba(15, 76, 117, 0.1);
    border-color: rgba(15, 76, 117, 0.15);
}

.issue-card:hover::before {
    transform: scaleX(1);
}

.issue-status {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-bottom: 0.75rem;
}

.status-icon {
    width: 18px;
    height: 18px;
    color: #10b981;
}

.status-label {
    font-size: 0.82rem;
    font-weight: 600;
    color: #10b981;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.issue-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--text);
    margin: 0 0 1rem;
    line-height: 1.3;
}

.issue-meta {
    display: flex;
    flex-direction: column;
    gap: 6px;
    margin-bottom: 1rem;
}

.meta-row {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 0.875rem;
    color: var(--text-muted);
}

.meta-icon {
    width: 15px;
    height: 15px;
    flex-shrink: 0;
}

.category-badge {
    background: rgba(15, 76, 117, 0.08);
    color: var(--primary);
    border: 1px solid rgba(15, 76, 117, 0.15);
    font-size: 0.75rem;
    font-weight: 600;
    padding: 3px 10px;
    border-radius: 999px;
}

.timeline {
    border-top: 1px solid var(--border);
    padding-top: 1rem;
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.timeline-row {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 0.875rem;
    color: var(--text-muted);
}

.days-label {
    font-weight: 600;
    color: #10b981;
}

.admin-notes {
    margin-top: 1rem;
    padding: 0.875rem;
    background: var(--bg);
    border-radius: 9px;
    border: 1px solid var(--border);
}

.notes-heading {
    font-size: 0.82rem;
    font-weight: 700;
    color: var(--text);
    margin: 0 0 4px;
}

.notes-body {
    font-size: 0.875rem;
    color: var(--text-muted);
    margin: 0;
    line-height: 1.6;
}

/* No results */
.no-results {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 4rem 2rem;
    text-align: center;
}

.no-results-title {
    color: var(--text-muted);
    font-size: 1.1rem;
    margin: 0 0 0.5rem;
}

.no-results-sub {
    color: #9ca3af;
    font-size: 0.875rem;
    margin: 0;
}

/* Pagination */
.pagination {
    margin-top: 2.5rem;
    display: flex;
    justify-content: center;
}

.pagination-nav {
    display: inline-flex;
    border-radius: 10px;
    overflow: hidden;
    border: 1px solid var(--border);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.page-link {
    display: inline-flex;
    align-items: center;
    padding: 8px 14px;
    font-size: 0.875rem;
    font-weight: 500;
    text-decoration: none;
    transition: background 0.15s;
    border-right: 1px solid var(--border);
}

.page-link:last-child {
    border-right: none;
}

.page-link-active {
    background: var(--primary);
    color: white;
}

.page-link-default {
    background: white;
    color: var(--text);
}

.page-link-default:hover {
    background: var(--bg);
}

/* CTA */
.cta-section {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 60%, #0d3d65 100%);
    padding: 5rem 1.5rem;
    position: relative;
    overflow: hidden;
    margin-top: 4rem;
}

.cta-orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(60px);
    pointer-events: none;
}

.cta-orb-1 {
    width: 400px;
    height: 400px;
    background: rgba(245, 158, 11, 0.07);
    top: -50%;
    right: -5%;
}

.cta-orb-2 {
    width: 300px;
    height: 300px;
    background: rgba(255, 255, 255, 0.04);
    bottom: -40%;
    left: -5%;
}

.cta-badge {
    display: inline-block;
    background: rgba(245, 158, 11, 0.15);
    border: 1px solid rgba(245, 158, 11, 0.3);
    color: #fcd34d;
    font-size: 0.78rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    padding: 5px 16px;
    border-radius: 999px;
    margin-bottom: 1.25rem;
}

.cta-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(1.8rem, 4vw, 2.8rem);
    font-weight: 800;
    color: white;
    margin: 0 0 1rem;
}

.cta-sub {
    color: rgba(255, 255, 255, 0.7);
    font-size: 1.05rem;
    font-weight: 300;
    margin: 0 0 2.5rem;
}

.btn-accent {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: var(--accent);
    color: #1a1a2e;
    padding: 14px 36px;
    border-radius: 10px;
    font-weight: 700;
    font-size: 1rem;
    transition: all 0.2s;
    text-decoration: none;
    border: 2px solid var(--accent);
}

.btn-accent:hover {
    background: var(--accent-hover);
    border-color: var(--accent-hover);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(245, 158, 11, 0.4);
}

/* Footer */
.footer {
    background: #111827;
    padding: 2rem 1.5rem;
    border-top: 1px solid rgba(255, 255, 255, 0.05);
}

.footer-inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
}

.footer-brand {
    display: flex;
    align-items: center;
    gap: 8px;
}

.footer-brand-name {
    font-family: 'Playfair Display', serif;
    color: white;
    font-weight: 700;
    font-size: 0.9rem;
}

.footer-copy {
    color: #6b7280;
    font-size: 0.82rem;
    margin: 0;
}
</style>