<script setup>
import { Head, Link } from '@inertiajs/vue3'
import HeaderComponent from '@/Components/HeaderComponent.vue'
import Footer from '@/Components/Footer.vue'

const props = defineProps({
    auth: Object,
    canLogin: Boolean,
    canRegister: Boolean,
    flights: {type: Array, default: () => []},
    filters: {type: Object, default: () => ({departure: '', destination: ''})},
    canBook: Boolean,
})
</script>

<template>
    <Head title="Destinations"/>
    <div class="min-h-screen bg-gray-50 flex flex-col">
        <HeaderComponent :auth="auth" :can-login="canLogin" :can-register="canRegister"/>

        <!-- Hero Section -->
        <section class="relative h-[60vh] bg-cover bg-center flex items-center justify-center text-white">
            <picture class="absolute inset-0 w-full h-full">
                <source srcset="/images/destinations-hero-1600.jpg" media="(min-width: 1024px)">
                <source srcset="/images/destinations-hero-800.jpg" media="(min-width: 640px)">
                <img
                    src="/images/destinations-hero-400.jpg"
                    alt="Destinations Hero"
                    class="w-full h-full object-cover"
                />
            </picture>
            <div class="absolute inset-0 bg-black/60"></div>
            <div class="relative z-10 text-center max-w-2xl px-6">
                <h1 class="text-4xl md:text-5xl font-bold leading-tight">Discover the World</h1>
                <p class="text-lg mt-4 text-white/80">Your next adventure is waiting — explore our most popular
                    destinations today.</p>
            </div>
        </section>

        <!-- Destinations Grid -->
        <section class="max-w-7xl mx-auto px-4 py-16">
            <h2 class="text-3xl font-bold text-[#002642] mb-10 text-center">Top Destinations</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

                <Link href="/destinations/new-york" class="group bg-white shadow hover:shadow-lg rounded-xl overflow-hidden">
                    <picture>
                        <source srcset="/images/newyork-1600.jpg" media="(min-width: 1024px)">
                        <source srcset="/images/newyork-800.jpg" media="(min-width: 640px)">
                        <img
                            src="/images/newyork-400.jpg"
                            alt="New York"
                            class="w-full h-56 object-cover group-hover:scale-105 transition-transform duration-300"
                        />
                    </picture>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-[#002642] mb-2">New York</h3>
                        <p class="text-gray-600">Experience the energy of the city that never sleeps — iconic landmarks, world-class dining, and more.</p>
                    </div>
                </Link>

                <Link href="/destinations/berlin" class="group bg-white shadow hover:shadow-lg rounded-xl overflow-hidden">
                    <picture>
                        <source srcset="/images/berlin-1600.jpg" media="(min-width: 1024px)">
                        <source srcset="/images/berlin-800.jpg" media="(min-width: 640px)">
                        <img
                            src="/images/berlin-400.jpg"
                            alt="Berlin"
                            class="w-full h-56 object-cover group-hover:scale-105 transition-transform duration-300"
                        />
                    </picture>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-[#002642] mb-2">Berlin</h3>
                        <p class="text-gray-600">Explore the capital of culture and creativity. History, art, and modern charm await in Berlin.</p>
                    </div>
                </Link>

                <Link href="/destinations/tokyo" class="group bg-white shadow hover:shadow-lg rounded-xl overflow-hidden">
                    <picture>
                        <source srcset="/images/tokyo-1600.jpg" media="(min-width: 1024px)">
                        <source srcset="/images/tokyo-800.jpg" media="(min-width: 640px)">
                        <img
                            src="/images/tokyo-400.jpg"
                            alt="Tokyo"
                            class="w-full h-56 object-cover group-hover:scale-105 transition-transform duration-300"
                        />
                    </picture>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-[#002642] mb-2">Tokyo</h3>
                        <p class="text-gray-600">Where neon lights meet ancient shrines — Tokyo is the heart of Japan's future and past.</p>
                    </div>
                </Link>

            </div>
        </section>


        <!-- CTA Banner -->
        <section class="bg-[#002642] py-16 text-white text-center">
            <div class="max-w-2xl mx-auto px-4">
                <h2 class="text-3xl font-bold mb-4">Ready to take off?</h2>
                <p class="mb-6 text-lg">Browse available flights and get closer to your next great adventure.</p>
                <Link href="/explore" class="bg-[#22668D] hover:bg-[#419197] px-6 py-3 rounded-md font-semibold">Search
                    Flights
                </Link>
            </div>
        </section>

        <Footer/>
    </div>
</template>
