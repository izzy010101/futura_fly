<script setup>
import { ref } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
import Dropdown from '@/Components/Dropdown.vue'
import DropdownLink from '@/Components/DropdownLink.vue'

const props = defineProps({
    auth: Object,
    canLogin: Boolean,
    canRegister: Boolean,
})

const mobileMenuOpen = ref(false)
const user = props.auth?.user
</script>

<template>
    <header class="sticky top-0 z-50 bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
            <!-- Logo -->
            <Link href="/" class="text-2xl font-bold text-[#002642] flex-shrink-0">FuturaFly</Link>

            <!-- Navigation links (center) -->
            <nav class="hidden md:flex space-x-6 flex-grow justify-center">
                <Link href="/" class="text-[#002642] hover:text-[#22668D]">Home</Link>
                <Link href="/explore" class="text-[#002642] hover:text-[#22668D]">Explore</Link>
                <Link href="/destinations" class="text-[#002642] hover:text-[#22668D]">Destinations</Link>
                <Link href="#" class="text-[#002642] hover:text-[#22668D]">Privilege Club</Link>
                <Link v-if="user" href="/dashboard" class="text-[#002642] hover:text-[#22668D]">Dashboard</Link>
            </nav>

            <!-- Auth buttons -->
            <div class="hidden md:flex items-center space-x-4">
                <!-- If NOT logged in -->
                <template v-if="!user">
                    <Link v-if="canLogin" :href="route('login')" class="text-[#002642] hover:text-[#22668D]">Login</Link>
                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="bg-[#22668D] text-white px-4 py-2 rounded hover:bg-[#1d4f6d]"
                    >
                        Register
                    </Link>
                </template>

                <!-- If logged in -->
                <template v-else>
                    <Dropdown align="right" width="48">
                        <template #trigger>
                            <button class="flex items-center text-[#002642] hover:text-[#22668D] font-medium">
                                {{ user.name }}
                                <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </template>

                        <template #content>
                            <DropdownLink :href="route('profile.edit')">Profile</DropdownLink>
                            <DropdownLink :href="route('logout')" method="post" as="button">Log Out</DropdownLink>
                        </template>
                    </Dropdown>
                </template>
            </div>

            <!-- Mobile menu toggle -->
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
            <Link href="/explore" class="block text-[#002642] hover:text-[#22668D]">Explore</Link>
            <Link href="/destinations" class="block text-[#002642] hover:text-[#22668D]">Destinations</Link>
            <Link href="#" class="block text-[#002642] hover:text-[#22668D]">Privilege Club</Link>
            <Link v-if="user" href="/dashboard" class="block text-[#002642] hover:text-[#22668D]">Dashboard</Link>

            <div class="border-t border-gray-200 pt-3 space-y-2">
                <!-- If NOT logged in -->
                <template v-if="!user">
                    <Link v-if="canLogin" :href="route('login')" class="block text-[#002642] hover:text-[#22668D]">Login</Link>
                    <Link v-if="canRegister" :href="route('register')" class="block text-[#002642] hover:text-[#22668D]">Register</Link>
                </template>

                <!-- If logged in -->
                <template v-else>
                    <Link :href="route('profile.edit')" class="block text-[#002642] hover:text-[#22668D]">Profile</Link>
                    <Link :href="route('logout')" method="post" as="button" class="block text-[#002642] hover:text-[#22668D]">Log Out</Link>
                </template>
            </div>
        </nav>
    </header>
</template>
