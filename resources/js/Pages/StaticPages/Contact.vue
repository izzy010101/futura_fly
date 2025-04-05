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
    <Head title="Contact Us"/>
    <div class="bg-gray-50 min-h-screen flex flex-col">
        <HeaderComponent :can-login="canLogin" :can-register="canRegister" />


        <!-- Hero Section -->
        <section class="relative h-[50vh] bg-cover bg-center flex items-center justify-center text-white"
                 style="background-image: url('/images/contact-hero.jpg')">
            <div class="absolute inset-0 bg-black/50"></div>
            <div class="relative z-10 text-center px-4 max-w-2xl">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Contact FuturaFly</h1>
                <p class="text-lg text-white/80">Need help or have questions? Our team is here for you.</p>
            </div>
        </section>

        <!-- Info Section -->
        <section class="flex-1 max-w-5xl mx-auto px-4 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <!-- Left: Info -->
                <div>
                    <h2 class="text-2xl font-bold text-[#002642] mb-4">We're here to help</h2>
                    <p class="text-gray-700 mb-4">
                        Whether you're booking a flight, updating a reservation, or just looking for recommendations —
                        our support team is happy to assist you.
                    </p>
                    <p class="text-gray-700 mb-4">
                        We typically respond to messages within 24 hours. For urgent travel inquiries, please call our
                        24/7 hotline.
                    </p>
                    <p class="text-gray-700 mb-4">
                        Our headquarters are located in New York City, but we serve passengers worldwide.
                    </p>
                </div>

                <!-- Right: Contact Details -->
                <div class="bg-white p-6 rounded-lg shadow-md space-y-6">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-500 uppercase mb-2">Customer Service</h3>
                        <p class="text-gray-800 text-lg">+1 (800) 555-0101</p>
                        <p class="text-gray-600 text-sm">Available 24/7</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-semibold text-gray-500 uppercase mb-2">Email Us</h3>
                        <p class="text-gray-800">support@futurafly.com</p>
                        <p class="text-gray-600 text-sm">Expect a response within 24 hours.</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-semibold text-gray-500 uppercase mb-2">Head Office</h3>
                        <p class="text-gray-800">123 Futura Lane<br />New York, NY 10001<br />United States</p>
                    </div>
                </div>
            </div>
        </section>

        <Footer />
    </div>
</template>
