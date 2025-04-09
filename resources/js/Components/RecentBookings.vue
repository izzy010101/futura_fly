<script setup>
defineProps({
    bookings: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <div class="bg-white dark:bg-gray-900 p-6 rounded-lg shadow mt-6">
        <h2 class="text-xl font-semibold mb-4">Your Recent Bookings</h2>

        <div v-if="bookings.length">
            <div v-for="booking in bookings" :key="booking.id" class="border-b border-gray-200 py-3">
                <p class="font-medium">Flight: {{ booking.flight.flight_number }}</p>
                <p class="text-sm text-gray-600">
                    From {{ booking.flight.departure }} to {{ booking.flight.destination }} on {{ booking.flight.departure_time }}
                </p>
            </div>
        </div>
        <p v-else class="text-gray-500">You have no bookings yet.</p>
    </div>
</template>
