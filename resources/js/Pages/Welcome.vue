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

    <div class="min-h-screen" style="background: var(--color-bg); font-family: 'Source Sans 3', sans-serif;">

        <!-- Navigation -->
        <nav style="background: rgba(250,250,247,0.92); backdrop-filter: blur(12px); border-bottom: 1px solid var(--color-border); position: sticky; top: 0; z-index: 100;"
            class="anim-fade-down">
            <div style="max-width: 1200px; margin: 0 auto; padding: 0 1.5rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; height: 64px;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <div
                            style="width: 36px; height: 36px; background: var(--color-primary); border-radius: 9px; display: flex; align-items: center; justify-content: center;">
                            <DocumentTextIcon style="width: 20px; height: 20px; color: white;" />
                        </div>
                        <div>
                            <h1
                                style="font-family: 'Playfair Display', serif; font-size: 1.05rem; font-weight: 800; color: var(--color-text); margin: 0; line-height: 1.1;">
                                Barangay Issue System</h1>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 8px;" v-if="canLogin">
                        <Link :href="route('public.issues')" class="nav-link">Community Progress</Link>
                        <Link :href="route('login')" class="nav-link">Log in</Link>
                        <Link v-if="canRegister" :href="route('register')" class="nav-btn">Register</Link>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div style="position: relative; overflow: hidden; padding: 5rem 1.5rem 4rem;">
            <div class="orb orb-1"></div>
            <div class="orb orb-2"></div>
            <!-- Subtle grid pattern -->
            <div
                style="position: absolute; inset: 0; background-image: radial-gradient(circle, rgba(15,76,117,0.06) 1px, transparent 1px); background-size: 32px 32px; pointer-events: none;">
            </div>

            <div style="max-width: 900px; margin: 0 auto; text-align: center; position: relative; z-index: 1;">
                <div class="anim-fade-up anim-delay-1">
                    <span class="hero-badge">
                        <span
                            style="width: 6px; height: 6px; background: var(--color-accent); border-radius: 50%; display: inline-block;"></span>
                        Community Reporting Platform
                    </span>
                </div>

                <h1 class="hero-title anim-fade-up anim-delay-2">
                    Report Issues in Your<br>
                    <span class="highlight">Barangay</span>
                </h1>

                <p style="margin-top: 1.5rem; max-width: 580px; margin-left: auto; margin-right: auto; color: var(--color-text-muted); font-size: 1.1rem; line-height: 1.7; font-weight: 300;"
                    class="anim-fade-up anim-delay-3">
                    Help improve our community by reporting issues like broken streetlights, road damage, sanitation
                    problems, and more. Track your reports and see them get resolved.
                </p>

                <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; margin-top: 2.5rem;"
                    class="anim-fade-up anim-delay-4">
                    <Link :href="route('register')" class="btn-primary">Get Started →</Link>
                    <Link :href="route('login')" class="btn-secondary">Log In</Link>
                </div>

                <!-- Stats bar -->
                <div style="display: flex; justify-content: center; margin-top: 4rem; background: white; border: 1px solid var(--color-border); border-radius: 16px; padding: 1.5rem 2rem; gap: 0; box-shadow: 0 4px 24px rgba(0,0,0,0.05); max-width: 560px; margin-left: auto; margin-right: auto;"
                    class="anim-fade-up anim-delay-5">
                    <div class="stat-item" style="flex: 1;">
                        <div class="stat-num">Fast</div>
                        <div class="stat-label">Report Submission</div>
                    </div>
                    <div class="stat-item" style="flex: 1;">
                        <div class="stat-num">Live</div>
                        <div class="stat-label">Status Tracking</div>
                    </div>
                    <div class="stat-item" style="flex: 1;">
                        <div class="stat-num">Free</div>
                        <div class="stat-label">For All Residents</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- How It Works Section -->
        <div style="padding: 5rem 1.5rem; background: white; border-top: 1px solid var(--color-border);">
            <div style="max-width: 1100px; margin: 0 auto;">
                <div style="text-align: center; margin-bottom: 3.5rem;">
                    <span class="section-label">Simple Process</span>
                    <h2 class="section-title">How It Works</h2>
                    <p style="color: var(--color-text-muted); margin-top: 0.75rem; font-size: 1rem;">Three simple steps
                        to a better community</p>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
                    <div class="feature-card" style="position: relative;">
                        <span class="step-number">1</span>
                        <div class="icon-wrap">
                            <PencilSquareIcon style="width: 24px; height: 24px; color: white;" />
                        </div>
                        <h3
                            style="font-family: 'Playfair Display', serif; font-size: 1.2rem; font-weight: 700; color: var(--color-text); margin-bottom: 0.75rem;">
                            Report Issues</h3>
                        <p style="color: var(--color-text-muted); line-height: 1.7; font-size: 0.95rem;">
                            Submit complaints about infrastructure, sanitation, safety concerns, and other barangay
                            issues
                            with detailed descriptions and locations.
                        </p>
                    </div>

                    <div class="feature-card" style="position: relative;">
                        <span class="step-number">2</span>
                        <div class="icon-wrap">
                            <EyeIcon style="width: 24px; height: 24px; color: white;" />
                        </div>
                        <h3
                            style="font-family: 'Playfair Display', serif; font-size: 1.2rem; font-weight: 700; color: var(--color-text); margin-bottom: 0.75rem;">
                            Track Progress</h3>
                        <p style="color: var(--color-text-muted); line-height: 1.7; font-size: 0.95rem;">
                            Monitor the status of your reports from pending to in-progress to resolved. Stay updated on
                            actions taken by barangay officials.
                        </p>
                    </div>

                    <div class="feature-card" style="position: relative;">
                        <span class="step-number">3</span>
                        <div class="icon-wrap">
                            <CheckBadgeIcon style="width: 24px; height: 24px; color: white;" />
                        </div>
                        <h3
                            style="font-family: 'Playfair Display', serif; font-size: 1.2rem; font-weight: 700; color: var(--color-text); margin-bottom: 0.75rem;">
                            Get Results</h3>
                        <p style="color: var(--color-text-muted); line-height: 1.7; font-size: 0.95rem;">
                            See your issues resolved by barangay officials. Help create a better, safer, and cleaner
                            community for everyone.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Categories Section -->
        <div style="padding: 5rem 1.5rem; background: var(--color-bg); border-top: 1px solid var(--color-border);">
            <div style="max-width: 1100px; margin: 0 auto;">
                <div style="text-align: center; margin-bottom: 3.5rem;">
                    <span class="section-label">Issue Categories</span>
                    <h2 class="section-title">What You Can Report</h2>
                    <p style="color: var(--color-text-muted); margin-top: 0.75rem; font-size: 1rem;">Any concern
                        affecting your community</p>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem;">
                    <div class="category-card">
                        <WrenchScrewdriverIcon class="cat-icon"
                            style="width: 2.2rem; height: 2.2rem; margin: 0 auto 0.75rem;" />
                        <p style="font-size: 0.9rem; font-weight: 600; color: var(--color-text);">Infrastructure</p>
                    </div>
                    <div class="category-card">
                        <TrashIcon class="cat-icon" style="width: 2.2rem; height: 2.2rem; margin: 0 auto 0.75rem;" />
                        <p style="font-size: 0.9rem; font-weight: 600; color: var(--color-text);">Sanitation</p>
                    </div>
                    <div class="category-card">
                        <ShieldExclamationIcon class="cat-icon"
                            style="width: 2.2rem; height: 2.2rem; margin: 0 auto 0.75rem;" />
                        <p style="font-size: 0.9rem; font-weight: 600; color: var(--color-text);">Safety</p>
                    </div>
                    <div class="category-card">
                        <SpeakerWaveIcon class="cat-icon"
                            style="width: 2.2rem; height: 2.2rem; margin: 0 auto 0.75rem;" />
                        <p style="font-size: 0.9rem; font-weight: 600; color: var(--color-text);">Noise</p>
                    </div>
                    <div class="category-card">
                        <SparklesIcon class="cat-icon" style="width: 2.2rem; height: 2.2rem; margin: 0 auto 0.75rem;" />
                        <p style="font-size: 0.9rem; font-weight: 600; color: var(--color-text);">Environment</p>
                    </div>
                    <div class="category-card">
                        <DocumentTextIcon class="cat-icon"
                            style="width: 2.2rem; height: 2.2rem; margin: 0 auto 0.75rem;" />
                        <p style="font-size: 0.9rem; font-weight: 600; color: var(--color-text);">Other</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="cta-section" style="padding: 5rem 1.5rem;">
            <div style="max-width: 700px; margin: 0 auto; text-align: center; position: relative; z-index: 1;">
                <span
                    style="display: inline-block; background: rgba(245,158,11,0.15); border: 1px solid rgba(245,158,11,0.3); color: #fcd34d; font-size: 0.78rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; padding: 5px 16px; border-radius: 999px; margin-bottom: 1.25rem;">Take
                    Action</span>
                <h2
                    style="font-family: 'Playfair Display', serif; font-size: clamp(2rem, 4vw, 3rem); font-weight: 800; color: white; line-height: 1.15; margin-bottom: 1.25rem;">
                    Ready to Make a Difference?
                </h2>
                <p
                    style="color: rgba(255,255,255,0.7); font-size: 1.05rem; line-height: 1.7; margin-bottom: 2.5rem; font-weight: 300;">
                    Join our community in making the barangay a better place for everyone.
                </p>
                <Link :href="route('register')" class="btn-accent">
                    Create Account — It's Free
                </Link>
            </div>
        </div>

        <!-- Footer -->
        <footer style="background: #111827; padding: 2rem 1.5rem; border-top: 1px solid rgba(255,255,255,0.05);">
            <div
                style="max-width: 1100px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <div
                        style="width: 28px; height: 28px; background: var(--color-primary); border-radius: 7px; display: flex; align-items: center; justify-content: center;">
                        <DocumentTextIcon style="width: 16px; height: 16px; color: white;" />
                    </div>
                    <span
                        style="font-family: 'Playfair Display', serif; color: white; font-weight: 700; font-size: 0.9rem;">Barangay
                        Issue System</span>
                </div>
                <p style="color: #6b7280; font-size: 0.82rem; margin: 0;">
                    © 2026 Barangay Issue Reporting System. Built to serve the community.
                </p>
            </div>
        </footer>
    </div>
