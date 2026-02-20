<script setup lang="ts">
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ArrowRightOnRectangleIcon, CheckCircleIcon } from '@heroicons/vue/24/outline';

defineProps<{
    canResetPassword?: boolean;
    status?: string;
}>();

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => {
            form.reset('password');
        },
    });
};
</script>

<template>
    <GuestLayout>

        <Head title="Log in" />

        <!-- Header -->
        <div class="login-header">
            <div class="login-icon-wrap">
                <ArrowRightOnRectangleIcon class="login-icon" />
            </div>
            <h2 class="login-title">Welcome Back</h2>
            <p class="login-subtitle">Sign in to your account to continue</p>
        </div>

        <!-- Status Message -->
        <div v-if="status" class="status-msg">
            <CheckCircleIcon class="status-icon" />
            <p class="status-text">{{ status }}</p>
        </div>

        <form @submit.prevent="submit" class="login-form">
            <!-- Email -->
            <div class="field">
                <InputLabel for="email" value="Email Address" class="field-label" />
                <TextInput id="email" type="email" class="mt-1 block w-full field-input" v-model="form.email" required
                    autofocus autocomplete="username" placeholder="juan@example.com" />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <!-- Password -->
            <div class="field">
                <div class="field-row">
                    <InputLabel for="password" value="Password" class="field-label" />
                    <Link v-if="canResetPassword" :href="route('password.request')" class="forgot-link">
                        Forgot password?
                    </Link>
                </div>
                <TextInput id="password" type="password" class="mt-1 block w-full field-input" v-model="form.password"
                    required autocomplete="current-password" placeholder="••••••••" />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <!-- Remember Me -->
            <div class="remember-row">
                <Checkbox id="remember" name="remember" v-model:checked="form.remember" />
                <label for="remember" class="remember-label">Remember me for 30 days</label>
            </div>

            <!-- Submit Button -->
            <div class="submit-wrap">
                <PrimaryButton class="submit-btn" :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing">
                    <ArrowRightOnRectangleIcon class="btn-icon" />
                    Sign In
                </PrimaryButton>
            </div>

            <!-- Register Link -->
            <div class="register-row">
                <p class="register-text">
                    Don't have an account?
                    <Link :href="route('register')" class="register-link">Create one now</Link>
                </p>
            </div>
        </form>
    </GuestLayout>
</template>

<style>
/* Login header */
.login-header {
    text-align: center;
    margin-bottom: 1.75rem;
}

.login-icon-wrap {
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

.login-icon {
    width: 26px;
    height: 26px;
    color: white;
}

.login-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.7rem;
    font-weight: 800;
    color: var(--text);
    margin: 0 0 0.35rem;
}

.login-subtitle {
    font-size: 0.9rem;
    color: var(--text-muted);
    margin: 0;
}

/* Status */
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
    margin-top: 1px;
}

.status-text {
    font-size: 0.875rem;
    color: #15803d;
    margin: 0;
}

/* Form */
.login-form {
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

.field-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 0.35rem;
}

.forgot-link {
    font-size: 0.78rem;
    color: var(--primary);
    font-weight: 600;
    text-decoration: none;
    transition: color 0.2s;
}

.forgot-link:hover {
    color: var(--primary-dark);
    text-decoration: underline;
}

/* Override TextInput styles to match theme */
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
}

.field-input:focus,
input[type="email"].field-input:focus,
input[type="password"].field-input:focus {
    border-color: var(--primary) !important;
    box-shadow: 0 0 0 3px rgba(15, 76, 117, 0.1) !important;
    background: white !important;
}

/* Remember */
.remember-row {
    display: flex;
    align-items: center;
    gap: 8px;
}

.remember-label {
    font-size: 0.875rem;
    color: var(--text-muted);
    cursor: pointer;
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

/* Register row */
.register-row {
    text-align: center;
    padding-top: 1rem;
    border-top: 1px solid var(--border);
}

.register-text {
    font-size: 0.875rem;
    color: var(--text-muted);
    margin: 0;
}

.register-link {
    color: var(--primary);
    font-weight: 600;
    text-decoration: none;
    transition: color 0.2s;
}

.register-link:hover {
    color: var(--primary-dark);
    text-decoration: underline;
}
</style>