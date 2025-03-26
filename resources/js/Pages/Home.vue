<script setup>
import { Head, Link, router } from '@inertiajs/vue3'
import { reactive } from 'vue'
import Footer from '@/Components/Footer.vue'

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    flights: {
        type: Array,
        default: () => [],
    },
    filters: {
        type: Object,
        default: () => ({ departure: '', destination: '' }),
    },
})

console.log('Flights from server:', props.flights);

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
    <div class="bg-white min-h-screen text-black dark:bg-black dark:text-white">
        <!-- Hero Header with Background -->
        <div
            class="h-[300px] bg-cover bg-center flex flex-col justify-between"
            style="background-image: url('/images/airplane_header.jpg')"
        >
            <!-- Top Nav -->
            <div class="flex justify-end p-6 gap-4 text-white bg-black/30">
                <Link
                    v-if="canLogin"
                    :href="route('login')"
                    class="hover:underline font-semibold"
                >Log In
                </Link>
                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="hover:underline font-semibold"
                >Register
                </Link>
            </div>

            <!-- Centered Title -->
            <div class="text-center text-white mb-8">
                <h1 class="text-4xl font-bold">Welcome to FuturaFly</h1>
                <p class="text-lg mt-2">Book your next adventure effortlessly</p>
            </div>
        </div>

        <!-- Content Section -->
        <div class="max-w-6xl mx-auto p-6">
            <!-- Flight Search -->
            <div class="mb-8">
                <h2 class="text-xl font-bold mb-4">Search Flights</h2>
                <form @submit.prevent="searchFlights" class="flex flex-wrap gap-4">
                    <input
                        v-model="search.departure"
                        placeholder="From"
                        class="border px-3 py-2 rounded w-full md:w-1/3"
                    />
                    <input
                        v-model="search.destination"
                        placeholder="To"
                        class="border px-3 py-2 rounded w-full md:w-1/3"
                    />
                    <button
                        type="submit"
                        class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700"
                    >
                        Search
                    </button>
                    <button
                        type="button"
                        class="bg-gray-300 text-black px-5 py-2 rounded hover:bg-gray-400"
                        @click="clearSearch"
                    >
                        Clear
                    </button>
                </form>
            </div>

            <!-- Flights -->
            <h2 class="text-2xl font-bold mb-4">Available Flights</h2>
            <div v-if="flights.length" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div
                    v-for="flight in flights"
                    :key="flight.id"
                    class="p-4 border border-gray-200 rounded shadow-sm bg-white dark:bg-gray-900"
                >
                    <p><strong>Airline:</strong> {{ flight.airline }}</p>
                    <p><strong>Flight #:</strong> {{ flight.flight_number }}</p>
                    <p><strong>From:</strong> {{ flight.departure }} → {{ flight.destination }}</p>
                    <p><strong>Departs:</strong> {{ new Date(flight.departure_time).toLocaleString() }}</p>
                    <p><strong>Arrives:</strong> {{ new Date(flight.arrival_time).toLocaleString() }}</p>
                    <p><strong>Seats Available:</strong> {{ flight.seats_available }}</p>
                    <p><strong>Price:</strong> ${{ flight.price }}</p>

                    <!-- Deal Badges -->
                    <div class="mt-2">
                        <span
                            v-if="flight.last_minute"
                            class="inline-block bg-red-600 text-white text-xs px-2 py-1 rounded-full mr-2"
                        >Last Minute Deal</span>
                        <span
                            v-if="flight.first_minute"
                            class="inline-block bg-green-600 text-white text-xs px-2 py-1 rounded-full"
                        >Early Bird</span>
                    </div>
                </div>
            </div>
            <div v-else class="text-gray-500">No flights found. Try a different search.</div>
        </div>

        <Footer/>
    </div>
</template>
