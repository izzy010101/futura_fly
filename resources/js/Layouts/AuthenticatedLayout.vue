<script setup>
import { usePage } from '@inertiajs/vue3'
import HeaderComponent from '@/Components/HeaderComponent.vue'
import Footer from '@/Components/Footer.vue'

const page = usePage()
const auth = page.props.auth
const canLogin = page.props.canLogin
const canRegister = page.props.canRegister
</script>

<template>
    <div class="min-h-screen bg-gray-100 flex flex-col">
        <!-- ✅ Global Header (my header component with dropdowns) -->
        <HeaderComponent :auth="auth" :can-login="canLogin" :can-register="canRegister" />


        <header v-if="$slots.header" class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
                <slot name="header" />
            </div>
        </header>

        <main class="flex-grow">
            <slot />
        </main>

        <Footer />
    </div>
</template>
