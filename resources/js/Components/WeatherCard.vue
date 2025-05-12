<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const displayCities = ref([])
const weatherData = ref([])
const index = ref(0)
const loading = ref(true)

const rotateWeather = () => {
    if (weatherData.value.length === 0) return

    const slice = weatherData.value.slice(index.value, index.value + 3)
    displayCities.value = slice

    index.value = (index.value + 3) % weatherData.value.length

    const delay = Math.floor(Math.random() * 3000) + 5000 // random between 5000–8000 ms
    setTimeout(rotateWeather, delay)
}

const fetchWeather = async () => {
    try {
        const res = await axios.get('/api/weather')
        weatherData.value = res.data
    } catch (error) {
        console.error('Failed to fetch weather:', error)
    } finally {
        loading.value = false
        rotateWeather()
    }
}

onMounted(() => {
    fetchWeather()
})
</script>



<template>
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
        <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">
            Weather at Key Airports
        </h2>

        <div v-if="loading" class="text-gray-500 dark:text-gray-400">Loading weather data...</div>

        <div v-else>
            <div v-for="city in displayCities" :key="city.name" class="flex justify-between items-center py-2 border-b border-gray-200 dark:border-gray-700 last:border-none">
                <div>
                    <div class="font-medium text-gray-800 dark:text-gray-100">{{ city.name }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">Daily Forecast</div>
                </div>
                <div class="text-sm text-gray-800 dark:text-white">
                    Max: {{ city.max }}°C<br />
                    Min: {{ city.min }}°C
                </div>
            </div>
        </div>
    </div>
</template>


