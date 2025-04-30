<script setup>
import {Head, usePage} from '@inertiajs/vue3'
import HeaderComponent from '@/Components/HeaderComponent.vue'
import Footer from '@/Components/Footer.vue'
import PrivilegeBanner from '@/Components/PrivilegeBanner.vue'
import TierTabs from '@/Components/TierTabs.vue'

const { props } = usePage()
const user = props.user
</script>

<template>
    <Head title="Privilege_Club"/>
    <HeaderComponent :auth="props.auth" />

    <div class="p-8 space-y-6">
        <PrivilegeBanner :user="user" />
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow p-6">
            <TierTabs />
        </div>
    </div>

    <Footer />
</template>
