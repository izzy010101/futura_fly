<!--home.vue-->
<script setup>
import { Head, router } from '@inertiajs/vue3'
import { reactive, ref } from 'vue'
import HeaderComponent from '@/Components/HeaderComponent.vue'
import Footer from '@/Components/Footer.vue'
import { MapPinIcon } from '@heroicons/vue/24/solid'
import { Link } from '@inertiajs/vue3'
import FlightCard from '@/Components/FlightCard.vue'

const props = defineProps({
    auth: Object,
    canLogin: Boolean,
    canRegister: Boolean,
    flights: { type: Array, default: () => [] },
    filters: { type: Object, default: () => ({ departure: '', destination: '' }) },
    canBook: Boolean,
})

const search = reactive({
    departure: props.filters?.departure || '',
    destination: props.filters?.destination || '',
})

const validationErrors = reactive({ departure: '', destination: '' })
const wasSubmitted = ref(false)

function validateField(field) {
    const value = (search[field] || '').trim()
    validationErrors[field] = value ? '' : 'City is required.'
}

function validateAll() {
    validateField('departure')
    validateField('destination')
    return !validationErrors.departure && !validationErrors.destination
}

function searchFlights() {
    wasSubmitted.value = true
    if (!validateAll()) return

    router.get('/', {
        departure: search.departure.trim(),
        destination: search.destination.trim(),
    }, {
        preserveScroll: true,
        preserveState: true,
    })
}

function clearSearch() {
    const hadSearch = search.departure || search.destination;

    search.departure = ''
    search.destination = ''
    validationErrors.departure = ''
    validationErrors.destination = ''
    wasSubmitted.value = false

    if (hadSearch) {
        router.get('/', {}, {
            preserveScroll: true,
            preserveState: true,
            replace: true, // Optional: updates URL without pushing new history
        })
    }
}
</script>

