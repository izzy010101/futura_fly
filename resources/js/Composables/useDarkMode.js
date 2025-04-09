// resources/js/Composables/useDarkMode.js
import { ref, watch } from 'vue'

const isDark = ref(localStorage.getItem('theme') === 'dark')

watch(isDark, (value) => {
    const html = document.documentElement
    if (value) {
        html.classList.add('dark')
        localStorage.setItem('theme', 'dark')
    } else {
        html.classList.remove('dark')
        localStorage.setItem('theme', 'light')
    }
}, { immediate: true })

const toggleDarkMode = () => {
    isDark.value = !isDark.value
}

export default function useDarkMode() {
    return { isDark, toggleDarkMode }
}
