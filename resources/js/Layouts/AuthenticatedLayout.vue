<script setup lang="ts">
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';
import { DocumentTextIcon, Bars3Icon, XMarkIcon } from '@heroicons/vue/24/outline';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <div class="auth-bg">

            <!-- Navbar -->
            <nav class="auth-nav">
                <div class="auth-container">
                    <div class="auth-nav-inner">

                        <!-- Left: Brand + Links -->
                        <div class="auth-nav-left">
                            <!-- Brand -->
                            <Link :href="route('dashboard')" class="auth-brand">
                                <div class="auth-brand-icon">
                                    <DocumentTextIcon class="auth-brand-svg" />
                                </div>
                                <span class="auth-brand-name">Barangay Issue System</span>
                            </Link>

                            <!-- Desktop Nav Links -->
                            <div class="auth-nav-links">
                                <NavLink :href="route('dashboard')" :active="route().current('dashboard')"
                                    class="auth-navlink">
                                    Overview
                                </NavLink>
                                <NavLink v-if="($page.props.auth.user as any)?.role === 'user'"
                                    :href="route('issues.index')" :active="route().current('issues.index')"
                                    class="auth-navlink">
                                    My Issues
                                </NavLink>
                                <NavLink v-if="($page.props.auth.user as any)?.role === 'user'"
                                    :href="route('issues.create')" :active="route().current('issues.create')"
                                    class="auth-navlink">
                                    Report Issue
                                </NavLink>
                                <NavLink v-if="($page.props.auth.user as any)?.role === 'admin'"
                                    :href="route('admin.issues.index')" :active="route().current('admin.issues.*')"
                                    class="auth-navlink">
                                    Admin Dashboard
                                </NavLink>
                            </div>
                        </div>

                        <!-- Right: User Dropdown -->
                        <div class="auth-nav-right">
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <button type="button" class="auth-user-btn">
                                        <div class="auth-user-avatar">
                                            {{ ($page.props.auth.user.name as string).charAt(0).toUpperCase() }}
                                        </div>
                                        <span class="auth-user-name">{{ $page.props.auth.user.name }}</span>
                                        <svg class="auth-chevron" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </template>
                                <template #content>
                                    <DropdownLink :href="route('profile.edit')" class="auth-dropdown-link">
                                        Profile
                                    </DropdownLink>
                                    <DropdownLink :href="route('logout')" method="post" as="button"
                                        class="auth-dropdown-link">
                                        Log Out
                                    </DropdownLink>
                                </template>
                            </Dropdown>
                        </div>

                        <!-- Hamburger -->
                        <div class="auth-hamburger">
                            <button @click="showingNavigationDropdown = !showingNavigationDropdown"
                                class="auth-hamburger-btn">
                                <XMarkIcon v-if="showingNavigationDropdown" class="h-6 w-6" />
                                <Bars3Icon v-else class="h-6 w-6" />
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Mobile Menu -->
                <div :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
                    class="auth-mobile-menu sm:hidden">
                    <div class="auth-mobile-links">
                        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')"
                            class="auth-mobile-link">
                            Overview
                        </ResponsiveNavLink>
                        <ResponsiveNavLink v-if="($page.props.auth.user as any)?.role === 'user'"
                            :href="route('issues.index')" :active="route().current('issues.index')"
                            class="auth-mobile-link">
                            My Issues
                        </ResponsiveNavLink>
                        <ResponsiveNavLink v-if="($page.props.auth.user as any)?.role === 'user'"
                            :href="route('issues.create')" :active="route().current('issues.create')"
                            class="auth-mobile-link">
                            Report Issue
                        </ResponsiveNavLink>
                        <ResponsiveNavLink v-if="($page.props.auth.user as any)?.role === 'admin'"
                            :href="route('admin.issues.index')" :active="route().current('admin.issues.*')"
                            class="auth-mobile-link">
                            Admin Dashboard
                        </ResponsiveNavLink>
                    </div>

                    <!-- Mobile User Info -->
                    <div class="auth-mobile-user">
                        <div class="auth-mobile-user-info">
                            <div class="auth-mobile-avatar">
                                {{ ($page.props.auth.user.name as string).charAt(0).toUpperCase() }}
                            </div>
                            <div>
                                <div class="auth-mobile-name">{{ $page.props.auth.user.name }}</div>
                                <div class="auth-mobile-email">{{ $page.props.auth.user.email }}</div>
                            </div>
                        </div>
                        <div class="auth-mobile-actions">
                            <ResponsiveNavLink :href="route('profile.edit')" class="auth-mobile-link">Profile
                            </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('logout')" method="post" as="button"
                                class="auth-mobile-link">Log Out
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="auth-page-header" v-if="$slots.header">
                <div class="auth-container">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
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

/* Page background */
.auth-bg {
    min-height: 100vh;
    background: var(--bg);
    font-family: 'Source Sans 3', sans-serif;
}

/* Container */
.auth-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1.5rem;
}

/* Navbar */
.auth-nav {
    background: rgba(250, 250, 247, 0.95);
    backdrop-filter: blur(12px);
    border-bottom: 1px solid var(--border);
    position: sticky;
    top: 0;
    z-index: 100;
}

.auth-nav-inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 64px;
}

.auth-nav-left {
    display: flex;
    align-items: center;
    gap: 2rem;
}

