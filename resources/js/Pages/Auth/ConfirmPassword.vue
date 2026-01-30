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
        <div class="mb-6 text-center">
            <div class="flex justify-center mb-3">
                <div class="bg-amber-100 rounded-full p-3">
                    <ShieldCheckIcon class="h-8 w-8 text-amber-600" />
                </div>
            </div>
            <h2 class="text-2xl font-bold text-gray-900">Security Check</h2>
            <p class="mt-2 text-sm text-gray-600">
                Confirm your password to continue
            </p>
        </div>

        <!-- Warning Message -->
        <div class="mb-6 p-4 rounded-lg bg-amber-50 border border-amber-200 flex items-start gap-3">
            <ShieldCheckIcon class="h-5 w-5 text-amber-600 flex-shrink-0 mt-0.5" />
            <p class="text-sm text-amber-800">
                This is a secure area of the application. Please confirm your password before continuing.
            </p>
        </div>

        <form @submit.prevent="submit" class="space-y-5">
            <!-- Password -->
            <div>
                <InputLabel for="password" value="Password" />

                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <LockClosedIcon class="h-5 w-5 text-gray-400" />
                    </div>
                    <TextInput id="password" type="password" class="block w-full pl-10" v-model="form.password" required
                        autocomplete="current-password" autofocus placeholder="••••••••" />
                </div>

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <PrimaryButton class="w-full justify-center" :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing">
                    <CheckCircleIcon class="h-5 w-5 mr-2" />
                    Confirm
                </PrimaryButton>
            </div>
        </form>

        <!-- Security Note -->
        <div class="mt-6 p-4 rounded-lg bg-gray-50 border border-gray-200">
            <p class="text-xs text-gray-600 text-center">
                🔒 <strong>Security Note:</strong> We ask for your password to protect your sensitive information.
            </p>
        </div>
    </GuestLayout>
</template>