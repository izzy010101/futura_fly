<script setup>
import { ref } from 'vue'
import { Head, useForm, usePage } from '@inertiajs/vue3'
import HeaderComponent from '@/Components/HeaderComponent.vue'
import Footer from '@/Components/Footer.vue'


const page = usePage()
const auth = page.props.auth
</script>

<template>
    <Head title="PrivilegeClub" />
    <HeaderComponent :auth="auth" />

    <div class="p-8">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-4">
            Privilege Club
        </h1>
        <p class="text-gray-600 dark:text-gray-400">
            Welcome to your Privilege Club! 🚀
            Soon you'll be able to earn points, unlock tiers, and enjoy rewards.
        </p>
    </div>
    <Footer/>
</template>
