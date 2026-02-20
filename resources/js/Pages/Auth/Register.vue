<script setup lang="ts">
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { UserPlusIcon } from '@heroicons/vue/24/outline';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => {
            form.reset('password', 'password_confirmation');
        },
    });
};
</script>

<template>
    <GuestLayout>

        <Head title="Register" />

        <!-- Header -->
        <div class="reg-header">
            <div class="reg-icon-wrap">
                <UserPlusIcon class="reg-icon" />
            </div>
            <h2 class="reg-title">Create an Account</h2>
            <p class="reg-subtitle">Join our community and start reporting issues</p>
        </div>

        <form @submit.prevent="submit" class="reg-form">
            <!-- Name -->
            <div class="field">
                <InputLabel for="name" value="Full Name" class="field-label" />
                <TextInput id="name" type="text" class="mt-1 block w-full field-input" v-model="form.name" required
                    autofocus autocomplete="name" placeholder="Juan Dela Cruz" />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <!-- Email -->
            <div class="field">
                <InputLabel for="email" value="Email Address" class="field-label" />
                <TextInput id="email" type="email" class="mt-1 block w-full field-input" v-model="form.email" required
                    autocomplete="username" placeholder="juan@example.com" />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <!-- Password -->
            <div class="field">
                <InputLabel for="password" value="Password" class="field-label" />
                <TextInput id="password" type="password" class="mt-1 block w-full field-input" v-model="form.password"
                    required autocomplete="new-password" placeholder="••••••••" />
                <InputError class="mt-2" :message="form.errors.password" />
                <p class="field-hint">Must be at least 8 characters</p>
            </div>

            <!-- Confirm Password -->
            <div class="field">
                <InputLabel for="password_confirmation" value="Confirm Password" class="field-label" />
                <TextInput id="password_confirmation" type="password" class="mt-1 block w-full field-input"
                    v-model="form.password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <!-- Submit Button -->
            <div class="submit-wrap">
                <PrimaryButton class="submit-btn" :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing">
                    <UserPlusIcon class="btn-icon" />
                    Create Account
                </PrimaryButton>
            </div>

            <!-- Login Link -->
            <div class="login-row">
                <p class="login-text">
                    Already have an account?
                    <Link :href="route('login')" class="login-link">Sign in</Link>
                </p>
            </div>
        </form>
    </GuestLayout>
</template>

<style>
/* Register header */
.reg-header {
    text-align: center;
    margin-bottom: 1.75rem;
}

.reg-icon-wrap {
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

.reg-icon {
    width: 26px;
    height: 26px;
    color: white;
}

.reg-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.7rem;
    font-weight: 800;
    color: var(--text);
    margin: 0 0 0.35rem;
}

.reg-subtitle {
    font-size: 0.9rem;
    color: var(--text-muted);
    margin: 0;
}

/* Form */
.reg-form {
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
}

.field-input:focus,
input[type="text"].field-input:focus,
input[type="email"].field-input:focus,
input[type="password"].field-input:focus {
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

/* Login row */
.login-row {
    text-align: center;
    padding-top: 1rem;
    border-top: 1px solid var(--border);
}

.login-text {
    font-size: 0.875rem;
    color: var(--text-muted);
    margin: 0;
}

.login-link {
    color: var(--primary);
    font-weight: 600;
    text-decoration: none;
    transition: color 0.2s;
}

.login-link:hover {
    color: var(--primary-dark);
    text-decoration: underline;
}
</style>