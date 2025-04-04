<script setup>
import HeaderComponent from '@/Components/HeaderComponent.vue'
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'
import { ClockIcon, FireIcon } from '@heroicons/vue/24/solid'
import Footer from '@/Components/Footer.vue'

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    earlyBirds: Array,
    lastMinutes: Array,
})

const mobileMenuOpen = ref(false)
</script>

<template>
    <div class="bg-gray-50 min-h-screen">
        <!-- Header -->
        <HeaderComponent :can-login="canLogin" :can-register="canRegister" />

        <!-- Hero / Intro -->
        <section class="text-center py-12 px-4 max-w-4xl mx-auto">
            <h1 class="text-4xl font-bold text-[#002642] mb-4">Unmissable Flight Offers</h1>
            <p class="text-lg text-gray-600">Plan ahead or take off now — find the perfect flight deal tailored just for you.</p>
        </section>

        <!-- Split Offers Section -->
        <section class="max-w-7xl mx-auto px-4 pb-16">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Early Bird Specials -->
                <div>
                    <h2 class="text-2xl font-semibold text-[#002642] mb-4 flex items-center gap-2">
                        <ClockIcon class="w-6 h-6 text-[#22668D]" />
                        Early Bird Specials
                    </h2>
                    <div class="space-y-4">
                        <div
                            v-for="flight in earlyBirds"
                            :key="flight.id"
                            class="bg-white rounded-2xl shadow-md hover:shadow-lg transition p-6"
                        >
                            <div class="flex justify-between items-center mb-2">
                                <h3 class="text-xl font-bold text-[#002642]">
                                    {{ flight.departure }} → {{ flight.destination }}
                                </h3>
                                <span class="text-sm bg-green-100 text-green-600 px-3 py-1 rounded-full">Early Bird</span>
                            </div>
                            <p class="text-gray-500 text-sm mb-1">Flight #{{ flight.flight_number }}</p>
                            <p class="text-gray-500 text-sm mb-1">Departs: {{ new Date(flight.departure_time).toLocaleDateString() }}</p>
                            <p class="text-lg font-semibold text-[#22668D] mt-2">${{ flight.price }}</p>
                        </div>
                    </div>
                </div>

                <!-- Last Minute Escapes -->
                <div>
                    <h2 class="text-2xl font-semibold text-[#002642] mb-4 flex items-center gap-2">
                        <FireIcon class="w-6 h-6 text-red-500" />
                        Last Minute Escapes
                    </h2>
                    <div class="space-y-4">
                        <div
                            v-for="flight in lastMinutes"
                            :key="flight.id"
                            class="bg-white rounded-2xl shadow-md hover:shadow-lg transition p-6"
                        >
                            <div class="flex justify-between items-center mb-2">
                                <h3 class="text-xl font-bold text-[#002642]">
                                    {{ flight.departure }} → {{ flight.destination }}
                                </h3>
                                <span class="text-sm bg-red-100 text-red-600 px-3 py-1 rounded-full">Last Minute</span>
                            </div>
                            <p class="text-gray-500 text-sm mb-1">Flight #{{ flight.flight_number }}</p>
                            <p class="text-gray-500 text-sm mb-1">Departs: {{ new Date(flight.departure_time).toLocaleDateString() }}</p>
                            <p class="text-lg font-semibold text-[#D9534F] mt-2">${{ flight.price }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <Footer/>
</template>
