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
        <div class="mb-6 text-center">
            <div class="flex justify-center mb-3">
                <div class="bg-blue-100 rounded-full p-3">
                    <LockClosedIcon class="h-8 w-8 text-blue-600" />
                </div>
            </div>
            <h2 class="text-2xl font-bold text-gray-900">Reset Your Password</h2>
            <p class="mt-2 text-sm text-gray-600">
                Enter your new password below
            </p>
        </div>

        <!-- Info Message -->
        <div class="mb-6 p-4 rounded-lg bg-blue-50 border border-blue-200">
            <p class="text-sm text-blue-800">
                Choose a strong password with at least 8 characters.
            </p>
        </div>

        <form @submit.prevent="submit" class="space-y-5">
            <!-- Email (Read-only) -->
            <div>
                <InputLabel for="email" value="Email Address" />

                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <EnvelopeIcon class="h-5 w-5 text-gray-400" />
                    </div>
                    <TextInput id="email" type="email" class="block w-full pl-10 bg-gray-50" v-model="form.email"
                        required autofocus autocomplete="username" readonly />
                </div>

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <!-- New Password -->
            <div>
                <InputLabel for="password" value="New Password" />

                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <LockClosedIcon class="h-5 w-5 text-gray-400" />
                    </div>
                    <TextInput id="password" type="password" class="block w-full pl-10" v-model="form.password" required
                        autocomplete="new-password" placeholder="••••••••" />
                </div>

                <InputError class="mt-2" :message="form.errors.password" />
                <p class="mt-1 text-xs text-gray-500">Must be at least 8 characters</p>
            </div>

            <!-- Confirm Password -->
            <div>
                <InputLabel for="password_confirmation" value="Confirm New Password" />

                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <LockClosedIcon class="h-5 w-5 text-gray-400" />
                    </div>
                    <TextInput id="password_confirmation" type="password" class="block w-full pl-10"
                        v-model="form.password_confirmation" required autocomplete="new-password"
                        placeholder="••••••••" />
                </div>

                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <PrimaryButton class="w-full justify-center" :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing">
                    <CheckCircleIcon class="h-5 w-5 mr-2" />
                    Reset Password
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>