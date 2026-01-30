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
    <section>
        <header>
            <div class="flex items-center gap-3 mb-2">
                <div class="bg-blue-100 rounded-lg p-2">
                    <UserCircleIcon class="h-5 w-5 text-blue-600" />
                </div>
                <h2 class="text-lg font-medium text-gray-900">
                    Profile Information
                </h2>
            </div>

            <p class="mt-1 text-sm text-gray-600">
                Update your account's profile information and email address.
            </p>
        </header>

        <form @submit.prevent="form.patch(route('profile.update'))" class="mt-6 space-y-6">
            <!-- Name -->
            <div>
                <InputLabel for="name" value="Full Name" />

                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <UserCircleIcon class="h-5 w-5 text-gray-400" />
                    </div>
                    <TextInput id="name" type="text" class="block w-full pl-10" v-model="form.name" required autofocus
                        autocomplete="name" placeholder="Juan Dela Cruz" />
                </div>

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <!-- Email -->
            <div>
                <InputLabel for="email" value="Email Address" />

                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <EnvelopeIcon class="h-5 w-5 text-gray-400" />
                    </div>
                    <TextInput id="email" type="email" class="block w-full pl-10" v-model="form.email" required
                        autocomplete="username" placeholder="juan@example.com" />
                </div>

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <!-- Email Verification Warning -->
            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <div class="p-4 rounded-lg bg-amber-50 border border-amber-200 flex items-start gap-3">
                    <ExclamationCircleIcon class="h-5 w-5 text-amber-600 flex-shrink-0 mt-0.5" />
                    <div class="flex-1">
                        <p class="text-sm text-amber-800">
                            <strong>Email not verified.</strong>
                            <Link :href="route('verification.send')" method="post" as="button"
                                class="font-medium text-amber-900 underline hover:text-amber-700 focus:outline-none">
                                Click here to re-send the verification email.
                            </Link>
                        </p>
                    </div>
                </div>

                <!-- Verification Link Sent -->
                <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                    <div v-show="status === 'verification-link-sent'"
                        class="mt-3 p-4 rounded-lg bg-green-50 border border-green-200 flex items-start gap-3">
                        <CheckCircleIcon class="h-5 w-5 text-green-600 flex-shrink-0 mt-0.5" />
                        <p class="text-sm text-green-800">
                            <strong>Verification email sent!</strong> A new verification link has been sent to your
                            email address.
                        </p>
                    </div>
                </Transition>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing" class="inline-flex items-center gap-2">
                    <CheckCircleIcon class="h-5 w-5" />
                    Save Changes
                </PrimaryButton>

                <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                    <div v-if="form.recentlySuccessful" class="flex items-center gap-2 text-sm text-green-600">
                        <CheckCircleIcon class="h-5 w-5" />
                        <span class="font-medium">Profile updated successfully!</span>
                    </div>
                </Transition>
            </div>
        </form>
    </section>
</template>