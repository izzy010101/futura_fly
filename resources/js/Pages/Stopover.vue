<script setup>
import HeaderComponent from '@/Components/HeaderComponent.vue'
import { ref } from 'vue'
import {Head, Link} from '@inertiajs/vue3'
import Footer from '@/Components/Footer.vue'
import { CheckCircleIcon } from '@heroicons/vue/24/solid'


defineProps({
    auth: Object,
    canLogin: Boolean,
    canRegister: Boolean,
})

const mobileMenuOpen = ref(false)
</script>

<template>
    <Head title="Stopover" />
    <div class="bg-gray-50 min-h-screen">
        <HeaderComponent :auth="auth"  :can-login="canLogin" :can-register="canRegister" />

        <!-- Hero section -->
        <section class="relative">
            <img src="/images/stopover.jpg" alt="Qatar Stopover" class="w-full h-[60vh] object-cover" />
            <div class="absolute inset-0 bg-black/40 flex items-center justify-center text-center px-4">
                <div class="text-white max-w-3xl">
                    <h1 class="text-4xl md:text-5xl font-bold mb-4">Stopover in Qatar for Just $14</h1>
                    <p class="text-lg md:text-xl text-gray-200">Turn your layover into a mini vacation with our exclusive Qatar stopover program. Book a 4-star hotel for as low as $14.</p>
                </div>
            </div>
        </section>

        <!-- Info section -->
        <section class="max-w-6xl mx-auto px-4 py-16 grid md:grid-cols-2 gap-12 items-center">
            <!-- Text Content -->
            <div>
                <h2 class="text-3xl font-bold text-[#002642] mb-4">Why choose a Qatar Stopover?</h2>
                <ul class="space-y-4 text-gray-700 text-lg">
                    <li class="flex items-start gap-3">
                        <CheckCircleIcon class="w-6 h-6 text-green-500 mt-1" />
                        4-star hotel stay starting at just $14
                    </li>
                    <li class="flex items-start gap-3">
                        <CheckCircleIcon class="w-6 h-6 text-green-500 mt-1" />
                        Explore Doha’s culture, cuisine & skyline
                    </li>
                    <li class="flex items-start gap-3">
                        <CheckCircleIcon class="w-6 h-6 text-green-500 mt-1" />
                        Includes airport transfers and optional city tour
                    </li>
                    <li class="flex items-start gap-3">
                        <CheckCircleIcon class="w-6 h-6 text-green-500 mt-1" />
                        Available on select long-haul flights with a stop in Doha
                    </li>
                </ul>

                <Link
                    href="/book"
                    class="inline-block mt-6 bg-[#22668D] text-white px-6 py-3 rounded-md font-semibold hover:bg-[#419197] transition"
                >
                    Plan Your Stopover
                </Link>
            </div>

            <!-- Side Image -->
            <div>
                <img src="/images/doha-city.jpg" alt="Doha City" class="rounded-xl shadow-lg w-full h-auto object-cover" />
            </div>
        </section>

        <!-- CTA block -->
        <section class="bg-[#002642] text-white py-16 text-center px-4">
            <h2 class="text-3xl font-bold mb-4">Add a memory to your journey</h2>
            <p class="text-lg max-w-2xl mx-auto mb-6">
                Take a break, explore a new country, and arrive refreshed. This is more than a stop — it’s a chance to experience Qatar’s magic.
            </p>
            <Link
                href="/explore"
                class="inline-block bg-white text-[#002642] px-6 py-3 rounded-md font-semibold hover:bg-gray-200 transition"
            >
                Discover More Destinations
            </Link>
        </section>
        <Footer />
    </div>
</template>