</template>
<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=Source+Sans+3:wght@300;400;500;600&display=swap');

:root {
    --color-primary: #0F4C75;
    --color-primary-dark: #0a3554;
    --color-accent: #F59E0B;
    --color-accent-hover: #D97706;
    --color-terracotta: #C2714F;
    --color-bg: #FAFAF7;
    --color-bg-card: #FFFFFF;
    --color-text: #1a1a2e;
    --color-text-muted: #6b7280;
    --color-border: #e8e4dc;
}

.font-display {
    font-family: 'Playfair Display', Georgia, serif;
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(28px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes shimmer {
    0% {
        background-position: -200% center;
    }

    100% {
        background-position: 200% center;
    }
}

@keyframes floatA {

    0%,
    100% {
        transform: translateY(0px) rotate(0deg);
    }

    50% {
        transform: translateY(-18px) rotate(3deg);
    }
}

@keyframes floatB {

    0%,
    100% {
        transform: translateY(0px) rotate(0deg);
    }

    50% {
        transform: translateY(-12px) rotate(-2deg);
    }
}

@keyframes pulse-ring {
    0% {
        transform: scale(1);
        opacity: 0.6;
    }

    100% {
        transform: scale(1.5);
        opacity: 0;
    }
}

@keyframes slideInLeft {
    from {
        opacity: 0;
        transform: translateX(-30px);
    }

    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.anim-fade-up {
    animation: fadeInUp 0.7s ease forwards;
}

.anim-fade-down {
    animation: fadeInDown 0.5s ease forwards;
}

.anim-delay-1 {
    animation-delay: 0.1s;
    opacity: 0;
}

.anim-delay-2 {
    animation-delay: 0.25s;
    opacity: 0;
}

.anim-delay-3 {
    animation-delay: 0.4s;
    opacity: 0;
}

.anim-delay-4 {
    animation-delay: 0.55s;
    opacity: 0;
}

.anim-delay-5 {
    animation-delay: 0.7s;
    opacity: 0;
}

.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(245, 158, 11, 0.12);
    border: 1px solid rgba(245, 158, 11, 0.3);
    color: #92400e;
    font-size: 0.8rem;
    font-weight: 600;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    padding: 6px 16px;
    border-radius: 999px;
    margin-bottom: 1.5rem;
}

.hero-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2.5rem, 6vw, 4.5rem);
    font-weight: 800;
    line-height: 1.1;
    color: var(--color-text);
    letter-spacing: -0.02em;
}

