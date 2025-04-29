<script setup>
import { ref } from 'vue'
import TierBenefits from './TierBenefits.vue'

const activeTab = ref('silver')
</script>

<template>
    <div>
        <div class="flex justify-center mb-8">
            <div class="inline-flex p-1 rounded-full bg-gray-100 dark:bg-gray-800 shadow-inner">
                <button
                    v-for="tab in ['silver', 'gold', 'platinum']"
                    :key="tab"
                    @click="activeTab = tab"
                    class="relative px-6 py-2 rounded-full text-sm font-medium transition-all duration-300 focus:outline-none"
                    :class="[
            activeTab === tab
              ? 'text-white shadow-md'
              : 'text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700'
          ]"
                >
          <span class="relative z-10">
            {{ tab.charAt(0).toUpperCase() + tab.slice(1) }}
          </span>

                    <!-- Active tab background -->
                    <span
                        v-if="activeTab === tab"
                        class="absolute inset-0 rounded-full bg-gradient-to-r transition-all duration-300"
                        :class="[
              activeTab === 'silver' ? 'from-blue-500 to-blue-600 dark:from-gray-600 dark:to-gray-700' :
              activeTab === 'gold' ? 'from-amber-400 to-amber-500 dark:from-amber-600 dark:to-amber-700' :
              'from-indigo-500 to-purple-600 dark:from-indigo-600 dark:to-purple-700'
            ]"
                    ></span>
                </button>
            </div>
        </div>

        <TierBenefits :tier="activeTab" />
    </div>
</template>
