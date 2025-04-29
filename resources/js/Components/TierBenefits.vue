<script setup>
import { computed } from 'vue'
import {
    ShieldCheckIcon,
    CheckCircleIcon,
    PaperAirplaneIcon,
    BriefcaseIcon,
    StarIcon
} from '@heroicons/vue/24/solid'

const props = defineProps({
    tier: {
        type: String,
        default: 'silver',
        validator: (value) => ['silver', 'gold', 'platinum'].includes(value)
    }
})

const benefits = computed(() => {
    const base = {
        silver: [
            { icon: ShieldCheckIcon, title: '10% Bonus Miles', desc: 'Earn 10% more miles.' },
            { icon: CheckCircleIcon, title: 'Priority Check-in', desc: 'Save time at counters.' },
            { icon: PaperAirplaneIcon, title: 'Seat Selection', desc: 'Free preferred seat.' }
        ],
        gold: [
            { icon: StarIcon, title: '25% Bonus Miles', desc: 'Earn more points every flight.' },
            { icon: CheckCircleIcon, title: 'Lounge Access', desc: '2 complimentary visits/year.' },
            { icon: PaperAirplaneIcon, title: 'Priority Boarding', desc: 'Board ahead of others.' }
        ],
        platinum: [
            { icon: ShieldCheckIcon, title: '50% Bonus Miles', desc: 'Max rewards per flight.' },
            { icon: BriefcaseIcon, title: 'Free 2 Bags', desc: 'Extra luggage included.' },
            { icon: PaperAirplaneIcon, title: 'Priority Upgrades', desc: 'Automatic upgrades when available.' }
        ]
    }

    return base[props.tier] || []
})

const tierColor = computed(() => {
    if (props.tier === 'silver') return {
        bg: 'from-blue-500 to-blue-600',
        darkBg: 'dark:from-gray-600 dark:to-gray-700',
        iconBg: 'bg-blue-100 dark:bg-blue-900/30',
        iconText: 'text-blue-600 dark:text-blue-400',
        border: 'border-blue-200 dark:border-blue-800/50'
    }
    if (props.tier === 'gold') return {
        bg: 'from-amber-400 to-amber-500',
        darkBg: 'dark:from-amber-600 dark:to-amber-700',
        iconBg: 'bg-amber-100 dark:bg-amber-900/30',
        iconText: 'text-amber-600 dark:text-amber-400',
        border: 'border-amber-200 dark:border-amber-800/50'
    }
    return {
        bg: 'from-indigo-500 to-purple-600',
        darkBg: 'dark:from-indigo-600 dark:to-purple-700',
        iconBg: 'bg-indigo-100 dark:bg-indigo-900/30',
        iconText: 'text-indigo-600 dark:text-indigo-400',
        border: 'border-indigo-200 dark:border-indigo-800/50'
    }
})
</script>

<template>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div
            v-for="(benefit, index) in benefits"
            :key="index"
            class="group relative p-6 rounded-xl bg-white dark:bg-gray-800 shadow-sm hover:shadow-lg transition-all duration-300 border overflow-hidden"
            :class="tierColor.border"
        >
            <!-- Subtle gradient background that appears on hover -->
            <div
                class="absolute inset-0 opacity-0 group-hover:opacity-5 transition-opacity duration-300 bg-gradient-to-br"
                :class="[tierColor.bg, tierColor.darkBg]"
            ></div>

            <!-- Content -->
            <div class="relative z-10">
                <div
                    class="flex h-14 w-14 items-center justify-center rounded-full mb-4 transition-transform duration-300 group-hover:scale-110"
                    :class="tierColor.iconBg"
                >
                    <component :is="benefit.icon" class="w-7 h-7" :class="tierColor.iconText" />
                </div>

                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">
                    {{ benefit.title }}
                </h3>

                <p class="text-gray-600 dark:text-gray-300">
                    {{ benefit.desc }}
                </p>

                <!-- Subtle indicator line that grows on hover -->
                <div
                    class="absolute bottom-0 left-0 h-1 w-0 group-hover:w-full transition-all duration-500 bg-gradient-to-r"
                    :class="[tierColor.bg, tierColor.darkBg]"
                ></div>
            </div>
        </div>
    </div>
</template>
