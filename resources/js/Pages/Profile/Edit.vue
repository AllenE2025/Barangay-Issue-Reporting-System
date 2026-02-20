<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head, usePage } from '@inertiajs/vue3';

defineProps<{
    mustVerifyEmail?: boolean;
    status?: string;
}>();

const user = usePage().props.auth.user;
</script>

<template>

    <Head title="Profile" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Profile</h2>
        </template>

        <div class="profile-wrap">
            <div class="profile-container">

                <!-- Profile hero -->
                <div class="profile-hero">
                    <div class="profile-avatar-lg">
                        {{ (user.name as string).charAt(0).toUpperCase() }}
                    </div>
                    <div>
                        <h1 class="profile-hero-name">{{ user.name }}</h1>
                        <p class="profile-hero-email">{{ user.email }}</p>
                    </div>
                </div>

                <!-- Update Profile -->
                <div class="profile-card">
                    <UpdateProfileInformationForm :must-verify-email="mustVerifyEmail" :status="status" />
                </div>

                <!-- Update Password -->
                <div class="profile-card">
                    <UpdatePasswordForm />
                </div>

                <!-- Danger Zone -->
                <div class="profile-card profile-card-danger">
                    <DeleteUserForm />
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>
/* Profile page layout */
.profile-wrap {
    padding: 2.5rem 0 3rem;
}

.profile-container {
    max-width: 680px;
    margin: 0 auto;
    padding: 0 1.5rem;
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}

/* Hero */
.profile-hero {
    display: flex;
    align-items: center;
    gap: 1.25rem;
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 1.5rem;
}

.profile-avatar-lg {
    width: 60px;
    height: 60px;
    flex-shrink: 0;
    background: linear-gradient(135deg, var(--primary), #1a6898);
    color: white;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Playfair Display', serif;
    font-size: 1.5rem;
    font-weight: 800;
    box-shadow: 0 6px 18px rgba(15, 76, 117, 0.25);
}

.profile-hero-name {
    font-family: 'Playfair Display', serif;
    font-size: 1.3rem;
    font-weight: 800;
    color: var(--text);
    margin: 0 0 2px;
}

.profile-hero-email {
    font-size: 0.875rem;
    color: var(--text-muted);
    margin: 0;
}

/* Cards */
.profile-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 1.75rem;
}

.profile-card-danger {
    border-color: #fecaca;
}
</style>