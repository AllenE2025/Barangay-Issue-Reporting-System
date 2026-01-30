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
        <div class="mb-6 text-center">
            <div class="flex justify-center mb-3">
                <div class="bg-blue-100 rounded-full p-3">
                    <KeyIcon class="h-8 w-8 text-blue-600" />
                </div>
            </div>
            <h2 class="text-2xl font-bold text-gray-900">Forgot Password?</h2>
            <p class="mt-2 text-sm text-gray-600">
                No worries! We'll send you reset instructions
            </p>
        </div>

        <!-- Info Message -->
        <div class="mb-6 p-4 rounded-lg bg-blue-50 border border-blue-200">
            <p class="text-sm text-blue-800">
                Enter your email address and we'll send you a link to reset your password.
            </p>
        </div>

        <!-- Status Message -->
        <div v-if="status" class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200 flex items-start gap-3">
            <CheckCircleIcon class="h-5 w-5 text-green-600 flex-shrink-0 mt-0.5" />
            <div>
                <p class="text-sm font-medium text-green-800">Email Sent!</p>
                <p class="text-sm text-green-700 mt-1">{{ status }}</p>
            </div>
        </div>

        <form @submit.prevent="submit" class="space-y-5">
            <!-- Email -->
            <div>
                <InputLabel for="email" value="Email Address" />

                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <EnvelopeIcon class="h-5 w-5  text-gray-400" />
                    </div>
                    <TextInput id="email" type="email" class="block w-full pl-10" v-model="form.email" required
                        autofocus autocomplete="username" placeholder="juan@example.com" />
                </div>

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <PrimaryButton class="w-full justify-center" :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing">
                    <EnvelopeIcon class="h-5 w-5 mr-2" />
                    Send Reset Link
                </PrimaryButton>
            </div>

            <!-- Back to Login Link -->
            <div class="text-center pt-4 border-t border-gray-200">
                <Link :href="route('login')"
                    class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-500 focus:outline-none focus:underline transition">
                    <ArrowLeftIcon class="h-4 w-4 mr-1" />
                    Back to login
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>