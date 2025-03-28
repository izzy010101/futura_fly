<!--forgot pass page vue-->
<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <GuestLayout>
        <Head title="Forgot Password" />

        <div class="grid grid-cols-1 lg:grid-cols-2 min-h-screen w-full bg-white">
            <!-- Left Panel -->
            <div class="hidden lg:flex flex-col justify-center items-center bg-gradient-to-br from-[#002642] via-[#22668D] to-[#6EA8DA] text-white p-10">
                <h1 class="text-4xl font-bold mb-4">Reset Password</h1>
                <p class="text-lg text-white/80 text-center max-w-xs">
                    We'll send you a link to create a new password. Just enter your email.
                </p>
            </div>

            <!-- Right Panel -->
            <div class="flex flex-col justify-center p-8 sm:p-12 w-full max-w-md mx-auto">
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold text-[#002642]">Forgot your password?</h2>
                    <p class="text-sm text-gray-500 mt-1">
                        No problem. Just enter your email address and we’ll send you a reset link.
                    </p>
                </div>

                <div v-if="status" class="mb-4 text-sm font-medium text-green-600 text-center">
                    {{ status }}
                </div>

                <form @submit.prevent="submit" class="space-y-6">
                    <div>
                        <InputLabel for="email" value="Email" class="text-[#002642]" />
                        <TextInput
                            id="email"
                            type="email"
                            class="mt-1 block w-full rounded-lg border-gray-300 focus:border-[#22668D] focus:ring-[#22668D]"
                            v-model="form.email"
                            required
                            autofocus
                            autocomplete="username"
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div>
                        <PrimaryButton
                            class="bg-[#22668D] hover:bg-[#002642] text-white font-semibold py-2 px-4 rounded-lg transition"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            Email Password Reset Link
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </GuestLayout>
</template>

