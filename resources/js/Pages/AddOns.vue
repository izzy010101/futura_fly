<script setup>
import HeaderComponent from '@/Components/HeaderComponent.vue'
import { Head, Link } from '@inertiajs/vue3'
import Footer from '@/Components/Footer.vue'

defineProps({
    auth: Object,
    canLogin: Boolean,
    canRegister: Boolean,
})
</script>

<template>
    <Head title="AddOns" />
    <div class="bg-gray-50 min-h-screen">
        <HeaderComponent :auth="auth" :can-login="canLogin" :can-register="canRegister" />

        <!-- Hero Section with picture for responsive image -->
        <section class="relative h-[60vh] flex items-center justify-center text-white">
            <picture>
                <source srcset="/images/first-class-1600.jpg" media="(min-width: 1024px)">
                <source srcset="/images/first-class-800.jpg" media="(min-width: 640px)">
                <img
                    src="/images/first-class-400.jpg"
                    alt="Add-ons"
                    class="absolute inset-0 w-full h-full object-cover"
                />
            </picture>
            <div class="absolute inset-0 bg-black/40 flex items-center justify-center text-center px-4">
                <div class="text-white max-w-3xl relative z-10">
                    <h1 class="text-4xl md:text-5xl font-bold mb-4">Enhance Your Journey</h1>
                    <p class="text-lg md:text-xl text-gray-200">
                        Upgrade your travel with our range of exclusive add-ons, from seats to meals and more.
                    </p>
                </div>
            </div>
        </section>

        <!-- Add-On Cards -->
        <section class="max-w-7xl mx-auto px-4 py-16">
            <h2 class="text-2xl font-bold text-[#002642] mb-8 text-center">Available Add-Ons</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-lg transition">
                    <h3 class="text-xl font-bold text-[#002642] mb-2">Extra Baggage</h3>
                    <p class="text-gray-600 mb-4">Add up to 20kg of additional luggage allowance to your booking.</p>
                    <p class="text-lg font-semibold text-[#22668D]">$30 per 10kg</p>
                </div>
                <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-lg transition">
                    <h3 class="text-xl font-bold text-[#002642] mb-2">Seat Selection</h3>
                    <p class="text-gray-600 mb-4">Choose your preferred seat — window, aisle, or extra legroom.</p>
                    <p class="text-lg font-semibold text-[#22668D]">From $12</p>
                </div>
                <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-lg transition">
                    <h3 class="text-xl font-bold text-[#002642] mb-2">Premium Meals</h3>
                    <p class="text-gray-600 mb-4">Enjoy gourmet in-flight meals with vegetarian, halal, or gluten-free options.</p>
                    <p class="text-lg font-semibold text-[#22668D]">$18 per meal</p>
                </div>
                <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-lg transition">
                    <h3 class="text-xl font-bold text-[#002642] mb-2">Airport Lounge Access</h3>
                    <p class="text-gray-600 mb-4">Relax pre-flight with access to premium lounges around the world.</p>
                    <p class="text-lg font-semibold text-[#22668D]">$25 per pass</p>
                </div>
                <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-lg transition">
                    <h3 class="text-xl font-bold text-[#002642] mb-2">Fast Track Security</h3>
                    <p class="text-gray-600 mb-4">Skip the queues with priority security clearance at select airports.</p>
                    <p class="text-lg font-semibold text-[#22668D]">$15 per person</p>
                </div>
                <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-lg transition">
                    <h3 class="text-xl font-bold text-[#002642] mb-2">Travel Insurance</h3>
                    <p class="text-gray-600 mb-4">Protect your trip with coverage for cancellations, delays, and baggage loss.</p>
                    <p class="text-lg font-semibold text-[#22668D]">From $22</p>
                </div>
            </div>
        </section>

        <Footer />
    </div>
</template>
