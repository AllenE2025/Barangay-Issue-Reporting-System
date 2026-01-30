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
        <div class="mb-6 text-center">
            <div class="flex justify-center mb-3">
                <div class="bg-blue-100 rounded-full p-3">
                    <EnvelopeIcon class="h-8 w-8 text-blue-600" />
                </div>
            </div>
            <h2 class="text-2xl font-bold text-gray-900">Verify Your Email</h2>
            <p class="mt-2 text-sm text-gray-600">
                We've sent you a verification link
            </p>
        </div>

        <!-- Main Info Message -->
        <div class="mb-6 p-4 rounded-lg bg-blue-50 border border-blue-200">
            <p class="text-sm text-blue-800">
                Thanks for signing up! Before getting started, please verify your email address by clicking on the link
                we just sent to you.
            </p>
            <p class="text-sm text-blue-800 mt-2">
                If you didn't receive the email, we'll gladly send you another one.
            </p>
        </div>

        <!-- Success Message -->
        <div class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200 flex items-start gap-3"
            v-if="verificationLinkSent">
            <CheckCircleIcon class="h-5 w-5 text-green-600 flex-shrink-0 mt-0.5" />
            <div>
                <p class="text-sm font-medium text-green-800">Email Sent!</p>
                <p class="text-sm text-green-700 mt-1">
                    A new verification link has been sent to your email address. Please check your inbox.
                </p>
            </div>
        </div>

        <form @submit.prevent="submit" class="space-y-5">
            <!-- Resend Button -->
            <div>
                <PrimaryButton class="w-full justify-center" :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing">
                    <ArrowPathIcon class="h-5 w-5 mr-2" />
                    Resend Verification Email
                </PrimaryButton>
            </div>

            <!-- Logout Link -->
            <div class="text-center pt-4 border-t border-gray-200">
                <Link :href="route('logout')" method="post" as="button"
                    class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-gray-900 focus:outline-none focus:underline transition">
                    <ArrowRightOnRectangleIcon class="h-4 w-4 mr-1" />
                    Log Out
                </Link>
            </div>
        </form>

        <!-- Help Text -->
        <div class="mt-6 p-4 rounded-lg bg-gray-50 border border-gray-200">
            <p class="text-xs text-gray-600 text-center">
                💡 <strong>Tip:</strong> Check your spam folder if you don't see the email in your inbox.
            </p>
        </div>
    </GuestLayout>
</template>