<template>
    <Head title="Home" />
    <div class="min-h-screen flex flex-col bg-gray-50">
        <HeaderComponent :auth="auth" :can-login="canLogin" :can-register="canRegister" />

        <!-- Hero with responsive image -->
        <section class="relative h-[85vh] flex items-center justify-center text-white overflow-hidden">
            <picture class="absolute inset-0 w-full h-full">
                <source srcset="/images/airplane_header-1600.jpg" media="(min-width: 1024px)">
                <source srcset="/images/airplane_header-800.jpg" media="(min-width: 640px)">
                <img
                    src="/images/airplane_header-400.jpg"
                    alt="Airplane header"
                    class="w-full h-full object-cover"
                />
            </picture>

            <div class="bg-black/60 absolute inset-0"></div>
            <div class="relative z-10 text-center max-w-2xl px-6">
                <h1 class="text-4xl md:text-5xl font-bold leading-tight">Explore the Skies with FuturaFly</h1>
                <p class="text-lg mt-4 text-white/80">Book your next journey with comfort, safety, and elegance.</p>
            </div>
        </section>

        <!-- Cards Section -->
        <section class="bg-[#f4f6fb] py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800">Start planning your next trip</h2>
                    <p class="mt-2 text-gray-600 text-lg">Thinking of travelling somewhere soon? Here are some options to help you get started.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Card 1 -->
                    <Link href="/offers" class="block">
                        <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition group">
                            <img
                                src="/images/offer1-800.jpg"
                                srcset="/images/offer1-400.jpg 400w, /images/offer1-800.jpg 800w, /images/offer1-1600.jpg 1600w"
                                sizes="(max-width: 640px) 100vw, (max-width: 1024px) 50vw, 25vw"
                                alt="Offers"
                                loading="lazy"
                                class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-105"
                            />

                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-800">Explore our offers</h3>
                                <p class="mt-2 font-medium text-[#002642] flex items-center justify-between">
                                    Find out more
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </p>
                            </div>
                        </div>
                    </Link>

                    <!-- Card 2 -->
                    <Link href="/stopover" class="block">
                        <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition group">
                            <img
                                src="/images/stopover-800.jpg"
                                srcset="/images/stopover-400.jpg 400w, /images/stopover-800.jpg 800w, /images/stopover-1600.jpg 1600w"
                                sizes="(max-width: 640px) 100vw, (max-width: 1024px) 50vw, 25vw"
                                alt="Stopover"
                                loading="lazy"
                                class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-105"
                            />

                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-800">Stopover in Qatar from $14 pp</h3>
                                <p class="mt-2 font-medium text-[#002642] flex items-center justify-between">
                                    Find out more
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </p>
                            </div>
                        </div>
                    </Link>

                    <!-- Card 3 -->
                    <Link href="/springoffers" class="block">
                        <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition group">
                            <img
                                src="/images/spring-offer-800.jpg"
                                srcset="/images/spring-offer-400.jpg 400w, /images/spring-offer-800.jpg 800w, /images/spring-offer-1600.jpg 1600w"
                                sizes="(max-width: 640px) 100vw, (max-width: 1024px) 50vw, 25vw"
                                alt="Spring Offer"
                                loading="lazy"
                                class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-105"
                            />

                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-800">Up to 12% off Spring flights</h3>
                                <p class="mt-2 font-medium text-[#002642] flex items-center justify-between">
                                    Explore offer
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </p>
                            </div>
                        </div>
                    </Link>

                    <!-- Card 4 -->
                    <Link href="/addons" class="block">
                        <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition group">
                            <img
                                src="/images/first-class-800.jpg"
                                srcset="/images/first-class-400.jpg 400w, /images/first-class-800.jpg 800w, /images/first-class-1600.jpg 1600w"
                                sizes="(max-width: 640px) 100vw, (max-width: 1024px) 50vw, 25vw"
                                alt="Experience"
                                loading="lazy"
                                class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-105"
                            />

                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-800">Elevate your experience</h3>
                                <p class="mt-2 font-medium text-[#002642] flex items-center justify-between">
                                    Purchase add-ons
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </p>
                            </div>
                        </div>
                    </Link>
                </div>
            </div>
        </section>

        <!-- Popular Destinations Section -->
        <section class="bg-white py-16 px-4">
            <div class="max-w-7xl mx-auto">
                <h2 class="text-3xl font-bold text-[#002642] text-center mb-10">Popular Destinations</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- New York Card -->
                    <Link href="/destinations/new-york" class="group block bg-gray-50 rounded-2xl overflow-hidden shadow hover:shadow-lg transition">
                        <img
                            src="/images/newyork-800.jpg"
                            srcset="/images/newyork-400.jpg 400w, /images/newyork-800.jpg 800w, /images/newyork-1600.jpg 1600w"
                            sizes="(max-width: 640px) 100vw, (max-width: 1024px) 50vw, 50vw"
                            alt="New York"
                            loading="lazy"
                            class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300"
                        />

                        <div class="p-6">
                            <h3 class="text-2xl font-semibold text-[#002642] mb-2">New York</h3>
                            <p class="text-gray-600">Experience the city that never sleeps. From Times Square to Central Park, New York has it all.</p>
                        </div>
                    </Link>

                    <!-- Berlin Card -->
                    <Link href="/destinations/berlin" class="group block bg-gray-50 rounded-2xl overflow-hidden shadow hover:shadow-lg transition">
                        <img
                            src="/images/berlin-800.jpg"
                            srcset="/images/berlin-400.jpg 400w, /images/berlin-800.jpg 800w, /images/berlin-1600.jpg 1600w"
                            sizes="(max-width: 640px) 100vw, (max-width: 1024px) 50vw, 50vw"
                            alt="Berlin"
                            loading="lazy"
                            class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300"
                        />
                        <div class="p-6">
                            <h3 class="text-2xl font-semibold text-[#002642] mb-2">Berlin</h3>
                            <p class="text-gray-600">A perfect blend of rich history and vibrant culture, Berlin is calling. Discover its charm today.</p>
                        </div>
                    </Link>
                </div>
            </div>
        </section>

        <Footer />
    </div>
</template>
