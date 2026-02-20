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

const form = useForm({ password: '' });

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;
    nextTick(() => passwordInput.value?.focus());
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value?.focus(),
        onFinish: () => { form.reset(); },
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;
    form.clearErrors();
    form.reset();
};
</script>

<template>
    <section class="profile-section">
        <header class="profile-section-header">
            <div class="section-title-row">
                <div class="section-icon-wrap section-icon-red">
                    <ExclamationTriangleIcon class="section-icon" />
                </div>
                <h2 class="section-title">Delete Account</h2>
            </div>
            <div class="alert-msg alert-danger">
                <ExclamationTriangleIcon class="alert-icon" />
                <p class="alert-text">
                    <strong>Warning:</strong> Once your account is deleted, all of its resources and data will be
                    permanently deleted. Before deleting your account, please download any data or information that you
                    wish to retain.
                </p>
            </div>
        </header>

        <div style="padding-top: 0.25rem;">
            <button @click="confirmUserDeletion" class="delete-trigger-btn">
                <TrashIcon class="btn-icon" />
                Delete Account
            </button>
        </div>

        <!-- Confirmation Modal -->
        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="delete-modal">

                <!-- Modal header -->
                <div class="modal-header">
                    <div class="modal-icon-wrap">
                        <ExclamationTriangleIcon class="modal-icon" />
                    </div>
                    <div>
                        <h2 class="modal-title">Delete Account?</h2>
                        <p class="modal-subtitle">This action cannot be undone. This will permanently delete your
                            account and remove all your data from our servers.</p>
                    </div>
                </div>

                <!-- Warning -->
                <div class="alert-msg alert-danger" style="margin-bottom: 1.5rem;">
                    <ExclamationTriangleIcon class="alert-icon" />
                    <p class="alert-text">Once your account is deleted, all of your issues, reports, and personal
                        information will be permanently deleted. Please enter your password to confirm.</p>
                </div>

                <!-- Password -->
                <div class="field" style="margin-bottom: 1.5rem;">
                    <InputLabel for="password" value="Confirm Password" class="field-label" />
                    <div class="input-icon-wrap">
                        <!-- <LockClosedIcon class="input-left-icon" /> -->
                        <TextInput id="password" ref="passwordInput" v-model="form.password" type="password"
                            class="block w-full field-input field-input-icon" placeholder="Enter your password"
                            @keyup.enter="deleteUser" />
                    </div>
                    <InputError :message="form.errors.password" class="mt-2" />
                </div>

                <!-- Buttons -->
                <div class="modal-footer">
                    <button @click="closeModal" class="cancel-btn">Cancel</button>
                    <button @click="deleteUser" :disabled="form.processing" :class="{ 'opacity-25': form.processing }"
                        class="confirm-delete-btn">
                        <TrashIcon class="btn-icon" />
                        Delete Account
                    </button>
                </div>
            </div>
        </Modal>
    </section>
</template>

<style>
/* Danger alert variant */
.alert-danger {
    background: #fef2f2;
    border: 1px solid #fecaca;
    margin-top: 0.5rem;
}

.alert-danger .alert-icon {
    color: #dc2626;
}

.alert-danger .alert-text {
    color: #991b1b;
}

/* Delete trigger button */
.delete-trigger-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: transparent;
    color: #dc2626;
    border: 2px solid #dc2626;
    border-radius: 10px;
    padding: 9px 20px;
    font-family: 'Source Sans 3', sans-serif;
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.delete-trigger-btn:hover {
    background: #dc2626;
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 5px 16px rgba(220, 38, 38, 0.25);
}

/* Modal */
.delete-modal {
    padding: 2rem;
}

.modal-header {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.modal-icon-wrap {
    width: 48px;
    height: 48px;
    flex-shrink: 0;
    background: #fef2f2;
    border: 1px solid #fecaca;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-icon {
    width: 24px;
    height: 24px;
    color: #dc2626;
}

.modal-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.3rem;
    font-weight: 800;
    color: var(--text);
    margin: 0 0 0.35rem;
}

.modal-subtitle {
    font-size: 0.875rem;
    color: var(--text-muted);
    margin: 0;
    line-height: 1.6;
}

.modal-footer {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 0.75rem;
}

/* Cancel button */
.cancel-btn {
    background: transparent;
    color: var(--text-muted);
    border: 1px solid var(--border);
    border-radius: 9px;
    padding: 9px 20px;
    font-family: 'Source Sans 3', sans-serif;
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.cancel-btn:hover {
    border-color: var(--text-muted);
    color: var(--text);
}

/* Confirm delete button */
.confirm-delete-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: #dc2626;
    color: white;
    border: 2px solid #dc2626;
    border-radius: 9px;
    padding: 9px 20px;
    font-family: 'Source Sans 3', sans-serif;
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.confirm-delete-btn:hover:not(:disabled) {
    background: #b91c1c;
    border-color: #b91c1c;
    transform: translateY(-1px);
    box-shadow: 0 5px 16px rgba(220, 38, 38, 0.3);
}
</style>