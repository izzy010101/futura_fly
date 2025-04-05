<script setup>
import { ref } from 'vue'
import { Head } from '@inertiajs/vue3'
import HeaderComponent from '@/Components/HeaderComponent.vue'
import Footer from '@/Components/Footer.vue'

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
})

// FAQ items
const faqs = ref([
    {
        question: 'How can I change or cancel my flight?',
        answer: 'You can manage your booking directly from the "My Trips" section on our website. Changes and cancellations are subject to fare conditions. Cancellation fees may apply.',
        open: false,
    },
    {
        question: 'What baggage allowance is included?',
        answer: 'Economy Class includes 1 carry-on bag (7kg) and 1 checked bag (23kg). Business and First Class passengers have increased allowances based on fare type.',
        open: false,
    },
    {
        question: 'When should I arrive at the airport?',
        answer: 'We recommend arriving at least 3 hours before international departures and 2 hours before domestic departures. Gates close 20 minutes prior to takeoff.',
        open: false,
    },
    {
        question: 'Can I request a special meal on board?',
        answer: 'Yes! You can request vegetarian, vegan, halal, gluten-free, and other meals during the booking process or through Manage Booking at least 24 hours in advance.',
        open: false,
    },
    {
        question: 'Do you offer in-flight Wi-Fi?',
        answer: 'Yes, most FuturaFly aircraft are equipped with Wi-Fi. Packages vary depending on flight duration and aircraft type.',
        open: false,
    },
])

function toggleFAQ(index) {
    faqs.value[index].open = !faqs.value[index].open
}
</script>

<template>
    <Head title="FAQs" />
    <div class="bg-gray-50 min-h-screen flex flex-col">
        <HeaderComponent :can-login="canLogin" :can-register="canRegister" />

        <!-- Hero -->
        <section class="bg-[#002642] text-white py-16 px-6 text-center">
            <h1 class="text-4xl font-bold mb-3">Frequently Asked Questions</h1>
            <p class="text-white/80 max-w-2xl mx-auto text-lg">
                Find quick answers to our most common questions about booking, travel, baggage, and more.
            </p>
        </section>

        <!-- FAQ Accordion -->
        <section class="max-w-4xl mx-auto py-16 px-4 space-y-6">
            <div v-for="(item, index) in faqs" :key="index" class="bg-white rounded-lg shadow-md overflow-hidden">
                <button
                    class="w-full text-left px-6 py-5 focus:outline-none flex justify-between items-center"
                    @click="toggleFAQ(index)"
                >
                    <span class="text-lg font-semibold text-[#002642]">{{ item.question }}</span>
                    <svg
                        :class="['w-5 h-5 transition-transform', item.open ? 'rotate-180' : 'rotate-0']"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div v-if="item.open" class="px-6 pb-6 text-gray-700 leading-relaxed border-t border-gray-100">
                    {{ item.answer }}
                </div>
            </div>
        </section>

        <Footer />
    </div>
</template>
