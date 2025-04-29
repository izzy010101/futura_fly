<script setup>
import { usePage, Head } from '@inertiajs/vue3'
import HeaderComponent from '@/Components/HeaderComponent.vue'
import Footer from '@/Components/Footer.vue'
import PrivilegeBanner from '@/Components/PrivilegeBanner.vue'
import TierTabs from '@/Components/TierTabs.vue'

const auth = usePage().props.auth
</script>

<template>
    <Head title="Privilege Club" />
    <HeaderComponent :auth="auth" />

    <div class="p-8 space-y-6">
        <PrivilegeBanner />
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow p-6">
            <TierTabs />
        </div>
    </div>

    <Footer />
</template>

