<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import {
    LockClosedIcon,
    KeyIcon,
    CheckCircleIcon,
    ShieldCheckIcon
} from '@heroicons/vue/24/outline';

const passwordInput = ref<HTMLInputElement | null>(null);
const currentPasswordInput = ref<HTMLInputElement | null>(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => { form.reset(); },
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value?.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value?.focus();
            }
        },
    });
};
</script>

<template>
    <section class="profile-section">
        <header class="profile-section-header">
            <div class="section-title-row">
                <div class="section-icon-wrap section-icon-green">
                    <KeyIcon class="section-icon" />
                </div>
                <h2 class="section-title">Update Password</h2>
            </div>
            <div class="alert-msg alert-info">
                <ShieldCheckIcon class="alert-icon" />
                <p class="alert-text">Ensure your account is using a long, random password to stay secure. We recommend
                    at least 8 characters with a mix of letters, numbers, and symbols.</p>
            </div>
        </header>

        <form @submit.prevent="updatePassword" class="profile-form">
            <!-- Current Password -->
            <div class="field">
                <InputLabel for="current_password" value="Current Password" class="field-label" />
                <div class="input-icon-wrap">
                    <!-- <LockClosedIcon class="input-left-icon" /> -->
                    <TextInput id="current_password" ref="currentPasswordInput" v-model="form.current_password"
                        type="password" class="block w-full field-input field-input-icon"
                        autocomplete="current-password" placeholder="Enter your current password" />
                </div>
                <InputError :message="form.errors.current_password" class="mt-2" />
            </div>

            <!-- New Password -->
            <div class="field">
                <InputLabel for="password" value="New Password" class="field-label" />
                <div class="input-icon-wrap">
                    <!-- <KeyIcon class="input-left-icon" /> -->
                    <TextInput id="password" ref="passwordInput" v-model="form.password" type="password"
                        class="block w-full field-input field-input-icon" autocomplete="new-password"
                        placeholder="Enter a new password" />
                </div>
                <InputError :message="form.errors.password" class="mt-2" />
                <p class="field-hint">Must be at least 8 characters</p>
            </div>

            <!-- Confirm Password -->
            <div class="field">
                <InputLabel for="password_confirmation" value="Confirm New Password" class="field-label" />
                <div class="input-icon-wrap">
                    <!-- <KeyIcon class="input-left-icon" /> -->
                    <TextInput id="password_confirmation" v-model="form.password_confirmation" type="password"
                        class="block w-full field-input field-input-icon" autocomplete="new-password"
                        placeholder="Confirm your new password" />
                </div>
                <InputError :message="form.errors.password_confirmation" class="mt-2" />
            </div>

            <!-- Actions -->
            <div class="form-actions">
                <PrimaryButton :disabled="form.processing" class="submit-btn">
                    <CheckCircleIcon class="btn-icon" />
                    Update Password
                </PrimaryButton>
                <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                    <div v-if="form.recentlySuccessful" class="success-flash">
                        <CheckCircleIcon class="success-flash-icon" />
                        <span>Password updated!</span>
                    </div>
                </Transition>
            </div>
        </form>
    </section>
</template>

<style>
/* alert-info variant for password section */
.alert-info {
    background: rgba(15, 76, 117, 0.05);
    border: 1px solid rgba(15, 76, 117, 0.15);
    margin-top: 0.5rem;
}

.alert-info .alert-icon {
    color: var(--primary);
}

.alert-info .alert-text {
    color: var(--primary);
}
</style>