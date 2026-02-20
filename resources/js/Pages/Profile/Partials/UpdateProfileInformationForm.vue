<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import {
    UserCircleIcon,
    EnvelopeIcon,
    CheckCircleIcon,
    ExclamationCircleIcon
} from '@heroicons/vue/24/outline';

defineProps<{
    mustVerifyEmail?: Boolean;
    status?: String;
}>();

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
});
</script>

<template>
    <section class="profile-section">
        <header class="profile-section-header">
            <div class="section-title-row">
                <div class="section-icon-wrap section-icon-primary">
                    <UserCircleIcon class="section-icon" />
                </div>
                <h2 class="section-title">Profile Information</h2>
            </div>
            <p class="section-subtitle">Update your account's profile information and email address.</p>
        </header>

        <form @submit.prevent="form.patch(route('profile.update'))" class="profile-form">
            <!-- Name -->
            <div class="field">
                <InputLabel for="name" value="Full Name" class="field-label" />
                <div class="input-icon-wrap">
                    <!-- <UserCircleIcon class="input-left-icon" /> -->
                    <TextInput id="name" type="text" class="block w-full field-input field-input-icon"
                        v-model="form.name" required autofocus autocomplete="name" placeholder="Juan Dela Cruz" />
                </div>
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <!-- Email -->
            <div class="field">
                <InputLabel for="email" value="Email Address" class="field-label" />
                <div class="input-icon-wrap">
                    <!-- <EnvelopeIcon class="input-left-icon" /> -->
                    <TextInput id="email" type="email" class="block w-full field-input field-input-icon"
                        v-model="form.email" required autocomplete="username" placeholder="juan@example.com" />
                </div>
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <!-- Email Verification Warning -->
            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <div class="alert-msg alert-amber">
                    <ExclamationCircleIcon class="alert-icon" />
                    <p class="alert-text">
                        <strong>Email not verified.</strong>
                        <Link :href="route('verification.send')" method="post" as="button" class="alert-link">
                            Click here to re-send the verification email.
                        </Link>
                    </p>
                </div>
                <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                    <div v-show="status === 'verification-link-sent'" class="alert-msg alert-green"
                        style="margin-top: 0.75rem;">
                        <CheckCircleIcon class="alert-icon" />
                        <p class="alert-text"><strong>Verification email sent!</strong> A new verification link has been
                            sent to your email address.</p>
                    </div>
                </Transition>
            </div>

            <!-- Actions -->
            <div class="form-actions">
                <PrimaryButton :disabled="form.processing" class="submit-btn">
                    <CheckCircleIcon class="btn-icon" />
                    Save Changes
                </PrimaryButton>
                <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                    <div v-if="form.recentlySuccessful" class="success-flash">
                        <CheckCircleIcon class="success-flash-icon" />
                        <span>Profile updated!</span>
                    </div>
                </Transition>
            </div>
        </form>
    </section>
</template>

<style>
/* Shared profile section styles */
.profile-section {
    display: flex;
    flex-direction: column;
    gap: 0;
}

.profile-section-header {
    margin-bottom: 1.5rem;
}

.section-title-row {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 0.5rem;
}

.section-icon-wrap {
    width: 36px;
    height: 36px;
    border-radius: 9px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

.section-icon-primary {
    background: linear-gradient(135deg, var(--primary), #1a6898);
}

.section-icon-green {
    background: linear-gradient(135deg, #059669, #10b981);
}

.section-icon-red {
    background: linear-gradient(135deg, #b91c1c, #ef4444);
}

.section-icon {
    width: 18px;
    height: 18px;
    color: white;
}

.section-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.1rem;
    font-weight: 800;
    color: var(--text);
    margin: 0;
}

.section-subtitle {
    font-size: 0.875rem;
    color: var(--text-muted);
    margin: 0;
    line-height: 1.6;
}

/* Form */
.profile-form {
    display: flex;
    flex-direction: column;
    gap: 1.1rem;
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
input[type="text"].field-input,
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
input[type="text"].field-input:focus,
input[type="email"].field-input:focus,
input[type="password"].field-input:focus {
    border-color: var(--primary) !important;
    box-shadow: 0 0 0 3px rgba(15, 76, 117, 0.1) !important;
    background: white !important;
}

/* Alerts */
.alert-msg {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 0.875rem 1rem;
    border-radius: 10px;
}

.alert-amber {
    background: #fffbeb;
    border: 1px solid #fde68a;
}

.alert-green {
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
}

.alert-icon {
    width: 18px;
    height: 18px;
    flex-shrink: 0;
    margin-top: 1px;
}

.alert-amber .alert-icon {
    color: #d97706;
}

.alert-green .alert-icon {
    color: #16a34a;
}

.alert-text {
    font-size: 0.875rem;
    margin: 0;
    line-height: 1.6;
}

.alert-amber .alert-text {
    color: #92400e;
}

.alert-green .alert-text {
    color: #15803d;
}

.alert-link {
    font-weight: 600;
    text-decoration: underline;
    margin-left: 4px;
    cursor: pointer;
    background: none;
    border: none;
    font-size: inherit;
    color: inherit;
    font-family: inherit;
    padding: 0;
}

/* Actions */
.form-actions {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
    padding-top: 0.25rem;
}

.submit-btn {
    display: inline-flex !important;
    align-items: center !important;
    gap: 7px !important;
    background: var(--primary) !important;
    border-color: var(--primary) !important;
    border-radius: 10px !important;
    padding: 10px 22px !important;
    font-family: 'Source Sans 3', sans-serif !important;
    font-size: 0.9rem !important;
    font-weight: 600 !important;
    transition: all 0.2s !important;
}

.submit-btn:hover:not(:disabled) {
    background: var(--primary-dark) !important;
    border-color: var(--primary-dark) !important;
    transform: translateY(-1px) !important;
    box-shadow: 0 5px 16px rgba(15, 76, 117, 0.25) !important;
}

.btn-icon {
    width: 16px;
    height: 16px;
}

.success-flash {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 0.82rem;
    font-weight: 600;
    color: #16a34a;
}

.success-flash-icon {
    width: 16px;
    height: 16px;
}
</style>