<script setup>
import Checkbox from '@/Components/Checkbox.vue'
import GuestLayout from '@/Layouts/GuestLayout.vue'
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import TextInput from '@/Components/TextInput.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import { ref, watch } from 'vue'
import axios from 'axios'
import debounce from 'lodash/debounce'

defineProps({
    canResetPassword: Boolean,
    status: String,
})

// Form data
const form = useForm({
    email: '',
    password: '',
    remember: false,
})

// Validation error state
const validationErrors = ref({
    email: '',
    password: '',
})

// live validation

watch(() => form.email, debounce(async (email) => {
    validationErrors.value.email = ''

    if (!email) {
        validationErrors.value.email = 'Email is required.'
    } else if (!/^\S+@\S+\.\S+$/.test(email)) {
        validationErrors.value.email = 'Please enter a valid email.'
    } else {
        try {
            const res = await axios.post('/validate-email', { email })
            if (!res.data.exists) {
                validationErrors.value.email = 'Email not found.'
            }
        } catch (e) {
            validationErrors.value.email = 'Server error while checking email.'
        }
    }
}, 500)) // debounce to avoid spamming

watch(() => form.password, (password) => {
    validationErrors.value.password = ''
    if (!password) {
        validationErrors.value.password = 'Password is required.'
    } else if (password.length < 6) {
        validationErrors.value.password = 'Password must be at least 6 characters.'
    }
})

// === Submit ===
const submit = () => {
    form.clearErrors()

    if (validationErrors.value.email || validationErrors.value.password) return

    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    })
}
</script>


<template>
    <GuestLayout>
        <Head title="Log in" />

        <div class="grid grid-cols-1 lg:grid-cols-2 min-h-screen w-full bg-white"
        >
            <!-- Left Panel -->
            <div class="hidden lg:flex flex-col justify-center items-center bg-gradient-to-br from-[#002642] via-[#22668D] to-[#6EA8DA] text-white p-10">
                <h1 class="text-4xl font-bold mb-4">Welcome Back!</h1>
                <p class="text-lg text-white/80 text-center max-w-xs">Please log in to manage your trips and bookings.</p>
            </div>

            <!-- Right Panel - Login Form -->
            <div class="flex flex-col justify-center p-8 sm:p-12">
                <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
                    {{ status }}
                </div>

                <form @submit.prevent="submit" class="space-y-6">
                    <div>
                        <InputLabel for="email" value="Email" class="text-[#002642]" />

                        <TextInput
                            v-model="form.email"
                            type="email"
                            id="email"
                            autocomplete="username"
                            :class="[
                                'mt-1 block w-full rounded-lg transition',
                                validationErrors.email
                                  ? 'border-red-500 focus:border-red-500 focus:ring-red-500'
                                  : 'border-gray-300 focus:border-[#22668D] focus:ring-[#22668D]'
                              ]"
                        />
                        <InputError :message="validationErrors.email" />

                    </div>

                    <div>
                        <InputLabel for="password" value="Password" class="text-[#002642]" />

                        <TextInput
                            id="password"
                            type="password"
                            v-model="form.password"
                            autocomplete="current-password"
                            autofocus
                            :class="[
            'mt-1 block w-full rounded-lg transition',
            validationErrors.password
              ? 'border-red-500 focus:border-red-500 focus:ring-red-500'
              : 'border-gray-300 focus:border-[#22668D] focus:ring-[#22668D]'
        ]"
                        />

                        <InputError class="mt-2" :message="validationErrors.password" />
                    </div>


                    <div class="flex items-center justify-between text-sm">
                        <label class="flex items-center">
                            <Checkbox name="remember" v-model:checked="form.remember" />
                            <span class="ms-2 text-gray-600">Remember me</span>
                        </label>

                        <Link
                            v-if="canResetPassword"
                            :href="route('password.request')"
                            class="text-[#22668D] hover:underline"
                        >
                            Forgot password?
                        </Link>
                    </div>

                    <div>
                        <PrimaryButton
                            class="bg-[#22668D] hover:bg-[#002642] text-white font-semibold py-2 px-4 rounded-lg transition"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            Log in
                        </PrimaryButton>
                    </div>

                    <div class="text-sm text-gray-500">
                        New here?
                        <Link :href="route('register')" class="text-[#22668D] hover:underline ml-1">
                            Sign up
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    </GuestLayout>
</template>


