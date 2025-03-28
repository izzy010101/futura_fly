<script setup>
import { Head, Link, router } from '@inertiajs/vue3'
import { reactive } from 'vue'
import Footer from '@/Components/Footer.vue'
import { ref } from 'vue'
import HeaderComponent from "@/Components/HeaderComponent.vue";

const mobileMenuOpen = ref(false)

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    flights: { type: Array, default: () => [] },
    filters: { type: Object, default: () => ({departure: '', destination: ''}) },
})

const search = reactive({
    departure: props.filters.departure,
    destination: props.filters.destination,
})

function searchFlights() {
    router.get('/', {
        departure: search.departure.trim(),
        destination: search.destination.trim(),
    }, {
        preserveScroll: true,
        preserveState: true,
    })
}

function clearSearch() {
    search.departure = ''
    search.destination = ''
    router.get('/')
}
</script>

<template>
    <Head title="Home"/>
    <div class="min-h-screen bg-gray-50">
        <!-- Header -->

        <HeaderComponent :can-login="canLogin" :can-register="canRegister" />


        <!-- Hero Section with search -->
        <section class="relative bg-gradient-to-r from-[#22668D] to-[#419197] py-20">
            <div class="absolute inset-0 bg-cover bg-center opacity-20" style="background-image: url('/images/airplane_header.jpg');"></div>

            <div class="container mx-auto px-6 relative z-10 text-center text-white">
                <h1 class="text-4xl font-bold mb-4">Welcome to FuturaFly</h1>
                <p class="text-lg mb-8">Book your next adventure effortlessly</p>

                <!-- Your existing search logic/form -->
                <form @submit.prevent="searchFlights" class="max-w-4xl mx-auto bg-white rounded-lg shadow p-6 flex flex-wrap gap-4 justify-center">
                    <input
                        v-model="search.departure"
                        placeholder="From"
                        class="border px-4 py-2 rounded w-full md:w-1/4 text-gray-800 placeholder-gray-400"
                    />

                    <input
                        v-model="search.destination"
                        placeholder="To"
                        class="border px-4 py-2 rounded w-full md:w-1/4 text-gray-800 placeholder-gray-400"
                    />
                    <button
                        type="submit"
                        class="bg-[#22668D] text-white px-5 py-2 rounded hover:bg-[#419197]"
                    >
                        Search Flights
                    </button>
                    <button
                        type="button"
                        class="bg-gray-200 text-[#002642] px-5 py-2 rounded hover:bg-gray-300"
                        @click="clearSearch"
                    >
                        Clear
                    </button>
                </form>
            </div>
        </section>

        <!-- Flights List (unchanged, your existing logic) -->
        <section class="max-w-6xl mx-auto p-6">
            <h2 class="text-2xl font-bold mb-4 text-[#002642]">Available Flights</h2>
            <div v-if="flights.length" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div
                    v-for="flight in flights"
                    :key="flight.id"
                    class="p-4 rounded shadow-sm bg-white border border-gray-200"
                >
                    <p><strong>Airline:</strong> {{ flight.airline }}</p>
                    <p><strong>Flight #:</strong> {{ flight.flight_number }}</p>
                    <p><strong>From:</strong> {{ flight.departure }} → {{ flight.destination }}</p>
                    <p><strong>Departs:</strong> {{ new Date(flight.departure_time).toLocaleString() }}</p>
                    <p><strong>Arrives:</strong> {{ new Date(flight.arrival_time).toLocaleString() }}</p>
                    <p><strong>Seats Available:</strong> {{ flight.seats_available }}</p>
                    <p><strong>Price:</strong> ${{ flight.price }}</p>

                    <div class="mt-2">
                        <span v-if="flight.last_minute" class="inline-block bg-red-600 text-white text-xs px-2 py-1 rounded-full mr-2">Last Minute Deal</span>
                        <span v-if="flight.first_minute" class="inline-block bg-green-600 text-white text-xs px-2 py-1 rounded-full">Early Bird</span>
                    </div>
                </div>
            </div>
            <div v-else class="text-gray-500">No flights found. Try a different search.</div>
        </section>

        <Footer/>
    </div>
</template>
