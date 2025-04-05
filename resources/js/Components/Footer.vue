<script setup>
import { ref } from 'vue'
import axios from 'axios'
import { Link } from '@inertiajs/vue3'

const email = ref('')
const successMessage = ref('')
const errorMessage = ref('')
const localError = ref('')

// Live validate on input
const validateEmail = () => {
    localError.value = ''
    if (!email.value.trim()) {
        localError.value = 'Email is required.'
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
        localError.value = 'Please enter a valid email address.'
    }
}

const submit = async () => {
    successMessage.value = ''
    errorMessage.value = ''
    validateEmail()
    if (localError.value) return

    try {
        const response = await axios.post('/subscribe', { email: email.value })
        successMessage.value = response.data.message
        email.value = ''
    } catch (error) {
        if (error.response?.status === 422) {
            errorMessage.value = error.response.data.errors?.email?.[0] || 'Invalid email.'
        } else {
            errorMessage.value = 'Something went wrong. Please try again later.'
        }
    }
}
</script>

<template>
    <footer class="bg-[#002642] text-white pt-12 pb-8 px-6">
        <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-10">
            <!-- Brand -->
            <div class="md:col-span-1">
                <h2 class="text-2xl font-bold mb-4">FuturaFly</h2>
                <p class="text-sm text-gray-300">
                    Fly into the future with style, safety, and comfort. Discover your next destination with FuturaFly.
                </p>
            </div>

            <!-- Explore -->
            <div>
                <h3 class="text-sm font-semibold uppercase mb-4">Explore</h3>
                <ul class="space-y-2 text-sm text-gray-300">
                    <li><Link href="/" class="hover:text-white">Home</Link></li>
                    <li><Link href="/offers" class="hover:text-white">Offers</Link></li>
                    <li><Link href="/stopover" class="hover:text-white">Stopover</Link></li>
                    <li><Link href="/addons" class="hover:text-white">Add-Ons</Link></li>
                </ul>
            </div>

            <!-- Support -->
            <div>
                <h3 class="text-sm font-semibold uppercase mb-4">Support</h3>
                <ul class="space-y-2 text-sm text-gray-300">
                    <li><Link href="/faq" class="hover:text-white">FAQs</Link></li>
                    <li><Link href="/contact" class="hover:text-white">Contact Us</Link></li>
                    <li><Link href="/alerts" class="hover:text-white">Travel Alerts</Link></li>
                    <li><Link href="/policies" class="hover:text-white">Policies</Link></li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div class="md:col-span-2">
                <h3 class="text-sm font-semibold uppercase mb-4">Subscribe to our Newsletter</h3>
                <form @submit.prevent="submit" class="flex flex-col sm:flex-row gap-3 mb-3">
                    <input
                        v-model="email"
                        @input="validateEmail"
                        type="text"
                        placeholder="Your email"
                        class="px-4 py-2 rounded-md text-gray-800 w-full focus:outline-none"
                    />
                    <button
                        type="submit"
                        class="bg-[#22668D] hover:bg-[#419197] text-white px-4 py-2 rounded-md font-semibold"
                    >
                        Subscribe
                    </button>
                </form>
                <p v-if="localError" class="text-red-400 text-sm">{{ localError }}</p>
                <p v-if="errorMessage" class="text-red-400 text-sm">{{ errorMessage }}</p>
                <p v-if="successMessage" class="text-green-400 text-sm">{{ successMessage }}</p>
            </div>
        </div>

        <!-- Bottom -->
        <div class="mt-10 border-t border-gray-700 pt-6 text-center text-sm text-gray-400">
            <div class="flex justify-center gap-6 mb-4">
                <a href="#" class="hover:text-white" aria-label="Facebook">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300 hover:text-white" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M22 12a10 10 0 1 0-11.57 9.87v-7H8v-2.9h2.43v-2.2c0-2.4 1.43-3.73 3.63-3.73 1.05 0 2.15.19 2.15.19v2.36h-1.21c-1.2 0-1.57.75-1.57 1.52v1.86H18l-.4 2.9h-2.62v7A10 10 0 0 0 22 12z" />
                    </svg>
                </a>
                <a href="#" class="hover:text-white" aria-label="Twitter">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300 hover:text-white" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M22.46 6c-.77.35-1.6.59-2.46.7a4.29 4.29 0 0 0 1.88-2.37 8.62 8.62 0 0 1-2.72 1.04A4.28 4.28 0 0 0 16.1 4c-2.37 0-4.29 1.92-4.29 4.29 0 .34.04.67.11.99A12.19 12.19 0 0 1 3 5.16a4.29 4.29 0 0 0 1.32 5.72 4.27 4.27 0 0 1-1.94-.54v.05a4.3 4.3 0 0 0 3.44 4.2 4.36 4.36 0 0 1-1.93.07 4.29 4.29 0 0 0 4 2.98 8.61 8.61 0 0 1-6.32 1.76 12.1 12.1 0 0 0 6.56 1.92c7.88 0 12.2-6.53 12.2-12.2 0-.19 0-.38-.01-.57A8.6 8.6 0 0 0 24 5.34a8.42 8.42 0 0 1-2.54.7z" />
                    </svg>
                </a>
                <a href="#" class="hover:text-white" aria-label="Instagram">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300 hover:text-white" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2.16c3.18 0 3.56.01 4.81.07 1.2.06 1.96.25 2.41.42a4.79 4.79 0 0 1 1.75 1.14 4.79 4.79 0 0 1 1.14 1.75c.17.45.36 1.2.42 2.41.06 1.25.07 1.63.07 4.81s-.01 3.56-.07 4.81c-.06 1.2-.25 1.96-.42 2.41a4.79 4.79 0 0 1-1.14 1.75 4.79 4.79 0 0 1-1.75 1.14c-.45.17-1.2.36-2.41.42-1.25.06-1.63.07-4.81.07s-3.56-.01-4.81-.07c-1.2-.06-1.96-.25-2.41-.42a4.79 4.79 0 0 1-1.75-1.14 4.79 4.79 0 0 1-1.14-1.75c-.17-.45-.36-1.2-.42-2.41C2.17 15.56 2.16 15.18 2.16 12s.01-3.56.07-4.81c.06-1.2.25-1.96.42-2.41A4.79 4.79 0 0 1 3.79 3.03a4.79 4.79 0 0 1 1.75-1.14c.45-.17 1.2-.36 2.41-.42C8.44 2.17 8.82 2.16 12 2.16Zm0 3.5a5.34 5.34 0 1 1 0 10.67A5.34 5.34 0 0 1 12 7.26Zm0 1.6a3.74 3.74 0 1 0 0 7.47 3.74 3.74 0 0 0 0-7.47Zm5.47-1.47a1.25 1.25 0 1 1-2.5 0 1.25 1.25 0 0 1 2.5 0Z" />
                    </svg>
                </a>
            </div>
            © 2025 FuturaFly. All rights reserved.
        </div>
    </footer>
</template>
