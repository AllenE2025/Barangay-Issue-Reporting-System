<script setup lang="ts">
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';
import {
    ExclamationTriangleIcon,
    TrashIcon,
    LockClosedIcon
} from '@heroicons/vue/24/outline';

const confirmingUserDeletion = ref(false);
const passwordInput = ref<HTMLInputElement | null>(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    nextTick(() => passwordInput.value?.focus());
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value?.focus(),
        onFinish: () => {
            form.reset();
        },
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.clearErrors();
    form.reset();
};
</script>

<template>
    <section class="space-y-6">
        <header>
            <div class="flex items-center gap-3 mb-2">
                <div class="bg-red-100 rounded-lg p-2">
                    <ExclamationTriangleIcon class="h-5 w-5 text-red-600" />
                </div>
                <h2 class="text-lg font-medium text-gray-900">
                    Delete Account
                </h2>
            </div>

            <div class="p-4 rounded-lg bg-red-50 border border-red-200">
                <p class="text-sm text-red-800">
                    <strong>Warning:</strong> Once your account is deleted, all of its resources and data will be
                    permanently deleted. Before deleting your account, please download any data or information that you
                    wish to retain.
                </p>
            </div>
        </header>

        <DangerButton @click="confirmUserDeletion" class="inline-flex items-center gap-2">
            <TrashIcon class="h-5 w-5" />
            Delete Account
        </DangerButton>

        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-6">
                <!-- Modal Header -->
                <div class="flex items-start gap-4 mb-4">
                    <div class="bg-red-100 rounded-full p-3 flex-shrink-0">
                        <ExclamationTriangleIcon class="h-8 w-8 text-red-600" />
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">
                            Delete Account?
                        </h2>
                        <p class="mt-2 text-sm text-gray-600">
                            This action cannot be undone. This will permanently delete your account and remove all your
                            data from our servers.
                        </p>
                    </div>
                </div>

                <!-- Warning Box -->
                <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200">
                    <p class="text-sm text-red-800">
                        Once your account is deleted, all of your issues, reports, and personal information will be
                        permanently deleted. Please enter your password to confirm.
                    </p>
                </div>

                <!-- Password Input -->
                <div>
                    <InputLabel for="password" value="Confirm Password" />

                    <div class="relative mt-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <LockClosedIcon class="h-5 w-5 text-gray-400" />
                        </div>
                        <TextInput id="password" ref="passwordInput" v-model="form.password" type="password"
                            class="block w-full pl-10" placeholder="Enter your password" @keyup.enter="deleteUser" />
                    </div>

                    <InputError :message="form.errors.password" class="mt-2" />
                </div>

                <!-- Action Buttons -->
                <div class="mt-6 flex justify-end gap-3">
                    <SecondaryButton @click="closeModal">
                        Cancel
                    </SecondaryButton>

                    <DangerButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                        @click="deleteUser" class="inline-flex items-center gap-2">
                        <TrashIcon class="h-5 w-5" />
                        Delete Account
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </section>
</template>