.hero-title .highlight {
    color: var(--color-primary);
    position: relative;
    display: inline-block;
}

.hero-title .highlight::after {
    content: '';
    position: absolute;
    bottom: 4px;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--color-accent);
    border-radius: 2px;
    transform-origin: left;
    animation: slideInLeft 0.6s 0.9s ease forwards;
    transform: scaleX(0);
}

.btn-primary {
    background: var(--color-primary);
    color: white;
    padding: 14px 32px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.2s ease;
    border: 2px solid var(--color-primary);
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
}

.btn-primary:hover {
    background: var(--color-primary-dark);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(15, 76, 117, 0.35);
}

.btn-secondary {
    background: transparent;
    color: var(--color-primary);
    padding: 14px 32px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.2s ease;
    border: 2px solid var(--color-primary);
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.btn-secondary:hover {
    background: var(--color-primary);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(15, 76, 117, 0.2);
}

.btn-accent {
    background: var(--color-accent);
    color: #1a1a2e;
    padding: 16px 40px;
    border-radius: 10px;
    font-weight: 700;
    font-size: 1.05rem;
    transition: all 0.2s ease;
    border: 2px solid var(--color-accent);
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.btn-accent:hover {
    background: var(--color-accent-hover);
    border-color: var(--color-accent-hover);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(245, 158, 11, 0.4);
}

.feature-card {
    background: var(--color-bg-card);
    border: 1px solid var(--color-border);
    border-radius: 16px;
    padding: 2rem;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.feature-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--color-primary), var(--color-accent));
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.3s ease;
}

