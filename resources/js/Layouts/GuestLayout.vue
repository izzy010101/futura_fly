<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
import Footer from '@/Components/Footer.vue';
import HeaderComponent from '@/Components/HeaderComponent.vue'
import {ref} from "vue";

const canLogin = Boolean(route().has('login'))
const canRegister = Boolean(route().has('register'))


</script>

<template>
    <div class="min-h-screen w-full bg-gray-100 flex flex-col">
        <HeaderComponent :can-login="canLogin" :can-register="canRegister" />

        <main class="flex-1">
            <slot />
        </main>

        <Footer />
    </div>
</template>

