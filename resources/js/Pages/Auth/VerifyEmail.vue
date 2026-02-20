<script setup lang="ts">
import { computed } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import {
    EnvelopeIcon,
    CheckCircleIcon,
    ArrowPathIcon,
    ArrowRightOnRectangleIcon
} from '@heroicons/vue/24/outline';

const props = defineProps<{
    status?: string;
}>();

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(
    () => props.status === 'verification-link-sent',
);
</script>

<template>
    <GuestLayout>

        <Head title="Email Verification" />

        <!-- Header -->
        <div class="verify-header">
            <div class="verify-icon-wrap">
                <EnvelopeIcon class="verify-icon" />
            </div>
            <h2 class="verify-title">Verify Your Email</h2>
            <p class="verify-subtitle">We've sent you a verification link</p>
        </div>

        <!-- Main Info Message -->
        <div class="info-msg">
            <EnvelopeIcon class="info-icon" />
            <div>
                <p class="info-text">
                    Thanks for signing up! Before getting started, please verify your email address by clicking on the
                    link we just sent to you.
                </p>
                <p class="info-text" style="margin-top: 0.4rem;">
                    If you didn't receive the email, we'll gladly send you another one.
                </p>
            </div>
        </div>

        <!-- Success Message -->
        <div v-if="verificationLinkSent" class="status-msg">
            <CheckCircleIcon class="status-icon" />
            <div>
                <p class="status-title">Email Sent!</p>
                <p class="status-text">
                    A new verification link has been sent to your email address. Please check your inbox.
                </p>
            </div>
        </div>

        <form @submit.prevent="submit" class="verify-form">
            <!-- Resend Button -->
            <div>
                <PrimaryButton class="submit-btn" :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing">
                    <ArrowPathIcon class="btn-icon" :class="{ 'spin': form.processing }" />
                    Resend Verification Email
                </PrimaryButton>
            </div>

            <!-- Logout -->
            <div class="logout-row">
                <Link :href="route('logout')" method="post" as="button" class="logout-btn">
                    <ArrowRightOnRectangleIcon class="logout-icon" />
                    Log Out
                </Link>
            </div>
        </form>

        <!-- Tip -->
        <div class="tip-box">
            <span class="tip-dot">💡</span>
            <p class="tip-text"><strong>Tip:</strong> Check your spam folder if you don't see the email in your inbox.
            </p>
        </div>

    </GuestLayout>
</template>

<style>
/* Header */
.verify-header {
    text-align: center;
    margin-bottom: 1.5rem;
}

.verify-icon-wrap {
    width: 54px;
    height: 54px;
    background: linear-gradient(135deg, var(--primary), #1a6898);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    box-shadow: 0 6px 20px rgba(15, 76, 117, 0.25);
}

.verify-icon {
    width: 26px;
    height: 26px;
    color: white;
}

.verify-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.7rem;
    font-weight: 800;
    color: var(--text);
    margin: 0 0 0.35rem;
}

.verify-subtitle {
    font-size: 0.9rem;
    color: var(--text-muted);
    margin: 0;
}

/* Info message */
.info-msg {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    background: rgba(15, 76, 117, 0.05);
    border: 1px solid rgba(15, 76, 117, 0.15);
    border-radius: 10px;
    padding: 0.875rem 1rem;
    margin-bottom: 1.25rem;
}

.info-icon {
    width: 18px;
    height: 18px;
    color: var(--primary);
    flex-shrink: 0;
    margin-top: 2px;
}

.info-text {
    font-size: 0.875rem;
    color: var(--primary);
    margin: 0;
    line-height: 1.6;
}

/* Status / success message */
.status-msg {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 10px;
    padding: 0.875rem 1rem;
    margin-bottom: 1.25rem;
}

.status-icon {
    width: 18px;
    height: 18px;
    color: #16a34a;
    flex-shrink: 0;
    margin-top: 2px;
}

.status-title {
    font-size: 0.875rem;
    font-weight: 700;
    color: #15803d;
    margin: 0 0 2px;
}

.status-text {
    font-size: 0.85rem;
    color: #16a34a;
    margin: 0;
    line-height: 1.5;
}

/* Form */
.verify-form {
    display: flex;
    flex-direction: column;
    gap: 1.1rem;
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
    font-size: 0.95rem !important;
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
    box-shadow: 0 6px 20px rgba(15, 76, 117, 0.3) !important;
}

.btn-icon {
    width: 18px;
    height: 18px;
}

@keyframes spin {
    from {
        transform: rotate(0deg);
    }

    to {
        transform: rotate(360deg);
    }
}

.spin {
    animation: spin 1s linear infinite;
}

/* Logout */
.logout-row {
    text-align: center;
    padding-top: 1rem;
    border-top: 1px solid var(--border);
}

.logout-btn {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-muted);
    background: none;
    border: none;
    cursor: pointer;
    text-decoration: none;
    transition: color 0.2s;
    font-family: 'Source Sans 3', sans-serif;
    padding: 0;
}

.logout-btn:hover {
    color: var(--text);
}

.logout-icon {
    width: 15px;
    height: 15px;
}

/* Tip box */
.tip-box {
    display: flex;
    align-items: flex-start;
    gap: 8px;
    margin-top: 1.5rem;
    padding: 0.875rem 1rem;
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: 10px;
}

.tip-dot {
    font-size: 0.875rem;
    flex-shrink: 0;
}

.tip-text {
    font-size: 0.775rem;
    color: var(--text-muted);
    margin: 0;
    line-height: 1.6;
}

.tip-text strong {
    color: var(--text);
}
</style>