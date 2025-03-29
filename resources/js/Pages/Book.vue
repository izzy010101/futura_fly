<script setup>
import { Head } from '@inertiajs/vue3'
import HeaderComponent from '@/Components/HeaderComponent.vue'
import Footer from '@/Components/Footer.vue'

const props = defineProps({
    flights: Array,
    canLogin: Boolean,
    canRegister: Boolean
})
</script>

<template>
    <Head title="Book a Flight" />

    <div class="min-h-screen bg-gray-50">
        <HeaderComponent :can-login="canLogin" :can-register="canRegister" />

        <section class="max-w-6xl mx-auto p-6">
            <h2 class="text-2xl font-bold mb-4 text-[#002642]">Available Flights</h2>

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

                    <div class="mt-2">
                        <span v-if="flight.last_minute" class="inline-block bg-red-600 text-white text-xs px-2 py-1 rounded-full mr-2">Last Minute Deal</span>
                        <span v-if="flight.first_minute" class="inline-block bg-green-600 text-white text-xs px-2 py-1 rounded-full">Early Bird</span>
                    </div>
                </div>
            </div>

            <div v-else class="text-gray-500">No flights available right now.</div>
        </section>

        <Footer />
    </div>
</template>
