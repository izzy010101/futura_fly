<script setup>
import {Head, usePage} from '@inertiajs/vue3'
import Header from '@/Components/HeaderComponent.vue'
import Footer from '@/Components/Footer.vue'
import HeaderComponent from "@/Components/HeaderComponent.vue";

defineProps({
    flight: Object,
})

const page = usePage()
const auth = page.props.auth

const addOns = [
    { name: 'Extra Baggage', description: 'Add up to 20kg of additional luggage.', price: 30, unit: 'per 10kg', selected: false },
    { name: 'Seat Selection', description: 'Choose your preferred seat — window, aisle, or extra legroom.', price: 12, unit: '', selected: false },
    { name: 'Premium Meals', description: 'Enjoy gourmet meals with vegetarian or halal options.', price: 18, unit: 'per meal', selected: false },
    { name: 'Airport Lounge Access', description: 'Access premium lounges around the world.', price: 25, unit: 'per pass', selected: false },
    { name: 'Fast Track Security', description: 'Priority clearance at select airports.', price: 15, unit: 'per person', selected: false },
    { name: 'Travel Insurance', description: 'Coverage for cancellations and baggage loss.', price: 22, unit: 'starting from', selected: false }
]

</script>

<template>
    <Head title="Booking"/>
    <HeaderComponent :auth="auth" />

    <div class="max-w-4xl mx-auto p-6 mt-10 bg-white shadow-md rounded-lg">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">
            Book Your Flight
        </h1>

        <div class="space-y-4 text-gray-700">
            <div><strong>Flight Number:</strong> {{ flight.flight_number }}</div>
            <div><strong>From:</strong> {{ flight.departure }}</div>
            <div><strong>To:</strong> {{ flight.destination }}</div>
            <div><strong>Departure:</strong> {{ flight.departure_time }}</div>
            <div><strong>Arrival:</strong> {{ flight.arrival_time }}</div>
            <div><strong>Price:</strong> ${{ flight.price }}</div>
            <div><strong>Seats Available:</strong> {{ flight.seats_available }}</div>
        </div>

        <!-- Optional: Booking form can go here -->
        <section class="mt-12">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-4">Available Add-Ons</h2>

            <div class="grid md:grid-cols-3 gap-6">
                <div
                    v-for="(addon, index) in addOns"
                    :key="index"
                    @click="addon.selected = !addon.selected"
                    :class="[
          'p-4 rounded-lg shadow transition cursor-pointer',
          addon.selected
            ? 'bg-[#22668D] text-white'
            : 'bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100'
        ]"
                >
                    <h3 class="text-lg font-semibold mb-1">{{ addon.name }}</h3>
                    <p class="text-sm mb-2">{{ addon.description }}</p>
                    <p class="font-medium">
                        ${{ addon.price }} <span class="text-sm">{{ addon.unit }}</span>
                    </p>
                </div>
            </div>
        </section>

    </div>

    <Footer/>
</template>
