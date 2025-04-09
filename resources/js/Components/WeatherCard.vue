<script setup>
import { ref, onMounted } from 'vue'

// Capital cities with airports
const cities = [
    { name: 'New York', lat: 40.7128, lon: -74.006 },
    { name: 'London', lat: 51.5074, lon: -0.1278 },
    { name: 'Tokyo', lat: 35.6895, lon: 139.6917 },
    { name: 'Paris', lat: 48.8566, lon: 2.3522 },
    { name: 'Berlin', lat: 52.52, lon: 13.405 },
    { name: 'Dubai', lat: 25.276987, lon: 55.296249 },
    { name: 'Belgrade', lat: 44.7866, lon: 20.4489 },
    { name: 'Niš', lat: 43.319, lon: 21.896 },
    { name: 'Munich', lat: 48.1351, lon: 11.5820 },
]

const displayCities = ref([])
let index = 0
const cache = new Map()

const getWeatherIcon = (code) => {
    const icons = {
        0: '☀️', 1: '🌤️', 2: '⛅', 3: '☁️',
        45: '🌫️', 48: '🌫️', 51: '🌦️', 61: '🌧️',
        71: '🌨️', 95: '⛈️', 99: '🌩️'
    }
    return icons[code] || '❓'
}

const fetchWeather = async (city) => {
    if (cache.has(city.name)) return cache.get(city.name)

    const res = await fetch(`https://api.open-meteo.com/v1/forecast?latitude=${city.lat}&longitude=${city.lon}&current_weather=true`)
    const data = await res.json()
    const weather = {
        name: city.name,
        temperature: Math.round(data.current_weather.temperature),
        weatherCode: data.current_weather.weathercode,
        icon: getWeatherIcon(data.current_weather.weathercode)
    }

    cache.set(city.name, weather)
    return weather
}

const rotateWeather = async () => {
    const slice = cities.slice(index, index + 3)
    const data = await Promise.all(slice.map(fetchWeather))
    displayCities.value = data

    index = (index + 3) % cities.length
}

onMounted(() => {
    rotateWeather()
    setInterval(rotateWeather, 10000) // every 10 seconds, mozda da stavim ovde pola minuta hmm
})
</script>

<template>
    <div class="bg-white dark:bg-gray-900 p-6 rounded-lg shadow">
        <h2 class="text-xl font-semibold mb-4">Weather at Key Airports</h2>
        <div v-for="city in displayCities" :key="city.name" class="flex justify-between items-center py-2">
            <div>
                <div class="font-medium">{{ city.name }}</div>
                <div class="text-sm text-gray-500">Live Weather</div>
            </div>
            <div class="text-lg font-semibold flex items-center gap-1">
                {{ city.temperature }}°C <span>{{ city.icon }}</span>
            </div>
        </div>
    </div>
</template>
