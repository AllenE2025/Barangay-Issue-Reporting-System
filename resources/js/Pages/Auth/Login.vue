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
        <div class="mb-6 text-center">
            <div class="flex justify-center mb-3">
                <div class="bg-blue-100 rounded-full p-3">
                    <ArrowRightOnRectangleIcon class="h-8 w-8 text-blue-600" />
                </div>
            </div>
            <h2 class="text-2xl font-bold text-gray-900">Welcome Back</h2>
            <p class="mt-2 text-sm text-gray-600">
                Sign in to your account to continue
            </p>
        </div>

        <!-- Status Message -->
        <div v-if="status" class="mb-4 p-4 rounded-lg bg-green-50 border border-green-200 flex items-start gap-3">
            <CheckCircleIcon class="h-5 w-5 text-green-600 flex-shrink-0 mt-0.5" />
            <p class="text-sm text-green-800">{{ status }}</p>
        </div>

        <form @submit.prevent="submit" class="space-y-5">
            <!-- Email -->
            <div>
                <InputLabel for="email" value="Email Address" />

                <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus
                    autocomplete="username" placeholder="juan@example.com" />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <!-- Password -->
            <div>
                <div class="flex items-center justify-between">
                    <InputLabel for="password" value="Password" />
                    <Link v-if="canResetPassword" :href="route('password.request')"
                        class="text-xs text-blue-600 hover:text-blue-500 focus:outline-none focus:underline transition">
                        Forgot password?
                    </Link>
                </div>

                <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required
                    autocomplete="current-password" placeholder="••••••••" />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <Checkbox id="remember" name="remember" v-model:checked="form.remember" />
                <label for="remember" class="ml-2 text-sm text-gray-600 cursor-pointer">
                    Remember me for 30 days
                </label>
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <PrimaryButton class="w-full justify-center" :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing">
                    <ArrowRightOnRectangleIcon class="h-5 w-5 mr-2" />
                    Sign In
                </PrimaryButton>
            </div>

            <!-- Register Link -->
            <div class="text-center pt-4 border-t border-gray-200">
                <p class="text-sm text-gray-600">
                    Don't have an account?
                    <Link :href="route('register')"
                        class="font-medium text-blue-600 hover:text-blue-500 focus:outline-none focus:underline transition">
                        Create one now
                    </Link>
                </p>
            </div>
        </form>
    </GuestLayout>
</template>