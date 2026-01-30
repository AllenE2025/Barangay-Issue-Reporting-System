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
        <div class="mb-6 text-center">
            <div class="flex justify-center mb-3">
                <div class="bg-blue-100 rounded-full p-3">
                    <UserPlusIcon class="h-8 w-8 text-blue-600" />
                </div>
            </div>
            <h2 class="text-2xl font-bold text-gray-900">Create an Account</h2>
            <p class="mt-2 text-sm text-gray-600">
                Join our community and start reporting issues
            </p>
        </div>

        <form @submit.prevent="submit" class="space-y-5">
            <!-- Name -->
            <div>
                <InputLabel for="name" value="Full Name" />

                <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus
                    autocomplete="name" placeholder="Juan Dela Cruz" />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <!-- Email -->
            <div>
                <InputLabel for="email" value="Email Address" />

                <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required
                    autocomplete="username" placeholder="juan@example.com" />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <!-- Password -->
            <div>
                <InputLabel for="password" value="Password" />

                <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required
                    autocomplete="new-password" placeholder="••••••••" />

                <InputError class="mt-2" :message="form.errors.password" />
                <p class="mt-1 text-xs text-gray-500">Must be at least 8 characters</p>
            </div>

            <!-- Confirm Password -->
            <div>
                <InputLabel for="password_confirmation" value="Confirm Password" />

                <TextInput id="password_confirmation" type="password" class="mt-1 block w-full"
                    v-model="form.password_confirmation" required autocomplete="new-password" placeholder="••••••••" />

                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <PrimaryButton class="w-full justify-center" :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing">
                    <UserPlusIcon class="h-5 w-5 mr-2" />
                    Create Account
                </PrimaryButton>
            </div>

            <!-- Login Link -->
            <div class="text-center pt-4 border-t border-gray-200">
                <p class="text-sm text-gray-600">
                    Already have an account?
                    <Link :href="route('login')"
                        class="font-medium text-blue-600 hover:text-blue-500 focus:outline-none focus:underline transition">
                        Sign in
                    </Link>
                </p>
            </div>
        </form>
    </GuestLayout>
</template>