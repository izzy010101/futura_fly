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
    <Head title="Travel Policies" />
    <div class="bg-gray-50 min-h-screen flex flex-col">
        <HeaderComponent :can-login="canLogin" :can-register="canRegister" />

        <!-- Hero -->
        <section class="bg-[#002642] text-white py-16 text-center px-6">
            <h1 class="text-4xl font-bold mb-3">Our Travel Policies</h1>
            <p class="text-white/80 max-w-2xl mx-auto text-lg">
                Learn about your rights and responsibilities when flying with FuturaFly. Your safety and comfort are our top priority.
            </p>
        </section>

        <!-- Main Content -->
        <section class="max-w-5xl mx-auto py-16 px-6 space-y-12">
            <!-- Booking & Cancellations -->
            <div>
                <h2 class="text-2xl font-semibold text-[#002642] mb-4">Booking & Cancellation Policy</h2>
                <p class="text-gray-700 leading-relaxed">
                    Tickets can be booked online, through travel agents, or at authorized FuturaFly offices. We offer a 24-hour grace period for full refunds on bookings made directly through our site.
                    After that, cancellation and change fees may apply depending on fare type. Refunds will be processed to the original form of payment within 7 business days.
                </p>
            </div>

            <!-- Check-in & Boarding -->
            <div>
                <h2 class="text-2xl font-semibold text-[#002642] mb-4">Check-in & Boarding Requirements</h2>
                <p class="text-gray-700 leading-relaxed">
                    Online check-in opens 48 hours before departure and closes 90 minutes before the flight. All passengers must arrive at the boarding gate at least 45 minutes prior to departure.
                    Failure to do so may result in denied boarding with no refund eligibility.
                </p>
            </div>

            <!-- Baggage Policy -->
            <div>
                <h2 class="text-2xl font-semibold text-[#002642] mb-4">Baggage Allowance</h2>
                <p class="text-gray-700 leading-relaxed">
                    Economy Class passengers are allowed one carry-on (up to 7kg) and one checked bag (up to 23kg). Business and First Class travelers may bring additional luggage as specified on their ticket.
                    Oversized or overweight baggage will incur additional charges and must be declared at check-in.
                </p>
            </div>

            <!-- Travel Documentation -->
            <div>
                <h2 class="text-2xl font-semibold text-[#002642] mb-4">Travel Documentation</h2>
                <p class="text-gray-700 leading-relaxed">
                    All travelers are required to present valid government-issued identification and any applicable visas. FuturaFly is not responsible for denied boarding due to improper documentation.
                    Please check destination-specific entry requirements before traveling.
                </p>
            </div>

            <!-- Delays & Disruptions -->
            <div>
                <h2 class="text-2xl font-semibold text-[#002642] mb-4">Flight Delays, Cancellations & Compensation</h2>
                <p class="text-gray-700 leading-relaxed">
                    If a flight is delayed for more than 3 hours or canceled, passengers may be eligible for rebooking, accommodation, or refund in accordance with international aviation standards.
                    In the event of weather-related delays, compensation is not guaranteed.
                </p>
            </div>

            <!-- Safety & Conduct -->
            <div>
                <h2 class="text-2xl font-semibold text-[#002642] mb-4">Passenger Conduct & Safety</h2>
                <p class="text-gray-700 leading-relaxed">
                    For the safety and comfort of all guests, disruptive or aggressive behavior will not be tolerated. Cabin crew have the right to refuse service or involve airport authorities if necessary.
                    Please follow all crew instructions and safety guidelines while onboard.
                </p>
            </div>

            <!-- Privacy Notice -->
            <div>
                <h2 class="text-2xl font-semibold text-[#002642] mb-4">Data Protection & Privacy</h2>
                <p class="text-gray-700 leading-relaxed">
                    We are committed to protecting your personal information. All data collected is used for travel and communication purposes only and is stored in compliance with GDPR and applicable privacy laws.
                </p>
            </div>
        </section>

        <Footer />
    </div>
</template>
