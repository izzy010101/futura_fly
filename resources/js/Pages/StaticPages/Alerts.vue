<script setup>
import { Head } from '@inertiajs/vue3'
import HeaderComponent from '@/Components/HeaderComponent.vue'
import Footer from '@/Components/Footer.vue'

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
})
</script>

<template>
    <Head title="Travel Alerts" />
    <div class="bg-gray-50 min-h-screen flex flex-col">
        <HeaderComponent :can-login="canLogin" :can-register="canRegister" />

        <!-- Hero Section -->
        <section class="bg-[#002642] text-white py-16 px-6 text-center">
            <h1 class="text-4xl font-bold mb-3">Travel Alerts & Updates</h1>
            <p class="text-white/80 max-w-2xl mx-auto text-lg">
                Stay informed with the latest updates on flight disruptions, weather conditions, and global travel advisories.
            </p>
        </section>

        <!-- Alerts Section -->
        <section class="max-w-4xl mx-auto py-16 px-4 space-y-10">
            <!-- Alert 1 -->
            <div class="bg-white border-l-4 border-red-500 shadow-sm p-6 rounded-lg">
                <h2 class="text-xl font-semibold text-[#002642] mb-2">Weather Delay: New York to Berlin</h2>
                <p class="text-gray-700">
                    Due to heavy snowfall, all flights between New York (JFK) and Berlin (BER) are experiencing delays of up to 4 hours.
                    We recommend checking your flight status before heading to the airport.
                </p>
                <p class="text-sm text-gray-500 mt-2">Updated: Apr 4, 2025 at 08:00 AM</p>
            </div>

            <!-- Alert 2 -->
            <div class="bg-white border-l-4 border-yellow-400 shadow-sm p-6 rounded-lg">
                <h2 class="text-xl font-semibold text-[#002642] mb-2">Passport Requirements: UAE Destinations</h2>
                <p class="text-gray-700">
                    All travelers flying to Dubai or Abu Dhabi must ensure their passport is valid for at least 6 months from the date of travel.
                    Entry may be denied otherwise.
                </p>
                <p class="text-sm text-gray-500 mt-2">Updated: Apr 2, 2025 at 05:30 PM</p>
            </div>

            <!-- Alert 3 -->
            <div class="bg-white border-l-4 border-blue-500 shadow-sm p-6 rounded-lg">
                <h2 class="text-xl font-semibold text-[#002642] mb-2">System Maintenance: Online Check-In</h2>
                <p class="text-gray-700">
                    Our online check-in service will be undergoing maintenance on April 6 from 1:00 AM to 5:00 AM UTC.
                    During this time, you may check in at the airport counters.
                </p>
                <p class="text-sm text-gray-500 mt-2">Updated: Apr 1, 2025 at 09:15 AM</p>
            </div>
        </section>

        <Footer />
    </div>
</template>
