<script setup>
import { ref, onMounted } from 'vue'

const cities = [
    { name: 'New York', lat: 40.7128, lon: -74.006 },
    { name: 'London', lat: 51.5074, lon: -0.1278 },
    { name: 'Tokyo', lat: 35.6895, lon: 139.6917 },
    { name: 'Paris', lat: 48.8566, lon: 2.3522 },
    { name: 'Berlin', lat: 52.52, lon: 13.405 },
    { name: 'Dubai', lat: 25.276987, lon: 55.296249 },
    { name: 'Belgrade', lat: 44.7866, lon: 20.4489 },
    { name: 'Munich', lat: 48.1351, lon: 11.5820 },
    { name: 'Madrid', lat: 40.4168, lon: -3.7038 },
    { name: 'Rome', lat: 41.9028, lon: 12.4964 },
    { name: 'Istanbul', lat: 41.0082, lon: 28.9784 },
    { name: 'Amsterdam', lat: 52.3676, lon: 4.9041 },
    { name: 'Vienna', lat: 48.2082, lon: 16.3738 },
    { name: 'Zurich', lat: 47.3769, lon: 8.5417 },
    { name: 'Toronto', lat: 43.651070, lon: -79.347015 },
    { name: 'Los Angeles', lat: 34.0522, lon: -118.2437 },
    { name: 'Chicago', lat: 41.8781, lon: -87.6298 },
    { name: 'San Francisco', lat: 37.7749, lon: -122.4194 },
    { name: 'Seoul', lat: 37.5665, lon: 126.9780 },
    { name: 'Singapore', lat: 1.3521, lon: 103.8198 },
    { name: 'Hong Kong', lat: 22.3193, lon: 114.1694 },
    { name: 'Sydney', lat: -33.8688, lon: 151.2093 },
    { name: 'Bangkok', lat: 13.7563, lon: 100.5018 },
    { name: 'Doha', lat: 25.276987, lon: 51.5200 },
    { name: 'Oslo', lat: 59.9139, lon: 10.7522 },
];
const displayCities = ref([])
let index = 0

const fetchWeather = async (city) => {
    const res = await fetch(`https://api.open-meteo.com/v1/forecast?latitude=${city.lat}&longitude=${city.lon}&current_weather=true`)
    const data = await res.json()
    return {
        name: city.name,
        temperature: Math.round(data.current_weather.temperature),
        weatherCode: data.current_weather.weathercode,
        icon: getWeatherIcon(data.current_weather.weathercode)
    }
}

const rotateWeather = async () => {
    const slice = cities.slice(index, index + 3)
    const data = await Promise.all(slice.map(fetchWeather))
    displayCities.value = data
    index = (index + 3) % cities.length
}

function getWeatherIcon(code) {
    const icons = {
        0: '☀️', 1: '🌤️', 2: '⛅', 3: '☁️',
        45: '🌫️', 48: '🌫️', 51: '🌦️', 61: '🌧️',
        71: '🌨️', 95: '⛈️', 99: '🌩️'
    }
    return icons[code] || '❓'
}

onMounted(() => {
    rotateWeather()
    setInterval(rotateWeather, 4000)
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
