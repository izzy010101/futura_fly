<script setup>
import WeatherCard from '@/Components/WeatherCard.vue'
import RecentBookings from '@/Components/RecentBookings.vue'
import {Head, usePage} from '@inertiajs/vue3'
import HeaderComponent from '@/Components/HeaderComponent.vue'
import Footer from '@/Components/Footer.vue'
import {PaperAirplaneIcon, SunIcon} from '@heroicons/vue/24/solid'

const page = usePage()
const auth = page.props.auth
const bookings = page.props.bookings || []
</script>

<template>
    <Head title="Dashboard"/>
    <HeaderComponent :auth="auth"/>

    <main class="max-w-7xl mx-auto px-4 py-8 grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-2xl p-6">
            <div class="flex items-center gap-2 mb-4">
                <SunIcon class="w-6 h-6 text-yellow-500"/>
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Weather at Key Airports</h2>
            </div>
            <WeatherCard/>
        </div>

        <!-- Recent Bookings -->
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-2xl p-6">
            <div class="flex items-center gap-2 mb-4">
                <PaperAirplaneIcon class="w-6 h-6 text-[#22668D]"/>
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Recent Bookings</h2>
            </div>
            <RecentBookings :bookings="bookings"/>
        </div>
    </main>

    <Footer/>
</template>


