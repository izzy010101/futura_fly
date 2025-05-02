<script setup>
import { router } from '@inertiajs/vue3'
import Swal from 'sweetalert2'

const props = defineProps({
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

const cancelBooking = (bookingId) => {
    Swal.fire({
        title: 'Are you sure?',
        text: 'Do you really want to cancel this flight?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e3342f',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, cancel it',
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(`/booking/${bookingId}`, {
                preserveScroll: true,
                onSuccess: () => {
                    Swal.fire('Cancelled', 'Your booking has been cancelled.', 'success').then(() => {
                        router.visit(route('dashboard'), {
                            preserveScroll: true,
                            preserveState: false,
                        })
                    })
                },
                onError: () => {
                    Swal.fire('Error', 'There was a problem cancelling your booking.', 'error')
                },
            })
        }
    })
}

function checkoutBooking(bookingId) {
    router.get(route('booking.checkout', bookingId))
}
</script>

<template>
    <div>
        <h2 class="text-2xl font-bold mb-4 flex items-center text-[#002642] dark:text-white">
            Recent Bookings
        </h2>

        <div class="space-y-4">
            <div v-if="bookings.length">
                <div
                    v-for="booking in bookings"
                    :key="booking.id"
                    class="bg-white dark:bg-gray-800 p-5 rounded-xl shadow-md border border-gray-100 dark:border-gray-700 mb-2"
                >
                    <div class="text-lg font-semibold text-[#002642] dark:text-white">
                        Flight: {{ booking.flight.flight_number }}
                    </div>
                    <div class="text-sm text-gray-600 dark:text-gray-300">
                        From {{ booking.flight.departure }} to {{ booking.flight.destination }}<br />
                        Booked on: {{ new Date(booking.created_at).toLocaleString() }}
                    </div>

                    <!-- Flight price with discount display -->
                    <p class="text-gray-800 dark:text-gray-100 font-semibold">
                        Flight Price:
                        <span v-if="booking.is_discounted" class="line-through text-red-500">
                            ${{ (+booking.flight.price).toFixed(2) }}
                        </span>
                        <span class="ml-2">
                        ${{ (+booking.price).toFixed(2) }}
                        </span>
                        <span v-if="booking.is_discounted" class="ml-2 bg-green-200 text-green-800 px-2 py-0.5 rounded text-xs">
                        Spring Offer
                        </span>
                    </p>


                    <!-- Addons Labels with Price -->
                    <div
                        v-if="booking.addons && booking.addons.length"
                        class="mt-3 flex flex-wrap gap-2"
                    >
                        <div
                            v-for="(addon, idx) in booking.addons"
                            :key="idx"
                            class="flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold"
                            :class="getAddonColorClass(idx)"
                        >
                            <span>{{ addon.name }}</span>
                            <span class="text-gray-700 dark:text-gray-200 text-[11px] font-normal">
                                (${{ (+addon.price).toFixed(2) }})
                            </span>
                        </div>
                    </div>

                    <!-- Total price -->
                    <div class="mt-2">
                        <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Total with Add-ons: $
                            {{
                                (
                                    +booking.price +
                                    booking.addons.reduce((sum, addon) => sum + +addon.price, 0)
                                ).toFixed(2)
                            }}
                        </p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-4 flex gap-2">
                        <button
                            class="px-4 py-2 text-sm bg-red-100 text-red-700 rounded hover:bg-red-200"
                            @click="cancelBooking(booking.id)"
                        >
                            Cancel
                        </button>
                        <button
                            class="px-4 py-2 text-sm bg-blue-600 text-white rounded hover:bg-blue-700"
                            @click="checkoutBooking(booking.id)"
                        >
                            Checkout
                        </button>
                    </div>
                </div>
            </div>

            <div v-else class="text-gray-600 dark:text-gray-300">
                You don’t have any recent bookings.
            </div>
        </div>
    </div>
</template>
