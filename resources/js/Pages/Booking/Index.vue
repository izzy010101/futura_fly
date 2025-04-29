<script setup>
import { ref } from 'vue'
import { Head, useForm, usePage } from '@inertiajs/vue3'
import HeaderComponent from '@/Components/HeaderComponent.vue'
import Footer from '@/Components/Footer.vue'

const props = defineProps({
    flight: Object,
    addons: Array, // coming from controller with real addon IDs
})

const page = usePage()
const auth = page.props.auth

const addOns = ref(props.addons.map(addon => ({
    ...addon,
    selected: false
})))

const form = useForm({
    flight_id: props.flight.id,
    addons: [],
})

const submitBooking = () => {
    form.addons = addOns.value.filter(a => a.selected).map(a => a.id)
    form.post(route('booking.store'))
}
</script>

<template>
    <Head title="Booking" />
    <HeaderComponent :auth="auth" />

    <div class="max-w-4xl mx-auto p-6 mt-10 bg-white shadow-md rounded-lg mb-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Book Your Flight</h1>

        <div class="space-y-4 text-gray-700">
            <div><strong>Flight Number:</strong> {{ flight.flight_number }}</div>
            <div><strong>From:</strong> {{ flight.departure }}</div>
            <div><strong>To:</strong> {{ flight.destination }}</div>
            <div><strong>Departure:</strong> {{ flight.departure_time }}</div>
            <div><strong>Arrival:</strong> {{ flight.arrival_time }}</div>
            <div><strong>Price:</strong> ${{ flight.price }}</div>
            <div><strong>Seats Available:</strong> {{ flight.seats_available }}</div>
        </div>

        <section class="mt-12">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-4">Available Add-Ons</h2>

            <div class="grid md:grid-cols-3 gap-6">
                <div
                    v-for="(addon, index) in addOns"
                    :key="addon.id"
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

        <div class="mt-8 flex justify-end">
            <button
                @click="submitBooking"
                :disabled="form.processing"
                class="bg-[#22668D] text-white px-6 py-2 rounded hover:bg-[#1d4f6d] transition disabled:opacity-50"
            >
                {{ form.processing ? 'Booking...' : 'Book Now' }}
            </button>
        </div>
    </div>

    <Footer />
</template>
