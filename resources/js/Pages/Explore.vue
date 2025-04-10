<script setup>
import { Head } from '@inertiajs/vue3'
import HeaderComponent from '@/Components/HeaderComponent.vue'
import Footer from '@/Components/Footer.vue'
import FlightCard from '@/Components/FlightCard.vue'

const props = defineProps({
    auth: Object,
    flights: { type: Array, default: () => [] },
    canLogin: Boolean,
    canRegister: Boolean,
    canBook: Boolean,
})
</script>

<template>
    <Head title="Explore Flights" />
    <div class="min-h-screen bg-gray-50 flex flex-col">
        <!-- Header -->
        <HeaderComponent :auth="auth" :can-login="canLogin" :can-register="canRegister" />

        <!-- Hero Section -->
        <section class="relative h-[60vh] bg-cover bg-center flex items-center justify-center text-white">
            <picture class="absolute inset-0 w-full h-full">
                <source srcset="/images/explore-1600.jpg" media="(min-width: 1024px)">
                <source srcset="/images/explore-800.jpg" media="(min-width: 640px)">
                <img
                    src="/images/explore-400.jpg"
                    alt="Discover"
                    class="w-full h-full object-cover"
                />
            </picture>

            <div class="absolute inset-0 bg-black/50"></div>

            <div class="relative z-10 text-center px-4 max-w-2xl">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Discover Your Next Journey</h1>
                <p class="text-lg text-white/80">
                    Browse all available flights and find your perfect getaway with FuturaFly.
                </p>
            </div>
        </section>


        <!-- Flights Section -->
        <section class="flex-1 max-w-7xl mx-auto px-4 py-12">
            <h2 class="text-3xl font-bold text-[#002642] mb-8 text-center">Available Flights</h2>

            <div v-if="flights.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div
                    v-for="flight in flights"
                    :key="flight.id"
                    class="flex flex-col h-full"
                >
                    <div class="flex-1 flex">
                        <!-- Use min-h-full + w-full to stretch all FlightCards equally -->
                        <FlightCard :flight="flight" class="w-full min-h-full" :can-book="canBook" />

                    </div>
                </div>
            </div>

            <div v-else class="text-center text-gray-500 mt-10">
                No available flights found.
            </div>
        </section>

        <!-- Footer -->
        <Footer />
    </div>
</template>