.feature-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 50px rgba(15, 76, 117, 0.12);
    border-color: rgba(15, 76, 117, 0.2);
}

.feature-card:hover::before {
    transform: scaleX(1);
}

.icon-wrap {
    width: 52px;
    height: 52px;
    border-radius: 12px;
    background: linear-gradient(135deg, var(--color-primary), #1a6898);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.25rem;
    position: relative;
}

.icon-wrap::after {
    content: '';
    position: absolute;
    inset: -4px;
    border-radius: 16px;
    background: linear-gradient(135deg, var(--color-primary), var(--color-accent));
    opacity: 0;
    z-index: -1;
    transition: opacity 0.3s;
}

.feature-card:hover .icon-wrap::after {
    opacity: 0.2;
}

.category-card {
    background: var(--color-bg-card);
    border: 1px solid var(--color-border);
    border-radius: 14px;
    padding: 1.25rem 1rem;
    text-align: center;
    transition: all 0.25s ease;
    cursor: default;
}

.category-card:hover {
    border-color: var(--color-primary);
    background: rgba(15, 76, 117, 0.04);
    transform: translateY(-4px);
    box-shadow: 0 10px 30px rgba(15, 76, 117, 0.1);
}

.category-card:hover .cat-icon {
    color: var(--color-accent);
}

.cat-icon {
    color: var(--color-primary);
    transition: color 0.25s;
}

.section-label {
    font-size: 0.8rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--color-terracotta);
    margin-bottom: 0.75rem;
    display: block;
}

.section-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(1.8rem, 3.5vw, 2.5rem);
    font-weight: 800;
    color: var(--color-text);
    line-height: 1.2;
}

/* Hero blob */
.hero-blob {
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
    pointer-events: none;
    z-index: 0;
}

/* Stats bar */
.stat-item {
    text-align: center;
    padding: 0 2rem;
    border-right: 1px solid var(--color-border);
}

.stat-item:last-child {
    border-right: none;
}

.stat-num {
    font-family: 'Playfair Display', serif;
    font-size: 2rem;
    font-weight: 800;
    color: var(--color-primary);
}

.stat-label {
    font-size: 0.85rem;
    color: var(--color-text-muted);
}

/* Nav link hover */
.nav-link {
    color: #4b5563;
    font-weight: 500;
    font-size: 0.9rem;
    padding: 8px 14px;
    border-radius: 8px;
    transition: all 0.2s;
    text-decoration: none;
    position: relative;
}

.nav-link:hover {
    color: var(--color-primary);
    background: rgba(15, 76, 117, 0.06);
}

.nav-btn {
    background: var(--color-primary);
    color: white;
    font-weight: 600;
    font-size: 0.9rem;
    padding: 8px 20px;
    border-radius: 8px;
    transition: all 0.2s;
    text-decoration: none;
}

.nav-btn:hover {
    background: var(--color-primary-dark);
    transform: translateY(-1px);
}

/* CTA section */
.cta-section {
    background: linear-gradient(135deg, var(--color-primary) 0%, #0a3554 50%, #0d3d65 100%);
    position: relative;
    overflow: hidden;
}

.cta-section::before {
    content: '';
    position: absolute;
    top: -60%;
    right: -10%;
    width: 500px;
    height: 500px;
    background: rgba(245, 158, 11, 0.08);
    border-radius: 50%;
    filter: blur(60px);
}

.cta-section::after {
    content: '';
    position: absolute;
    bottom: -40%;
    left: -5%;
    width: 400px;
    height: 400px;
    background: rgba(255, 255, 255, 0.04);
    border-radius: 50%;
    filter: blur(60px);
}

/* Floating orbs */
.orb {
    position: absolute;
    border-radius: 50%;
    pointer-events: none;
}

.orb-1 {
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, rgba(15, 76, 117, 0.08) 0%, transparent 70%);
    top: -80px;
    right: 10%;
    animation: floatA 8s ease-in-out infinite;
}

.orb-2 {
    width: 200px;
    height: 200px;
    background: radial-gradient(circle, rgba(245, 158, 11, 0.07) 0%, transparent 70%);
    bottom: 10%;
    left: 5%;
    animation: floatB 10s ease-in-out infinite;
}

.step-number {
    font-family: 'Playfair Display', serif;
    font-size: 4rem;
    font-weight: 800;
    color: rgba(15, 76, 117, 0.08);
    line-height: 1;
    position: absolute;
    top: 12px;
    right: 20px;
    pointer-events: none;
    user-select: none;
}
</style>