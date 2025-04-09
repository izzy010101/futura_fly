<template>
    <div class="p-8 max-w-md mx-auto bg-white shadow rounded">
        <h2 class="text-xl font-bold mb-4">Upload Image</h2>

        <input type="file" @change="handleFileChange" class="mb-4" />

        <button
            @click="uploadImage"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
        >
            Upload
        </button>

        <p v-if="message" class="text-green-600 mt-4">{{ message }}</p>

        <div v-if="imagePaths.length" class="mt-6">
            <p class="font-semibold mb-2">Uploaded Versions:</p>
            <img
                v-for="(path, index) in imagePaths"
                :key="index"
                :src="`/${path}`"
                class="mb-2 rounded shadow"
                alt="Resized Version"
            />
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'

const file = ref(null)
const message = ref('')
const imagePaths = ref([])

const handleFileChange = (e) => {
    file.value = e.target.files[0]
}

const uploadImage = async () => {
    if (!file.value) return

    const formData = new FormData()
    formData.append('image', file.value)

    try {
        const res = await axios.post('/upload-image', formData)
        message.value = res.data.message
        imagePaths.value = res.data.paths
    } catch (error) {
        message.value = error.response?.data?.message || 'Upload failed'
    }
}
</script>
