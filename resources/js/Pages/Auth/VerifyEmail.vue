<script setup>
import { computed } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    status: {
        type: String,
    },
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(
    () => props.status === 'verification-link-sent',
);
</script>

<template>
    <GuestLayout>
        <Head title="Verify Email" />

        <div class="grid grid-cols-1 lg:grid-cols-2 min-h-screen w-full bg-white">
            <!-- Left Panel -->
            <div class="hidden lg:flex flex-col justify-center items-center bg-gradient-to-br from-[#002642] via-[#22668D] to-[#6EA8DA] text-white p-10">
                <h1 class="text-4xl font-bold mb-4">Verify your email</h1>
                <p class="text-lg text-white/80 text-center max-w-xs">
                    Click the link we just sent to your inbox to verify your email address.
                </p>
            </div>

            <!-- Right Panel -->
            <div class="flex flex-col justify-center p-8 sm:p-12 w-full max-w-md mx-auto">
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold text-[#002642]">Email Verification</h2>
                    <p class="text-sm text-gray-600 mt-1">
                        We’ve sent a link to your email. Didn’t get it? Request another below.
                    </p>
                </div>

                <div
                    v-if="verificationLinkSent"
                    class="mb-4 text-sm font-medium text-green-600 text-center"
                >
                    A new verification link has been sent to your email.
                </div>

                <form @submit.prevent="submit" class="space-y-6">
                    <PrimaryButton
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        class="w-full bg-[#22668D] hover:bg-[#002642] text-white font-semibold py-2 px-4 rounded-lg transition"
                    >
                        Resend Verification Email
                    </PrimaryButton>

                    <div class="text-center">
                        <Link
                            :href="route('logout')"
                            method="post"
                            as="button"
                            class="text-sm text-[#22668D] hover:underline"
                        >
                            Log Out
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    </GuestLayout>
</template>

