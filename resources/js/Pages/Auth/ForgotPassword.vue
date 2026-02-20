<script setup lang="ts">
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import {
    KeyIcon,
    CheckCircleIcon,
    EnvelopeIcon,
    ArrowLeftIcon
} from '@heroicons/vue/24/outline';

defineProps<{
    status?: string;
}>();

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <GuestLayout>

        <Head title="Forgot Password" />

        <!-- Header -->
        <div class="forgot-header">
            <div class="forgot-icon-wrap">
                <KeyIcon class="forgot-icon" />
            </div>
            <h2 class="forgot-title">Forgot Password?</h2>
            <p class="forgot-subtitle">No worries! We'll send you reset instructions</p>
        </div>

        <!-- Info Message -->
        <div class="info-msg">
            <EnvelopeIcon class="info-icon" />
            <p class="info-text">
                Enter your email address and we'll send you a link to reset your password.
            </p>
        </div>

        <!-- Status Message -->
        <div v-if="status" class="status-msg">
            <CheckCircleIcon class="status-icon" />
            <div>
                <p class="status-title">Email Sent!</p>
                <p class="status-text">{{ status }}</p>
            </div>
        </div>

        <form @submit.prevent="submit" class="forgot-form">
            <!-- Email -->
            <div class="field">
                <InputLabel for="email" value="Email Address" class="field-label" />
                <div class="input-icon-wrap">
                    <!-- <EnvelopeIcon class="input-left-icon" /> -->
                    <TextInput id="email" type="email" class="block w-full field-input field-input-icon"
                        v-model="form.email" required autofocus autocomplete="username"
                        placeholder="juan@example.com" />
                </div>
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <!-- Submit Button -->
            <div class="submit-wrap">
                <PrimaryButton class="submit-btn" :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing">
                    <EnvelopeIcon class="btn-icon" />
                    Send Reset Link
                </PrimaryButton>
            </div>

            <!-- Back to Login -->
            <div class="back-row">
                <Link :href="route('login')" class="back-link">
                    <ArrowLeftIcon class="back-icon" />
                    Back to login
                </Link>
            </div>
        </form>

    </GuestLayout>
</template>

<style>
/* Header */
.forgot-header {
    text-align: center;
    margin-bottom: 1.5rem;
}

.forgot-icon-wrap {
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

.forgot-icon {
    width: 26px;
    height: 26px;
    color: white;
}

.forgot-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.7rem;
    font-weight: 800;
    color: var(--text);
    margin: 0 0 0.35rem;
}

.forgot-subtitle {
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
    margin-top: 1px;
}

.info-text {
    font-size: 0.875rem;
    color: var(--primary);
    margin: 0;
    line-height: 1.6;
}

/* Status message */
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
.forgot-form {
    display: flex;
    flex-direction: column;
    gap: 1.1rem;
}

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

/* Input with icon */
.input-icon-wrap {
    position: relative;
    margin-top: 0.25rem;
}

.input-left-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    width: 18px;
    height: 18px;
    color: var(--text-muted);
    pointer-events: none;
    z-index: 1;
}

.field-input-icon {
    padding-left: 38px !important;
}

/* Override TextInput */
.field-input,
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
input[type="email"].field-input:focus {
    border-color: var(--primary) !important;
    box-shadow: 0 0 0 3px rgba(15, 76, 117, 0.1) !important;
    background: white !important;
}

/* Submit */
.submit-wrap {
    padding-top: 0.25rem;
}

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

/* Back link */
.back-row {
    text-align: center;
    padding-top: 1rem;
    border-top: 1px solid var(--border);
}

.back-link {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--primary);
    text-decoration: none;
    transition: color 0.2s, gap 0.2s;
}

.back-link:hover {
    color: var(--primary-dark);
    gap: 3px;
}

.back-icon {
    width: 15px;
    height: 15px;
    transition: transform 0.2s;
}

.back-link:hover .back-icon {
    transform: translateX(-2px);
}
</style>