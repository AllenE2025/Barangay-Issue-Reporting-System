<script setup lang="ts">
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';
import {
    LockClosedIcon,
    EnvelopeIcon,
    CheckCircleIcon
} from '@heroicons/vue/24/outline';

const props = defineProps<{
    email: string;
    token: string;
}>();

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => {
            form.reset('password', 'password_confirmation');
        },
    });
};
</script>

<template>
    <GuestLayout>

        <Head title="Reset Password" />

        <!-- Header -->
        <div class="reset-header">
            <div class="reset-icon-wrap">
                <LockClosedIcon class="reset-icon" />
            </div>
            <h2 class="reset-title">Reset Your Password</h2>
            <p class="reset-subtitle">Enter your new password below</p>
        </div>

        <!-- Info Message -->
        <div class="info-msg">
            <CheckCircleIcon class="info-icon" />
            <p class="info-text">Choose a strong password with at least 8 characters.</p>
        </div>

        <form @submit.prevent="submit" class="reset-form">

            <!-- Email (Read-only) -->
            <div class="field">
                <InputLabel for="email" value="Email Address" class="field-label" />
                <div class="input-icon-wrap">
                    <EnvelopeIcon class="input-left-icon" />
                    <TextInput id="email" type="email"
                        class="block w-full field-input field-input-icon field-input-readonly" v-model="form.email"
                        required autofocus autocomplete="username" readonly />
                </div>
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <!-- New Password -->
            <div class="field">
                <InputLabel for="password" value="New Password" class="field-label" />
                <div class="input-icon-wrap">
                    <LockClosedIcon class="input-left-icon" />
                    <TextInput id="password" type="password" class="block w-full field-input field-input-icon"
                        v-model="form.password" required autocomplete="new-password" placeholder="••••••••" />
                </div>
                <InputError class="mt-2" :message="form.errors.password" />
                <p class="field-hint">Must be at least 8 characters</p>
            </div>

            <!-- Confirm Password -->
            <div class="field">
                <InputLabel for="password_confirmation" value="Confirm New Password" class="field-label" />
                <div class="input-icon-wrap">
                    <LockClosedIcon class="input-left-icon" />
                    <TextInput id="password_confirmation" type="password"
                        class="block w-full field-input field-input-icon" v-model="form.password_confirmation" required
                        autocomplete="new-password" placeholder="••••••••" />
                </div>
                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <!-- Submit Button -->
            <div class="submit-wrap">
                <PrimaryButton class="submit-btn" :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing">
                    <CheckCircleIcon class="btn-icon" />
                    Reset Password
                </PrimaryButton>
            </div>

        </form>
    </GuestLayout>
</template>

<style>
/* Header */
.reset-header {
    text-align: center;
    margin-bottom: 1.5rem;
}

.reset-icon-wrap {
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

.reset-icon {
    width: 26px;
    height: 26px;
    color: white;
}

.reset-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.7rem;
    font-weight: 800;
    color: var(--text);
    margin: 0 0 0.35rem;
}

.reset-subtitle {
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

/* Form */
.reset-form {
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

.field-hint {
    font-size: 0.775rem;
    color: var(--text-muted);
    margin-top: 0.35rem;
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
input[type="email"].field-input,
input[type="password"].field-input {
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
input[type="email"].field-input:focus,
input[type="password"].field-input:focus {
    border-color: var(--primary) !important;
    box-shadow: 0 0 0 3px rgba(15, 76, 117, 0.1) !important;
    background: white !important;
}

/* Read-only email field */
.field-input-readonly,
input[readonly].field-input {
    background: #f1f0ec !important;
    color: var(--text-muted) !important;
    cursor: not-allowed !important;
    border-color: var(--border) !important;
}

.field-input-readonly:focus,
input[readonly].field-input:focus {
    border-color: var(--border) !important;
    box-shadow: none !important;
    background: #f1f0ec !important;
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
</style>