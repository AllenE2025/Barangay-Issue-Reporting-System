<script setup lang="ts">
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
import { DocumentTextIcon } from '@heroicons/vue/24/outline';
</script>

<template>
    <div class="guest-bg">
        <!-- Background effects -->
        <div class="guest-orb guest-orb-1"></div>
        <div class="guest-orb guest-orb-2"></div>
        <div class="guest-grid"></div>

        <!-- Brand mark at top -->
        <div class="guest-brand">
            <Link href="/" class="brand-link">
                <div class="brand-icon">
                    <DocumentTextIcon class="brand-icon-svg" />
                </div>
                <span class="brand-name">Barangay Issue System</span>
            </Link>
        </div>

        <!-- Card -->
        <div class="guest-card">
            <slot />
        </div>

        <!-- Footer note -->
        <p class="guest-footer">© 2026 Barangay Issue Reporting System</p>
    </div>
</template>

<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=Source+Sans+3:wght@300;400;500;600&display=swap');

:root {
    --primary: #0F4C75;
    --primary-dark: #0a3554;
    --accent: #F59E0B;
    --bg: #FAFAF7;
    --bg-card: #FFFFFF;
    --text: #1a1a2e;
    --text-muted: #6b7280;
    --border: #e8e4dc;
}

@keyframes floatA {

    0%,
    100% {
        transform: translateY(0);
    }

    50% {
        transform: translateY(-20px);
    }
}

@keyframes floatB {

    0%,
    100% {
        transform: translateY(0);
    }

    50% {
        transform: translateY(-12px);
    }
}

.guest-bg {
    min-height: 100vh;
    background: linear-gradient(160deg, #e8f0f7 0%, var(--bg) 50%, #f0ede8 100%);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 2rem 1rem;
    font-family: 'Source Sans 3', sans-serif;
    position: relative;
    overflow: hidden;
}

.guest-orb {
    position: absolute;
    border-radius: 50%;
    pointer-events: none;
    filter: blur(70px);
}

.guest-orb-1 {
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, rgba(15, 76, 117, 0.08) 0%, transparent 70%);
    top: -150px;
    right: -100px;
    animation: floatA 10s ease-in-out infinite;
}

.guest-orb-2 {
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(245, 158, 11, 0.06) 0%, transparent 70%);
    bottom: -100px;
    left: -80px;
    animation: floatB 13s ease-in-out infinite;
}

.guest-grid {
    position: absolute;
    inset: 0;
    background-image: radial-gradient(circle, rgba(15, 76, 117, 0.04) 1px, transparent 1px);
    background-size: 28px 28px;
    pointer-events: none;
}

.guest-brand {
    margin-bottom: 2rem;
    position: relative;
    z-index: 1;
}

.brand-link {
    display: flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
}

.brand-icon {
    width: 38px;
    height: 38px;
    background: var(--primary);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 14px rgba(15, 76, 117, 0.3);
}

.brand-icon-svg {
    width: 20px;
    height: 20px;
    color: white;
}

.brand-name {
    font-family: 'Playfair Display', serif;
    font-size: 1.1rem;
    font-weight: 800;
    color: var(--text);
}

.guest-card {
    width: 100%;
    max-width: 420px;
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 20px;
    padding: 2.25rem 2rem;
    box-shadow: 0 8px 40px rgba(15, 76, 117, 0.1), 0 1px 3px rgba(0, 0, 0, 0.04);
    position: relative;
    z-index: 1;
}

.guest-footer {
    margin-top: 2rem;
    font-size: 0.78rem;
    color: var(--text-muted);
    position: relative;
    z-index: 1;
}
</style>