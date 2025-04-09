<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
import Footer from '@/Components/Footer.vue';
import HeaderComponent from '@/Components/HeaderComponent.vue'
import {ref} from "vue";
import { usePage } from '@inertiajs/vue3';
import DarkMode from '@/Composables/useDarkMode.js'

const { isDark } = DarkMode

const { props } = usePage();

const auth = props.auth;
const canLogin = Boolean(route().has('login'))
const canRegister = Boolean(route().has('register'))


</script>

<template>
    <div :class="{ dark: isDark }" class="min-h-screen bg-gray-100 dark:bg-gray-900 dark:text-white">
        <HeaderComponent :auth="auth" :can-login="canLogin" :can-register="canRegister" />

        <main class="flex-1">
            <slot />
        </main>

        <Footer />
    </div>
</template>

