<script setup>
import { Head } from '@inertiajs/vue3'
import HeaderComponent from '@/Components/HeaderComponent.vue'
import Footer from '@/Components/Footer.vue'

const props = defineProps({
    auth: Object,
    canLogin: Boolean,
    canRegister: Boolean,
    flights: { type: Array, default: () => [] },
    filters: { type: Object, default: () => ({ departure: '', destination: '' }) },
    canBook: Boolean,
})

</script>

<template>
    <Head title="Tokyo - Destination" />
    <div class="bg-gray-50 min-h-screen flex flex-col">
        <HeaderComponent :auth="auth" :can-login="canLogin" :can-register="canRegister" />

        <!-- Hero Section -->
        <section
            class="relative h-[60vh] bg-cover bg-center flex items-center justify-center text-white"
            style="background-image: url('/images/tokyo.jpg')"
        >
            <div class="absolute inset-0 bg-black/40"></div>
            <div class="relative z-10 text-center max-w-2xl px-4">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Experience Tokyo</h1>
                <p class="text-lg md:text-xl text-white/80">
                    Where ancient tradition meets futuristic innovation.
                </p>
            </div>
        </section>

        <!-- Content Section -->
        <section class="flex-1 max-w-5xl mx-auto px-4 py-16">
            <div class="space-y-10 text-gray-700">
                <div>
                    <h2 class="text-2xl font-bold text-[#002642] mb-2">Why Visit Tokyo?</h2>
                    <p>
                        Tokyo is a dazzling metropolis offering a captivating blend of ultra-modern skyscrapers,
                        historical temples, and lively street culture. From the buzzing energy of Shibuya Crossing
                        to the serenity of Meiji Shrine, Tokyo is a city that never stops surprising.
                    </p>
                </div>

                <div>
                    <h2 class="text-2xl font-bold text-[#002642] mb-2">Must-See Attractions</h2>
                    <ul class="list-disc pl-6 space-y-2">
                        <li>Tokyo Skytree – the tallest structure in Japan with panoramic views</li>
                        <li>Asakusa and Senso-ji Temple – a glimpse into Edo-period Tokyo</li>
                        <li>Shibuya & Harajuku – youth fashion and pop culture at its peak</li>
                        <li>Tsukiji Outer Market – fresh sushi and authentic street food</li>
                        <li>Odaiba – futuristic waterfront with entertainment and shopping</li>
                    </ul>
                </div>

                <div>
                    <h2 class="text-2xl font-bold text-[#002642] mb-2">Travel Tips</h2>
                    <p>
                        Japan's trains are incredibly punctual and efficient — get a prepaid Suica card for easy transport.
                        Respect local customs, like bowing and removing shoes when required. Most signs and maps are
                        bilingual, making navigation easier than you'd expect.
                    </p>
                </div>
            </div>
        </section>

        <Footer />
    </div>
</template>
