<script setup lang="ts">
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';
import {
    ShieldCheckIcon,
    LockClosedIcon,
    CheckCircleIcon
} from '@heroicons/vue/24/outline';

const form = useForm({
    password: '',
});

const submit = () => {
    form.post(route('password.confirm'), {
        onFinish: () => {
            form.reset();
        },
    });
};
</script>

<template>
    <GuestLayout>

        <Head title="Confirm Password" />

        <!-- Header -->
        <div class="confirm-header">
            <div class="confirm-icon-wrap">
                <ShieldCheckIcon class="confirm-icon" />
            </div>
            <h2 class="confirm-title">Security Check</h2>
            <p class="confirm-subtitle">Confirm your password to continue</p>
        </div>

        <!-- Warning Message -->
        <div class="warning-msg">
            <ShieldCheckIcon class="warning-icon" />
            <p class="warning-text">
                This is a secure area of the application. Please confirm your password before continuing.
            </p>
        </div>

        <form @submit.prevent="submit" class="confirm-form">
            <!-- Password -->
            <div class="field">
                <InputLabel for="password" value="Password" class="field-label" />
                <div class="input-icon-wrap">
                    <LockClosedIcon class="input-left-icon" />
                    <TextInput id="password" type="password" class="block w-full field-input field-input-icon"
                        v-model="form.password" required autocomplete="current-password" autofocus
                        placeholder="••••••••" />
                </div>
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <!-- Submit Button -->
            <div class="submit-wrap">
                <PrimaryButton class="submit-btn" :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing">
                    <CheckCircleIcon class="btn-icon" />
                    Confirm Password
                </PrimaryButton>
            </div>
        </form>

        <!-- Security Note -->
        <div class="security-note">
            <LockClosedIcon class="security-note-icon" />
            <p class="security-note-text">
                <strong>Security Note:</strong> We ask for your password to protect your sensitive information.
            </p>
        </div>

    </GuestLayout>
</template>

<style>
/* Header */
.confirm-header {
    text-align: center;
    margin-bottom: 1.5rem;
}

.confirm-icon-wrap {
    width: 54px;
    height: 54px;
    background: linear-gradient(135deg, #b45309, var(--accent));
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    box-shadow: 0 6px 20px rgba(180, 83, 9, 0.25);
}

.confirm-icon {
    width: 26px;
    height: 26px;
    color: white;
}

.confirm-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.7rem;
    font-weight: 800;
    color: var(--text);
    margin: 0 0 0.35rem;
}

.confirm-subtitle {
    font-size: 0.9rem;
    color: var(--text-muted);
    margin: 0;
}

/* Warning */
.warning-msg {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    background: #fffbeb;
    border: 1px solid #fde68a;
    border-radius: 10px;
    padding: 0.875rem 1rem;
    margin-bottom: 1.5rem;
}

.warning-icon {
    width: 18px;
    height: 18px;
    color: #d97706;
    flex-shrink: 0;
    margin-top: 1px;
}

.warning-text {
    font-size: 0.875rem;
    color: #92400e;
    margin: 0;
    line-height: 1.6;
}

/* Form */
.confirm-form {
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

/* Input with left icon */
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
input[type="password"].field-input:focus {
    border-color: var(--accent) !important;
    box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.12) !important;
    background: white !important;
}

/* Submit */
.submit-wrap {
    padding-top: 0.25rem;
}

.submit-btn {
    width: 100% !important;
    justify-content: center !important;
    background: linear-gradient(135deg, #b45309, var(--accent)) !important;
    border-color: #b45309 !important;
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
    opacity: 0.9 !important;
    transform: translateY(-1px) !important;
    box-shadow: 0 6px 20px rgba(180, 83, 9, 0.3) !important;
}

.btn-icon {
    width: 18px;
    height: 18px;
}

/* Security note */
.security-note {
    display: flex;
    align-items: flex-start;
    gap: 8px;
    margin-top: 1.5rem;
    padding: 0.875rem 1rem;
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: 10px;
}

.security-note-icon {
    width: 15px;
    height: 15px;
    color: var(--text-muted);
    flex-shrink: 0;
    margin-top: 2px;
}

.security-note-text {
    font-size: 0.775rem;
    color: var(--text-muted);
    margin: 0;
    line-height: 1.6;
    text-align: left;
}

.security-note-text strong {
    color: var(--text);
}
</style>