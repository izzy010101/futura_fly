<script setup>
import HeaderComponent from '@/Components/HeaderComponent.vue'
import {Head, Link} from '@inertiajs/vue3'
import Footer from '@/Components/Footer.vue'

defineProps({
    auth: Object,
    canLogin: Boolean,
    canRegister: Boolean,
    springFlights: Array,
})
</script>

<template>
    <Head title="Spring" />
    <div class="bg-gray-50 min-h-screen">
        <HeaderComponent :auth="auth" :can-login="canLogin" :can-register="canRegister" />

        <!-- Hero section -->
        <section class="relative h-[60vh]">
            <picture class="absolute inset-0 w-full h-full z-0">
                <source srcset="/images/spring-offer-1600.jpg" media="(min-width: 1024px)">
                <source srcset="/images/spring-offer-800.jpg" media="(min-width: 640px)">
                <img
                    src="/images/spring-offer-400.jpg"
                    alt="Spring Offer"
                    class="w-full h-full object-cover"
                />
            </picture>

            <div class="absolute inset-0 bg-black/40 z-10 flex items-center justify-center text-center px-4">
                <div class="text-white max-w-3xl">
                    <h1 class="text-4xl md:text-5xl font-bold mb-4">Save 12% on Spring Flights</h1>
                    <p class="text-lg md:text-xl text-gray-200">From March to May, enjoy blooming savings on every spring getaway.</p>
                </div>
            </div>
        </section>

        <!-- Flights section -->
        <section class="max-w-7xl mx-auto px-4 py-16">
            <h2 class="text-2xl font-bold text-[#002642] mb-8">Eligible Spring Flights</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div
                    v-for="flight in springFlights"
                    :key="flight.id"
                    class="bg-white rounded-2xl shadow-md p-6 transition hover:shadow-lg"
                >
                    <h3 class="text-lg font-bold text-[#002642] mb-1">{{ flight.departure }} → {{ flight.destination }}</h3>
                    <p class="text-sm text-red-500 mb-1">Flight #: {{ flight.flight_number }}</p>
                    <p class="text-sm text-gray-500 mb-1">Departure: {{ new Date(flight.departure_time).toLocaleDateString() }}</p>
                    <p class="text-sm text-gray-500 mb-1">Seats Available: {{ flight.seats_available }}</p>
                    <div class="mt-3">
                        <p class="text-sm text-gray-600 line-through">${{ flight.price }}</p>
                        <p class="text-xl font-bold text-green-600">
                            ${{ (flight.price * 0.88).toFixed(2) }} <span class="text-sm text-gray-500">with 12% off</span>
                        </p>
                        <div v-if="auth?.user" class="mt-4">
                            <Link
                                :href="`/booking/${flight.id}?spring=1`"
                                class="inline-block bg-[#22668D] text-white px-4 py-2 rounded-md hover:bg-[#419197] transition"
                            >
                                Book Now
                            </Link>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <Footer/>
    </div>
</template>
