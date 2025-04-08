<script setup>
import { ref } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
import Dropdown from '@/Components/Dropdown.vue'
import DropdownLink from '@/Components/DropdownLink.vue'

defineProps({
    auth: Object,
    canLogin: Boolean,
    canRegister: Boolean
})

const mobileMenuOpen = ref(false)
const user = usePage().props.auth.user
</script>

<template>
    <header class="sticky top-0 z-50 bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
            <!-- Left: Logo -->
            <Link href="/" class="text-2xl font-bold text-[#002642] flex-shrink-0">
                FuturaFly
            </Link>

            <!-- Center: Navigation -->
            <nav class="hidden md:flex space-x-6 flex-grow justify-center">
                <Link href="/" class="text-[#002642] hover:text-[#22668D]">Home</Link>
                <Link href="/explore" class="text-[#002642] hover:text-[#22668D]">Explore</Link>
                <Link href="/destinations" class="text-[#002642] hover:text-[#22668D]">Destinations</Link>
                <Link href="#" class="text-[#002642] hover:text-[#22668D]">Privilege Club</Link>
            </nav>

            <!-- Right: Auth Buttons or User Dropdown -->
            <div class="hidden md:flex items-center space-x-4 flex-shrink-0">
                <template v-if="!user">
                    <Link v-if="canLogin" :href="route('login')" class="text-[#002642]">Login</Link>
                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="bg-[#22668D] text-white px-4 py-2 rounded"
                    >
                        Register
                    </Link>
                </template>
                <template v-else>
                    <Dropdown align="right" width="48">
                        <template #trigger>
                            <span class="inline-flex rounded-md">
                                <button
                                    type="button"
                                    class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-[#002642] transition duration-150 ease-in-out hover:text-[#22668D] focus:outline-none"
                                >
                                    {{ user.name }}
                                    <svg class="-me-0.5 ms-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                </button>
                            </span>
                        </template>

                        <template #content>
                            <DropdownLink :href="route('profile.edit')">
                                Profile
                            </DropdownLink>
                            <DropdownLink :href="route('logout')" method="post" as="button">
                                Log Out
                            </DropdownLink>
                        </template>
                    </Dropdown>
                </template>
            </div>

            <!-- Mobile Menu Button -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-[#002642] ml-4">
                <svg v-if="!mobileMenuOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Mobile Navigation -->
        <nav v-if="mobileMenuOpen" class="md:hidden bg-white border-t border-gray-200 px-4 py-4 space-y-3">
            <Link href="/" class="block text-[#002642] hover:text-[#22668D]">Home</Link>
            <Link href="/explore" class="block text-[#002642] hover:text-[#22668D]">Explore</Link>
            <Link href="/destinations" class="block text-[#002642] hover:text-[#22668D]">Destinations</Link>
            <Link href="#" class="block text-[#002642] hover:text-[#22668D]">Privilege Club</Link>

            <template v-if="!user">
                <div class="border-t border-gray-200 pt-3 space-x-4">
                    <Link v-if="canLogin" :href="route('login')" class="text-[#002642]">Login</Link>
                    <Link v-if="canRegister" :href="route('register')" class="bg-[#22668D] text-white px-4 py-2 rounded">Register</Link>
                </div>
            </template>
            <template v-else>
                <div class="border-t border-gray-200 pt-4 space-y-2">
                    <Link :href="route('profile.edit')" class="block text-[#002642] hover:text-[#22668D]">Profile</Link>
                    <Link :href="route('logout')" method="post" as="button" class="block text-[#002642] hover:text-[#22668D]">Log Out</Link>
                </div>
            </template>
        </nav>
    </header>
</template>
