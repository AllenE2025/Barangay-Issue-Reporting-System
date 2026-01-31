<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    PencilSquareIcon,
    EyeIcon,
    CheckBadgeIcon,
    WrenchScrewdriverIcon,
    TrashIcon,
    ShieldExclamationIcon,
    SpeakerWaveIcon,
    SparklesIcon,
    DocumentTextIcon
} from '@heroicons/vue/24/outline';

defineProps<{
    canLogin?: boolean;
    canRegister?: boolean;
}>();
</script>

<template>

    <Head title="Barangay Issue Reporting System" />

    <div class="min-h-screen bg-gradient-to-b from-blue-50 to-white">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <h1 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                            <DocumentTextIcon class="h-6 w-6 text-blue-600" />
                            Barangay Issue System
                        </h1>
                    </div>
                    <div class="flex items-center space-x-4" v-if="canLogin">
                        <Link :href="route('public.issues')"
                            class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                            Community Progress
                        </Link>
                        <Link :href="route('login')"
                            class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                            Log in
                        </Link>
                        <Link v-if="canRegister" :href="route('register')"
                            class="bg-blue-600 text-white hover:bg-blue-700 px-4 py-2 rounded-md text-sm font-medium">
                            Register
                        </Link>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center">
                <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                    Report Issues in Your
                    <span class="text-blue-600">Barangay</span>
                </h1>
                <p class="mt-3 max-w-md mx-auto text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                    Help improve our community by reporting issues like broken streetlights, road damage, sanitation
                    problems, and more.
                    Track your reports and see them get resolved.
                </p>
                <div class="mt-5 max-w-md mx-auto sm:flex sm:justify-center md:mt-8">
                    <div class="rounded-md shadow">
                        <Link :href="route('register')"
                            class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 md:py-4 md:text-lg md:px-10">
                            Get Started
                        </Link>
                    </div>
                    <div class="mt-3 rounded-md shadow sm:mt-0 sm:ml-3">
                        <Link :href="route('login')"
                            class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-blue-600 bg-white hover:bg-gray-50 md:py-4 md:text-lg md:px-10">
                            Log In
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold text-gray-900">
                    How It Works
                </h2>
            </div>

            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <!-- Feature 1 -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white mb-4">
                        <PencilSquareIcon class="h-6 w-6" />
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">
                        Report Issues
                    </h3>
                    <p class="text-gray-500">
                        Submit complaints about infrastructure, sanitation, safety concerns, and other barangay issues
                        with detailed descriptions and locations.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white mb-4">
                        <EyeIcon class="h-6 w-6" />
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">
                        Track Progress
                    </h3>
                    <p class="text-gray-500">
                        Monitor the status of your reports from pending to in-progress to resolved. Stay updated on
                        actions taken by barangay officials.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white mb-4">
                        <CheckBadgeIcon class="h-6 w-6" />
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">
                        Get Results
                    </h3>
                    <p class="text-gray-500">
                        See your issues resolved by barangay officials. Help create a better, safer, and cleaner
                        community for everyone.
                    </p>
                </div>
            </div>
        </div>

        <!-- Categories Section -->
        <div class="bg-gray-50 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-extrabold text-gray-900">
                        What You Can Report
                    </h2>
                </div>

                <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6">
                    <div class="bg-white p-4 rounded-lg shadow text-center">
                        <div class="flex justify-center mb-2">
                            <WrenchScrewdriverIcon class="h-8 w-8 text-blue-600" />
                        </div>
                        <p class="text-sm font-medium text-gray-900">Infrastructure</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow text-center">
                        <div class="flex justify-center mb-2">
                            <TrashIcon class="h-8 w-8 text-blue-600" />
                        </div>
                        <p class="text-sm font-medium text-gray-900">Sanitation</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow text-center">
                        <div class="flex justify-center mb-2">
                            <ShieldExclamationIcon class="h-8 w-8 text-blue-600" />
                        </div>
                        <p class="text-sm font-medium text-gray-900">Safety</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow text-center">
                        <div class="flex justify-center mb-2">
                            <SpeakerWaveIcon class="h-8 w-8 text-blue-600" />
                        </div>
                        <p class="text-sm font-medium text-gray-900">Noise</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow text-center">
                        <div class="flex justify-center mb-2">
                            <SparklesIcon class="h-8 w-8 text-blue-600" />
                        </div>
                        <p class="text-sm font-medium text-gray-900">Environment</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow text-center">
                        <div class="flex justify-center mb-2">
                            <DocumentTextIcon class="h-8 w-8 text-blue-600" />
                        </div>
                        <p class="text-sm font-medium text-gray-900">Other</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="bg-blue-600 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                    Ready to Make a Difference?
                </h2>
                <p class="mt-4 text-lg text-blue-100">
                    Join our community in making the barangay a better place for everyone.
                </p>
                <div class="mt-8">
                    <Link :href="route('register')"
                        class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-blue-600 bg-white hover:bg-blue-50 md:py-4 md:text-lg md:px-10">
                        Create Account
                    </Link>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-gray-800 py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <p class="text-center text-gray-400 text-sm">
                    © 2026 Barangay Issue Reporting System. Built to serve the community.
                </p>
            </div>
        </footer>
    </div>
</template>