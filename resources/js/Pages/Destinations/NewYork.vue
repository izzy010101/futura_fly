<script setup>
import HeaderComponent from '@/Components/HeaderComponent.vue'
import Footer from '@/Components/Footer.vue'
import {Head, Link} from '@inertiajs/vue3'

defineProps({
    auth: Object,
    canLogin: Boolean,
    canRegister: Boolean
})
</script>

<template>
    <Head title="NY - Destination" />
    <div class="bg-gray-50 min-h-screen">
        <HeaderComponent :auth="auth" :can-login="canLogin" :can-register="canRegister" />

        <!-- Hero -->
        <section class="relative">
            <img src="/images/newyork.jpg" alt="New York" class="w-full h-[65vh] object-cover" />
            <div class="absolute inset-0 bg-black/40 flex items-center justify-center text-center px-4">
                <div class="text-white max-w-3xl">
                    <h1 class="text-4xl md:text-5xl font-bold mb-4">New York City</h1>
                    <p class="text-lg md:text-xl text-gray-200">The city that never sleeps. Discover the magic of NYC from Times Square to the Statue of Liberty.</p>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <section class="max-w-7xl mx-auto px-4 py-16 grid md:grid-cols-2 gap-12 items-center">
            <!-- Text -->
            <div>
                <h2 class="text-3xl font-bold text-[#002642] mb-4">Explore the Heart of America</h2>
                <p class="text-gray-700 text-lg leading-relaxed mb-4">
                    From iconic skyscrapers and Broadway shows to world-class dining and vibrant neighborhoods, New York offers something for everyone.
                </p>
                <ul class="list-disc list-inside text-gray-700 space-y-2 text-base">
                    <li>Visit the Empire State Building and Central Park</li>
                    <li>Catch a show on Broadway</li>
                    <li>Take a ferry to the Statue of Liberty</li>
                    <li>Explore art at the MET and MoMA</li>
                </ul>
                <Link href="/explore" class="mt-6 inline-block bg-[#22668D] text-white px-6 py-3 rounded-md font-semibold hover:bg-[#419197] transition">Explore More</Link>
            </div>

            <!-- Image -->
            <div>
                <img
                    src="/images/nyc-skyline.jpg"
                    loading="lazy"
                    alt="NYC Skyline"
                    class="rounded-xl shadow-lg w-full object-cover aspect-[4/3]"
                />
            </div>
        </section>

        <Footer />
    </div>
</template>
