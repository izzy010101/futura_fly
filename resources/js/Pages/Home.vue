<script setup>
import { Head, router } from '@inertiajs/vue3'
import { reactive, ref } from 'vue'
import Footer from '@/Components/Footer.vue'
import HeaderComponent from "@/Components/HeaderComponent.vue"

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    flights: { type: Array, default: () => [] },
    filters: { type: Object, default: () => ({ departure: '', destination: '' }) },
})

const search = reactive({
    departure: props.filters.departure,
    destination: props.filters.destination,
})

const validationErrors = reactive({
    departure: '',
    destination: ''
})

function validateFields() {
    validationErrors.departure = search.departure.trim() ? '' : 'City is required.'
    validationErrors.destination = search.destination.trim() ? '' : 'City is required.'
    return !(validationErrors.departure || validationErrors.destination)
}

function searchFlights() {
    if (!validateFields()) return

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
    validationErrors.departure = ''
    validationErrors.destination = ''
    router.get('/')
}
</script>

<template>
    <Head title="Home" />
    <div class="min-h-screen bg-gray-50">
        <HeaderComponent :can-login="canLogin" :can-register="canRegister" />

        <!-- Hero Section -->
        <section class="relative bg-gradient-to-r from-[#22668D] to-[#419197] py-20">
            <div class="absolute inset-0 bg-cover bg-center opacity-20" style="background-image: url('/images/airplane_header.jpg');"></div>

            <div class="container mx-auto px-6 relative z-10 text-center text-white">
                <h1 class="text-4xl font-bold mb-4">Welcome to FuturaFly</h1>
                <p class="text-lg mb-8">Book your next adventure effortlessly</p>

                <!-- Search Form -->
                <form @submit.prevent="searchFlights"
                      class="max-w-4xl mx-auto bg-white rounded-lg shadow p-6 flex flex-wrap gap-4 justify-center text-left">

                    <!-- Departure -->
                    <div class="w-full md:w-1/4">
                        <input
                            v-model="search.departure"
                            placeholder="From"
                            @blur="validateFields"
                            :class="[
                                'px-4 py-2 rounded w-full text-gray-800 placeholder-gray-400 transition',
                                validationErrors.departure
                                  ? 'border-red-500 focus:border-red-500 focus:ring-red-500'
                                  : 'border border-gray-300 focus:border-[#22668D] focus:ring-[#22668D]'
                            ]"
                        />
                        <p v-if="validationErrors.departure" class="text-sm text-red-600 mt-1">
                            {{ validationErrors.departure }}
                        </p>
                    </div>

                    <!-- Destination -->
                    <div class="w-full md:w-1/4">
                        <input
                            v-model="search.destination"
                            placeholder="To"
                            @blur="validateFields"
                            :class="[
                                'px-4 py-2 rounded w-full text-gray-800 placeholder-gray-400 transition',
                                validationErrors.destination
                                  ? 'border-red-500 focus:border-red-500 focus:ring-red-500'
                                  : 'border border-gray-300 focus:border-[#22668D] focus:ring-[#22668D]'
                            ]"
                        />
                        <p v-if="validationErrors.destination" class="text-sm text-red-600 mt-1">
                            {{ validationErrors.destination }}
                        </p>
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-center gap-3 w-full md:w-auto mt-2 md:mt-0">
                        <button
                            type="submit"
                            class="bg-[#22668D] text-white px-5 py-2 rounded hover:bg-[#419197] w-full"
                        >
                            Search Flights
                        </button>
                        <button
                            type="button"
                            class="bg-gray-200 text-[#002642] px-5 py-2 rounded hover:bg-gray-300 w-full"
                            @click="clearSearch"
                        >
                            Clear
                        </button>
                    </div>
                </form>
            </div>
        </section>

        <!-- Matching Flights -->
        <section v-if="search.departure || search.destination" class="max-w-6xl mx-auto p-6">
            <h2 class="text-2xl font-bold mb-4 text-[#002642]">Matching Flights</h2>

            <div v-if="flights.length" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div
                    v-for="flight in flights"
                    :key="flight.id"
                    class="p-4 rounded shadow-sm bg-white border border-gray-200"
                >
                    <p><strong>Flight #:</strong> {{ flight.flight_number }}</p>
                    <p><strong>From:</strong> {{ flight.departure }} → {{ flight.destination }}</p>
                    <p><strong>Departs:</strong> {{ new Date(flight.departure_time).toLocaleString() }}</p>
                    <p><strong>Arrives:</strong> {{ new Date(flight.arrival_time).toLocaleString() }}</p>
                    <p><strong>Seats Available:</strong> {{ flight.seats_available }}</p>
                    <p><strong>Price:</strong> ${{ flight.price }}</p>
                </div>
            </div>

            <div v-else class="text-gray-500">No matching flights found.</div>
        </section>

        <Footer />
    </div>
</template>
