<script setup>
defineProps({
    bookings: Array,
})

function getAddonColorClass(index) {
    const colors = [
        'bg-gradient-to-r from-green-200 to-green-100 text-green-800',
        'bg-gradient-to-r from-blue-200 to-blue-100 text-blue-800',
        'bg-gradient-to-r from-teal-200 to-teal-100 text-teal-800',
        'bg-gradient-to-r from-sky-200 to-sky-100 text-sky-800',
        'bg-gradient-to-r from-indigo-200 to-indigo-100 text-indigo-800',
    ]
    return colors[index % colors.length]
}

</script>

<template>
    <div class="bg-white dark:bg-gray-900 p-6 rounded-lg shadow">
        <h2 class="text-xl font-semibold mb-4 flex items-center">
            Recent Bookings
        </h2>

        <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
            <h3 class="text-lg font-medium mb-3">Your Recent Bookings</h3>

            <div v-if="bookings.length">
                <div v-for="booking in bookings" :key="booking.id" class="border-b py-3">
                    <div class="font-semibold">Flight: {{ booking.flight.flight_number }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-300">
                        From {{ booking.flight.departure }} to {{ booking.flight.destination }}
                        on {{ new Date(booking.created_at).toLocaleString() }}
                    </div>

                    <!-- Add-On Labels -->
                    <div v-if="booking.addons && booking.addons.length" class="mt-2 flex flex-wrap gap-2">
                        <span
                            v-for="(addon, idx) in booking.addons"
                            :key="idx"
                            class="text-xs font-semibold px-3 py-1 rounded-full mr-2 mb-1 inline-block"
                            :class="getAddonColorClass(idx)"
                        >
                          {{ addon.name }}
                        </span>
                    </div>
                </div>
            </div>

            <div v-else class="text-gray-600 mt-4">
                You don’t have any recent bookings.
            </div>
        </div>
    </div>
</template>
