<template>
    <header class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
            <!-- Left: Logo -->
            <Link href="/" class="text-2xl font-bold text-[#002642] flex-shrink-0">
                FuturaFly
            </Link>


            <!-- Center: Navigation -->
            <nav class="hidden md:flex space-x-6 flex-grow justify-center">
                <Link href="/" class="text-[#002642] hover:text-[#22668D]">Home</Link>
                <Link href="#" class="text-[#002642] hover:text-[#22668D]">Explore</Link>
                <Link href="#" class="text-[#002642] hover:text-[#22668D]">Book</Link>
                <Link href="#" class="text-[#002642] hover:text-[#22668D]">Privilege Club</Link>
            </nav>

            <!-- Right: Auth Buttons -->
            <div class="hidden md:flex items-center space-x-4 flex-shrink-0">
                <Link v-if="canLogin" :href="route('login')" class="text-[#002642]">Login</Link>
                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="bg-[#22668D] text-white px-4 py-2 rounded"
                >
                    Register
                </Link>
            </div>

            <!-- Mobile Menu Button -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-[#002642] ml-4">
                <svg v-if="!mobileMenuOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Mobile Navigation -->
        <nav v-if="mobileMenuOpen" class="md:hidden bg-white border-t border-gray-200 px-4 py-4 space-y-3">
            <Link href="/" class="block text-[#002642] hover:text-[#22668D]">Home</Link>
            <Link href="#" class="block text-[#002642] hover:text-[#22668D]">Explore</Link>
            <Link href="#" class="block text-[#002642] hover:text-[#22668D]">Book</Link>
            <Link href="#" class="block text-[#002642] hover:text-[#22668D]">Privilege Club</Link>

            <div class="border-t border-gray-200 pt-3 space-x-4">
                <Link v-if="canLogin" :href="route('login')" class="text-[#002642]">Login</Link>
                <Link v-if="canRegister" :href="route('register')" class="bg-[#22668D] text-white px-4 py-2 rounded">Register</Link>
            </div>
        </nav>
    </header>
</template>

<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'

defineProps({
    canLogin: Boolean,
    canRegister: Boolean
})

const mobileMenuOpen = ref(false)
</script>
