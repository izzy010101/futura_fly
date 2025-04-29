<script setup>
import { computed } from 'vue'
import { StarIcon, TrophyIcon, SparklesIcon } from '@heroicons/vue/24/solid'

const props = defineProps({
    user: {
        type: Object,
        default: () => ({
            points: 0,
            tier: 'Silver'
        })
    }
})

const nextTier = computed(() => {
    if (props.user.tier === 'Silver') return 'Gold'
    if (props.user.tier === 'Gold') return 'Platinum'
    return null
})

const nextThreshold = computed(() => {
    if (props.user.tier === 'Silver') return 10000
    if (props.user.tier === 'Gold') return 30000
    return 0
})

const progress = computed(() => {
    return Math.min((props.user.points / nextThreshold.value) * 100, 100)
})

const tierIcon = computed(() => {
    if (props.user.tier === 'Silver') return StarIcon
    if (props.user.tier === 'Gold') return TrophyIcon
    return SparklesIcon
})

const tierColor = computed(() => {
    if (props.user.tier === 'Silver') return 'from-slate-400 to-slate-500'
    if (props.user.tier === 'Gold') return 'from-amber-400 to-amber-500'
    return 'from-indigo-500 to-purple-600'
})

const tierBadgeColor = computed(() => {
    if (props.user.tier === 'Silver') return 'bg-slate-200 text-slate-700 dark:bg-slate-700 dark:text-slate-200'
    if (props.user.tier === 'Gold') return 'bg-amber-200 text-amber-700 dark:bg-amber-700 dark:text-amber-200'
    return 'bg-indigo-200 text-indigo-700 dark:bg-indigo-700 dark:text-indigo-200'
})
</script>

<template>
    <div class="relative overflow-hidden rounded-xl bg-gradient-to-r from-blue-500 to-blue-600 dark:from-gray-700 dark:to-gray-800 shadow-lg">
        <!-- Background pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute -right-10 -top-10 h-40 w-40 rounded-full bg-white"></div>
            <div class="absolute -left-10 -bottom-10 h-40 w-40 rounded-full bg-white"></div>
        </div>

        <div class="relative p-6 sm:p-8">
            <div class="flex items-start gap-4">
                <!-- Tier icon -->
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-white/20 backdrop-blur-sm">
                    <component :is="tierIcon" class="h-6 w-6 text-white" />
                </div>

                <div class="flex-1">
                    <!-- Header -->
                    <div class="flex flex-wrap items-center gap-2 mb-2">
                        <h2 class="text-xl sm:text-2xl font-bold text-white">Welcome to Privilege Club</h2>
                        <span :class="[tierBadgeColor, 'px-2 py-0.5 text-xs font-medium rounded-full']">
                            {{ user.tier }}
                        </span>
                    </div>

                    <!-- Points info -->
                    <p class="text-white/90 mb-4">
                        You're currently a <span class="font-semibold">{{ user.tier }}</span> member with
                        <span class="font-semibold">{{ user.points.toLocaleString() }}</span> points
                    </p>

                    <!-- Progress bar -->
                    <div v-if="nextTier" class="mt-4">
                        <div class="flex justify-between text-sm mb-1.5">
                            <span class="text-white/80">Progress to {{ nextTier }} Tier</span>
                            <span class="text-white/80">
                                {{ user.points.toLocaleString() }} / {{ nextThreshold.toLocaleString() }} points
                            </span>
                        </div>

                        <div class="h-2 w-full overflow-hidden rounded-full bg-white/20">
                            <div
                                class="h-full rounded-full bg-white transition-all duration-1000 ease-out"
                                :style="{ width: `${progress}%` }"
                            ></div>
                        </div>

                        <p v-if="nextTier" class="mt-2 text-xs text-white/80">
                            You need {{ (nextThreshold - user.points).toLocaleString() }} more points to reach {{ nextTier }}
                        </p>
                    </div>

                    <!-- Platinum message -->
                    <p v-else class="mt-4 text-white/90 italic">
                        Congratulations! You've reached our highest tier status.
                    </p>
                </div>
            </div>
        </div>

        <!-- Decorative accent -->
        <div :class="[`bg-gradient-to-r ${tierColor}`, 'absolute bottom-0 h-1 w-full']"></div>
    </div>
</template>
