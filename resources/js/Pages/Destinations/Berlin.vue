<script setup>
import HeaderComponent from '@/Components/HeaderComponent.vue'
import Footer from '@/Components/Footer.vue'
import {Head, Link} from '@inertiajs/vue3'

defineProps({
    auth: Object,
    canLogin: Boolean,
    canRegister: Boolean
})
</script>

<template>
    <Head title="Berlin - Destination" />
    <div class="bg-gray-50 min-h-screen">
        <HeaderComponent :auth="auth" :can-login="canLogin" :can-register="canRegister" />

        <!-- Hero -->
        <section class="relative">
            <img src="/images/berlin.jpg" alt="Berlin" class="w-full h-[65vh] object-cover" />
            <div class="absolute inset-0 bg-black/40 flex items-center justify-center text-center px-4">
                <div class="text-white max-w-3xl">
                    <h1 class="text-4xl md:text-5xl font-bold mb-4">Berlin</h1>
                    <p class="text-lg md:text-xl text-gray-200">A city of culture, contrast, and creativity. Explore Berlin’s vibrant history and modern charm.</p>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <section class="max-w-7xl mx-auto px-4 py-16 grid md:grid-cols-2 gap-12 items-center">
            <!-- Text -->
            <div>
                <h2 class="text-3xl font-bold text-[#002642] mb-4">Where History Meets Innovation</h2>
                <p class="text-gray-700 text-lg leading-relaxed mb-4">
                    Berlin is a hub for creatives and history lovers alike. Walk along the Berlin Wall, relax at Museum Island, and party in the city that never stops.
                </p>
                <ul class="list-disc list-inside text-gray-700 space-y-2 text-base">
                    <li>Tour the Berlin Wall & Checkpoint Charlie</li>
                    <li>Visit Brandenburg Gate and Reichstag</li>
                    <li>Enjoy museums, art galleries, and street art</li>
                    <li>Sample authentic currywurst and beer</li>
                </ul>
                <Link href="/explore" class="mt-6 inline-block bg-[#22668D] text-white px-6 py-3 rounded-md font-semibold hover:bg-[#419197] transition">Explore More</Link>
            </div>

            <!-- Image -->
            <div>
                <img
                    src="/images/berlin-city.jpg"
                    loading="lazy"
                    alt="Berlin Street"
                    class="rounded-xl shadow-lg w-full object-cover aspect-[4/3]"
                />
            </div>
        </section>

        <Footer />
    </div>
</template>
