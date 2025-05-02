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
    <footer class="bg-[#002642] dark:bg-gray-900 text-white pt-12 pb-8 px-6 transition-colors duration-300">
        <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-10">
            <!-- Brand -->
            <div class="md:col-span-1">
                <h2 class="text-2xl font-bold mb-4">FuturaFly</h2>
                <p class="text-sm text-gray-300 dark:text-gray-400">
                    Fly into the future with style, safety, and comfort. Discover your next destination with FuturaFly.
                </p>
            </div>

            <!-- Explore -->
            <div>
                <h3 class="text-sm font-semibold uppercase mb-4">Explore</h3>
                <ul class="space-y-2 text-sm text-gray-300 dark:text-gray-400">
                    <li><Link href="/" class="hover:text-white dark:hover:text-green-300">Home</Link></li>
                    <li><Link href="/offers" class="hover:text-white dark:hover:text-green-300">Offers</Link></li>
                    <li><Link href="/stopover" class="hover:text-white dark:hover:text-green-300">Stopover</Link></li>
                    <li><Link href="/addons" class="hover:text-white dark:hover:text-green-300">Add-Ons</Link></li>
                </ul>
            </div>

            <!-- Support -->
            <div>
                <h3 class="text-sm font-semibold uppercase mb-4">Support</h3>
                <ul class="space-y-2 text-sm text-gray-300 dark:text-gray-400">
                    <li><Link href="/faq" class="hover:text-white dark:hover:text-green-300">FAQs</Link></li>
                    <li><Link href="/contact" class="hover:text-white dark:hover:text-green-300">Contact Us</Link></li>
                    <li><Link href="/alerts" class="hover:text-white dark:hover:text-green-300">Travel Alerts</Link></li>
                    <li><Link href="/policies" class="hover:text-white dark:hover:text-green-300">Policies</Link></li>
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
        <div class="mt-10 border-t border-gray-700 pt-6 text-center text-sm text-gray-400 dark:text-gray-500">
            <div class="flex justify-center gap-6 mb-4">
                <!-- Instagram -->
                <a href="https://www.instagram.com/echo_mockingbird/" target="_blank" class="hover:text-white dark:hover:text-green-300" aria-label="Instagram">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-300 dark:text-gray-400 hover:text-white dark:hover:text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 2H17C20 2 22 4 22 7V17C22 20 20 22 17 22H7C4 22 2 20 2 17V7C2 4 4 2 7 2ZM15.5 11.5C15.5 13.9853 13.4853 16 11 16C8.51472 16 6.5 13.9853 6.5 11.5C6.5 9.01472 8.51472 7 11 7C13.4853 7 15.5 9.01472 15.5 11.5ZM17 7.5C17.2761 7.5 17.5 7.72386 17.5 8C17.5 8.27614 17.2761 8.5 17 8.5C16.7239 8.5 16.5 8.27614 16.5 8C16.5 7.72386 16.7239 7.5 17 7.5Z" />
                    </svg>
                </a>

                <!-- YouTube -->
                <a href="https://www.youtube.com/@zezobraznica343" target="_blank" class="hover:text-white dark:hover:text-green-300" aria-label="YouTube">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-300 dark:text-gray-400 hover:text-white dark:hover:text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 15L15 12L10 9V15ZM22 12C22 9.8 21.8 8.2 21.7 7.4C21.6 6.6 21 6 20.2 5.9C19.4 5.8 12 5.8 12 5.8C12 5.8 4.6 5.8 3.8 5.9C3 6 2.4 6.6 2.3 7.4C2.2 8.2 2 9.8 2 12C2 14.2 2.2 15.8 2.3 16.6C2.4 17.4 3 18 3.8 18.1C4.6 18.2 12 18.2 12 18.2C12 18.2 19.4 18.2 20.2 18.1C21 18 21.6 17.4 21.7 16.6C21.8 15.8 22 14.2 22 12Z" />
                    </svg>
                </a>

                <!-- Placeholder (use star icon for now) -->
                <a href="#" class="hover:text-white dark:hover:text-green-300" aria-label="Coming Soon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-300 dark:text-gray-400 hover:text-white dark:hover:text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.562 4.804a1 1 0 00.95.69h5.043c.969 0 1.371 1.24.588 1.81l-4.082 2.962a1 1 0 00-.364 1.118l1.562 4.804c.3.921-.755 1.688-1.54 1.118l-4.082-2.962a1 1 0 00-1.176 0l-4.082 2.962c-.784.57-1.838-.197-1.54-1.118l1.562-4.804a1 1 0 00-.364-1.118L2.404 10.23c-.783-.57-.38-1.81.588-1.81h5.043a1 1 0 00.95-.69l1.562-4.804z" />
                    </svg>
                </a>
            </div>
        </div>


    </footer>
</template>
