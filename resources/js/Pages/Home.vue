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

        <!-- Search Form -->
        <section class="bg-white shadow-lg -mt-24 z-20 relative rounded-lg max-w-5xl mx-auto p-6 md:p-8">
            <form @submit.prevent="searchFlights" class="flex flex-wrap md:flex-nowrap gap-4 items-start">
                <div class="w-full md:w-1/3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">From</label>
                    <div class="relative">
                        <MapPinIcon class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" />
                        <input
                            v-model="search.departure"
                            @input="() => validateField('departure')"
                            @blur="() => validateField('departure')"
                            type="text"
                            placeholder="Departure City"
                            class="pl-10 pr-3 py-2 border rounded-md w-full focus:outline-none transition-all text-gray-800 placeholder-gray-400"
                            :class="wasSubmitted && validationErrors.departure ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-[#22668D] focus:ring-[#22668D]'"
                        />
                    </div>
                    <p class="text-sm text-red-600 mt-1 min-h-[1.25rem]">{{ wasSubmitted ? validationErrors.departure : '' }}</p>
                </div>

                <div class="w-full md:w-1/3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">To</label>
                    <div class="relative">
                        <MapPinIcon class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" />
                        <input
                            v-model="search.destination"
                            @input="() => validateField('destination')"
                            @blur="() => validateField('destination')"
                            type="text"
                            placeholder="Destination City"
                            class="pl-10 pr-3 py-2 border rounded-md w-full focus:outline-none transition-all text-gray-800 placeholder-gray-400"
                            :class="wasSubmitted && validationErrors.destination ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-[#22668D] focus:ring-[#22668D]'"
                        />
                    </div>
                    <p class="text-sm text-red-600 mt-1 min-h-[1.25rem]">{{ wasSubmitted ? validationErrors.destination : '' }}</p>
                </div>

                <div class="flex flex-col gap-2 w-full md:w-auto md:mt-6">
                    <button
                        type="submit"
                        class="bg-[#22668D] text-white font-semibold px-5 py-2 rounded-md hover:bg-[#419197] transition"
                    >
                        Search Flights
                    </button>
                    <button
                        type="button"
                        class="bg-gray-100 text-[#002642] px-5 py-2 rounded-md hover:bg-gray-200"
                        @click="clearSearch"
                    >
                        Clear
                    </button>
                </div>
            </form>
        </section>


        <!-- Matching Flights -->
        <section v-if="search.departure || search.destination" class="max-w-7xl mx-auto p-6 mt-8">
            <h2 class="text-2xl font-bold mb-6 text-[#002642]">Matching Flights</h2>

            <div v-if="flights.length" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <FlightCard v-for="flight in flights" :key="flight.id" :flight="flight" :can-book="canBook" />
            </div>

            <div v-else class="text-gray-500">No matching flights found.</div>
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