/* Brand */
.auth-brand {
    display: flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
    flex-shrink: 0;
}

.auth-brand-icon {
    width: 34px;
    height: 34px;
    background: var(--primary);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.auth-brand-svg {
    width: 18px;
    height: 18px;
    color: white;
}

.auth-brand-name {
    font-family: 'Playfair Display', serif;
    font-size: 1rem;
    font-weight: 800;
    color: var(--text);
}

/* Desktop nav links */
.auth-nav-links {
    display: none;
    align-items: center;
    gap: 0.25rem;
}

@media (min-width: 640px) {
    .auth-nav-links {
        display: flex;
    }
}

/* Override NavLink styles */
.auth-navlink,
.auth-nav-links a,
.auth-nav-links button {
    font-family: 'Source Sans 3', sans-serif !important;
    font-size: 0.875rem !important;
    font-weight: 500 !important;
    color: var(--text-muted) !important;
    padding: 6px 12px !important;
    border-radius: 8px !important;
    text-decoration: none !important;
    transition: all 0.2s !important;
    border-bottom: none !important;
    white-space: nowrap;
}

.auth-navlink:hover,
.auth-nav-links a:hover {
    color: var(--primary) !important;
    background: rgba(15, 76, 117, 0.06) !important;
}

/* Active state — NavLink adds border-b or text color; we override */
.auth-nav-links .border-indigo-400,
.auth-nav-links [class*="border-indigo"],
.auth-nav-links [class*="text-gray-900"] {
    color: var(--primary) !important;
    background: rgba(15, 76, 117, 0.08) !important;
    font-weight: 600 !important;
}

/* Right side */
.auth-nav-right {
    display: none;
    align-items: center;
}

@media (min-width: 640px) {
    .auth-nav-right {
        display: flex;
    }
}

/* User button */
.auth-user-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    background: none;
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 6px 12px;
    cursor: pointer;
    transition: all 0.2s;
    font-family: 'Source Sans 3', sans-serif;
}

.auth-user-btn:hover {
    border-color: var(--primary);
    background: rgba(15, 76, 117, 0.04);
}

.auth-user-avatar {
    width: 28px;
    height: 28px;
    background: var(--primary);
    color: white;
    border-radius: 7px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
    font-weight: 700;
    flex-shrink: 0;
}

.auth-user-name {
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--text);
    max-width: 140px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.auth-chevron {
    width: 14px;
    height: 14px;
    color: var(--text-muted);
}

/* Dropdown overrides */
.auth-dropdown-link,
[class*="dropdown"] a,
[class*="dropdown"] button {
    font-family: 'Source Sans 3', sans-serif !important;
    font-size: 0.875rem !important;
    color: var(--text) !important;
    padding: 8px 16px !important;
    display: block !important;
    transition: background 0.15s !important;
}

.auth-dropdown-link:hover {
    background: var(--bg) !important;
    color: var(--primary) !important;
}

/* Hamburger */
.auth-hamburger {
    display: flex;
}

@media (min-width: 640px) {
    .auth-hamburger {
        display: none;
    }
}

.auth-hamburger-btn {
    background: none;
    border: none;
    cursor: pointer;
    padding: 8px;
    border-radius: 8px;
    color: var(--text-muted);
    transition: all 0.2s;
}

.auth-hamburger-btn:hover {
    background: rgba(15, 76, 117, 0.06);
    color: var(--primary);
}

/* Mobile menu */
.auth-mobile-menu {
    border-top: 1px solid var(--border);
    background: var(--bg-card);
}

.auth-mobile-links {
    padding: 0.75rem 0;
}

.auth-mobile-link,
.auth-mobile-links a,
.auth-mobile-links button,
.auth-mobile-actions a,
.auth-mobile-actions button {
    display: block !important;
    width: 100% !important;
    padding: 10px 1.5rem !important;
    font-family: 'Source Sans 3', sans-serif !important;
    font-size: 0.9rem !important;
    font-weight: 500 !important;
    color: var(--text-muted) !important;
    text-decoration: none !important;
    transition: all 0.15s !important;
    background: none !important;
    border: none !important;
    text-align: left !important;
    cursor: pointer !important;
}

.auth-mobile-link:hover,
.auth-mobile-links a:hover,
.auth-mobile-actions a:hover,
.auth-mobile-actions button:hover {
    color: var(--primary) !important;
    background: rgba(15, 76, 117, 0.05) !important;
}

.auth-mobile-user {
    border-top: 1px solid var(--border);
    padding: 1rem 0 0.5rem;
}

.auth-mobile-user-info {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 0 1.5rem 0.75rem;
}

.auth-mobile-avatar {
    width: 36px;
    height: 36px;
    background: var(--primary);
    color: white;
    border-radius: 9px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.9rem;
    font-weight: 700;
    flex-shrink: 0;
}

.auth-mobile-name {
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--text);
}

.auth-mobile-email {
    font-size: 0.78rem;
    color: var(--text-muted);
}

.auth-mobile-actions {
    padding-bottom: 0.5rem;
}

/* Page header */
.auth-page-header {
    background: var(--bg-card);
    border-bottom: 1px solid var(--border);
    padding: 1.25rem 1.5rem;
}

.auth-page-header h2 {
    font-family: 'Playfair Display', serif !important;
    font-size: 1.3rem !important;
    font-weight: 800 !important;
    color: var(--text) !important;
}
</style>