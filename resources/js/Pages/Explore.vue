<script setup>
import { Head, Link } from '@inertiajs/vue3'
import HeaderComponent from '@/Components/HeaderComponent.vue'
import Footer from '@/Components/Footer.vue'

const props = defineProps({
    flights: { type: Array, default: () => [] },
    canLogin: Boolean,
    canRegister: Boolean,
})
</script>

<template>
    <Head title="Explore Flights" />
    <div class="min-h-screen bg-gray-50">
        <!-- Header with Login/Register to the left -->
        <HeaderComponent :can-login="canLogin" :can-register="canRegister" />

        <!-- Flights Section (Stylish Cards) -->
        <section class="max-w-7xl mx-auto px-4 py-10">
            <h2 class="text-3xl font-bold text-[#002642] mb-6 text-center">Available Flights</h2>

            <div v-if="flights.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div v-for="flight in flights" :key="flight.id"
                     class="bg-white shadow-lg rounded-lg overflow-hidden hover:shadow-2xl transition-shadow">
                    <div class="px-6 py-4">
                        <h3 class="text-xl font-semibold text-[#002642] mb-2">
                            {{ flight.departure }} → {{ flight.destination }}
                        </h3>
                        <p class="text-gray-600 mb-2">
                            <strong>Departs:</strong> {{ new Date(flight.departure_time).toLocaleString() }}
                        </p>
                        <p class="text-gray-600 mb-2">
                            <strong>Arrives:</strong> {{ new Date(flight.arrival_time).toLocaleString() }}
                        </p>
                        <p class="text-gray-600 mb-2">
                            <strong>Seats:</strong> {{ flight.seats_available }}
                        </p>
                        <p class="text-[#22668D] font-bold text-lg">
                            ${{ flight.price }}
                        </p>

                        <div class="mt-4 flex space-x-2">
                            <span v-if="flight.last_minute"
                                  class="bg-red-500 text-white text-xs px-2 py-1 rounded-full">Last Minute</span>
                            <span v-if="flight.first_minute"
                                  class="bg-green-500 text-white text-xs px-2 py-1 rounded-full">Early Bird</span>
                        </div>
                    </div>
                </div>
            </div>

            <div v-else class="text-center text-gray-500 mt-10">
                No available flights found.
            </div>
        </section>

        <Footer/>
    </div>
</template>
