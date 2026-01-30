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
        onSuccess: () => {
            form.reset();
        },
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
    <section>
        <header>
            <div class="flex items-center gap-3 mb-2">
                <div class="bg-blue-100 rounded-lg p-2">
                    <KeyIcon class="h-5 w-5 text-blue-600" />
                </div>
                <h2 class="text-lg font-medium text-gray-900">
                    Update Password
                </h2>
            </div>

            <div class="p-4 rounded-lg bg-blue-50 border border-blue-200">
                <div class="flex items-start gap-2">
                    <ShieldCheckIcon class="h-5 w-5 text-blue-600 flex-shrink-0 mt-0.5" />
                    <p class="text-sm text-blue-800">
                        Ensure your account is using a long, random password to stay secure. We recommend at least 8
                        characters with a mix of letters, numbers, and symbols.
                    </p>
                </div>
            </div>
        </header>

        <form @submit.prevent="updatePassword" class="mt-6 space-y-6">
            <!-- Current Password -->
            <div>
                <InputLabel for="current_password" value="Current Password" />

                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <LockClosedIcon class="h-5 w-5 text-gray-400" />
                    </div>
                    <TextInput id="current_password" ref="currentPasswordInput" v-model="form.current_password"
                        type="password" class="block w-full pl-10" autocomplete="current-password"
                        placeholder="Enter your current password" />
                </div>

                <InputError :message="form.errors.current_password" class="mt-2" />
            </div>

            <!-- New Password -->
            <div>
                <InputLabel for="password" value="New Password" />

                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <KeyIcon class="h-5 w-5 text-gray-400" />
                    </div>
                    <TextInput id="password" ref="passwordInput" v-model="form.password" type="password"
                        class="block w-full pl-10" autocomplete="new-password" placeholder="Enter a new password" />
                </div>

                <InputError :message="form.errors.password" class="mt-2" />
                <p class="mt-1 text-xs text-gray-500">Must be at least 8 characters</p>
            </div>

            <!-- Confirm Password -->
            <div>
                <InputLabel for="password_confirmation" value="Confirm New Password" />

                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <KeyIcon class="h-5 w-5 text-gray-400" />
                    </div>
                    <TextInput id="password_confirmation" v-model="form.password_confirmation" type="password"
                        class="block w-full pl-10" autocomplete="new-password"
                        placeholder="Confirm your new password" />
                </div>

                <InputError :message="form.errors.password_confirmation" class="mt-2" />
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing" class="inline-flex items-center gap-2">
                    <CheckCircleIcon class="h-5 w-5" />
                    Update Password
                </PrimaryButton>

                <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                    <div v-if="form.recentlySuccessful" class="flex items-center gap-2 text-sm text-green-600">
                        <CheckCircleIcon class="h-5 w-5" />
                        <span class="font-medium">Password updated successfully!</span>
                    </div>
                </Transition>
            </div>
        </form>
    </section>
</template>