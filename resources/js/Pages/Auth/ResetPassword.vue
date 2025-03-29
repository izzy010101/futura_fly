<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import TextInput from '@/Components/TextInput.vue'
import { Head, useForm } from '@inertiajs/vue3'
import { ref, watch } from 'vue'

const props = defineProps({
    email: { type: String, required: true },
    token: { type: String, required: true },
})

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
})

const validationErrors = ref({
    password: '',
    password_confirmation: '',
})

// Password live validation
watch(() => form.password, (val) => {
    validationErrors.value.password = ''
    if (!val) {
        validationErrors.value.password = 'Password is required.'
    } else if (val.length < 6) {
        validationErrors.value.password = 'Password must be at least 6 characters.'
    }
    form.clearErrors('password')
})

// Confirm Password live validation
watch([() => form.password, () => form.password_confirmation], ([pass, confirm]) => {
    validationErrors.value.password_confirmation =
        confirm !== pass ? 'Passwords do not match.' : ''
    form.clearErrors('password_confirmation')
})

const submit = () => {
    // Check if any live validation errors are still present
    const hasClientErrors = Object.values(validationErrors.value).some(error => error)

    if (hasClientErrors) return

    form.post(route('password.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    })
}

</script>

<template>
    <GuestLayout>
        <Head title="Reset Password" />

        <div class="grid grid-cols-1 lg:grid-cols-2 min-h-screen bg-white">
            <!-- Left Panel -->
            <div class="hidden lg:flex flex-col justify-center items-center bg-gradient-to-br from-[#002642] via-[#22668D] to-[#6EA8DA] text-white p-10">
                <h1 class="text-4xl font-bold mb-4">Reset Your Password</h1>
                <p class="text-lg text-white/80 text-center max-w-xs">
                    Enter your new password and confirm it to regain access.
                </p>
            </div>

            <!-- Right Panel -->
            <div class="flex flex-col justify-center p-8 sm:p-12 w-full max-w-xl mx-auto">
                <form @submit.prevent="submit" class="space-y-6">
                    <div>
                        <InputLabel for="email" value="Email" class="text-[#002642]" />
                        <TextInput
                            id="email"
                            type="email"
                            v-model="form.email"
                            disabled
                            class="mt-1 block w-full rounded-lg bg-gray-100 text-gray-700 border-gray-300"
                        />
                    </div>

                    <div>
                        <InputLabel for="password" value="New Password" class="text-[#002642]" />
                        <TextInput
                            id="password"
                            type="password"
                            v-model="form.password"
                            autocomplete="new-password"
                            :class="[
                                'mt-1 block w-full rounded-lg transition',
                                validationErrors.password || form.errors.password
                                  ? 'border-red-500 focus:border-red-500 focus:ring-red-500'
                                  : 'border-gray-300 focus:border-[#22668D] focus:ring-[#22668D]'
                              ]"
                        />
                        <InputError class="mt-2" :message="validationErrors.password || form.errors.password" />
                    </div>

                    <div>
                        <InputLabel for="password_confirmation" value="Confirm Password" class="text-[#002642]" />
                        <TextInput
                            id="password_confirmation"
                            type="password"
                            v-model="form.password_confirmation"
                            autocomplete="new-password"
                            :class="[
                                'mt-1 block w-full rounded-lg transition',
                                validationErrors.password_confirmation || form.errors.password_confirmation
                                  ? 'border-red-500 focus:border-red-500 focus:ring-red-500'
                                  : 'border-gray-300 focus:border-[#22668D] focus:ring-[#22668D]'
                              ]"
                        />
                        <InputError class="mt-2" :message="validationErrors.password_confirmation || form.errors.password_confirmation" />
                    </div>

                    <div class="flex justify-end">
                        <PrimaryButton
                            class="bg-[#22668D] hover:bg-[#002642] text-white font-semibold py-2 px-6 rounded-lg transition"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            Reset Password
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </GuestLayout>
</template>
