<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    phone: '',
    country: 'RS', // Default
    passport_number: '',
    password: '',
    password_confirmation: '',
});

const countries = [
    { code: 'RS', name: 'Serbia (+381)' },
    { code: 'US', name: 'United States (+1)' },
    { code: 'CA', name: 'Canada (+1)' },
    { code: 'GB', name: 'United Kingdom (+44)' },
    { code: 'AU', name: 'Australia (+61)' },
    { code: 'IN', name: 'India (+91)' },
    { code: 'DE', name: 'Germany (+49)' },
    { code: 'FR', name: 'France (+33)' },
    { code: 'ES', name: 'Spain (+34)' },
    { code: 'IT', name: 'Italy (+39)' },
    { code: 'NL', name: 'Netherlands (+31)' },
    { code: 'NZ', name: 'New Zealand (+64)' },
    { code: 'ZA', name: 'South Africa (+27)' },
    { code: 'SG', name: 'Singapore (+65)' },
    { code: 'CN', name: 'China (+86)' },
    { code: 'JP', name: 'Japan (+81)' },
    { code: 'MX', name: 'Mexico (+52)' },
    { code: 'BR', name: 'Brazil (+55)' },
    { code: 'RU', name: 'Russia (+7)' },
    { code: 'KR', name: 'South Korea (+82)' },
    { code: 'SE', name: 'Sweden (+46)' },
    { code: 'AE', name: 'United Arab Emirates (+971)' },
    { code: 'SA', name: 'Saudi Arabia (+966)' },
    { code: 'NG', name: 'Nigeria (+234)' },
    { code: 'EG', name: 'Egypt (+20)' },
    { code: 'KE', name: 'Kenya (+254)' },
    { code: 'TR', name: 'Turkey (+90)' },
    { code: 'CH', name: 'Switzerland (+41)' },
    { code: 'IE', name: 'Ireland (+353)' },
    { code: 'BE', name: 'Belgium (+32)' },
    { code: 'FI', name: 'Finland (+358)' },
    { code: 'NO', name: 'Norway (+47)' },
    { code: 'DK', name: 'Denmark (+45)' },
    { code: 'AT', name: 'Austria (+43)' },
    { code: 'PT', name: 'Portugal (+351)' },
    { code: 'GR', name: 'Greece (+30)' },
    { code: 'AR', name: 'Argentina (+54)' },
    { code: 'CL', name: 'Chile (+56)' },
    { code: 'CO', name: 'Colombia (+57)' },
    { code: 'TH', name: 'Thailand (+66)' },
    { code: 'VN', name: 'Vietnam (+84)' },
    { code: 'MY', name: 'Malaysia (+60)' },
    { code: 'PH', name: 'Philippines (+63)' },
];


const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <div class="grid grid-cols-1 lg:grid-cols-2 min-h-screen w-full bg-white">
            <!-- Left Panel -->
            <div class="hidden lg:flex flex-col justify-center items-center bg-gradient-to-br from-[#002642] via-[#22668D] to-[#6EA8DA] text-white p-10">
                <h1 class="text-4xl font-bold mb-4">Create Account</h1>
                <p class="text-lg text-white/80 text-center max-w-xs">Join FuturaFly and start planning your journey with ease.</p>
            </div>

            <!-- Right Panel -->
            <div class="flex flex-col justify-center p-8 sm:p-12 w-full max-w-2xl mx-auto">
                <form @submit.prevent="submit" class="space-y-6">
                    <div class="text-center">
                        <h2 class="text-2xl font-bold text-[#002642]">Register</h2>
                        <p class="text-sm text-gray-500 mt-1">Fill in your details to get started.</p>
                    </div>

                    <div>
                        <InputLabel for="name" value="Name" class="text-[#002642]" />
                        <TextInput id="name" v-model="form.name" required autofocus autocomplete="name"
                                   class="mt-1 block w-full rounded-lg border-gray-300 focus:border-[#22668D] focus:ring-[#22668D]" />
                        <InputError :message="form.errors.name" class="mt-2" />
                    </div>

                    <div>
                        <InputLabel for="email" value="Email" class="text-[#002642]" />
                        <TextInput id="email" type="email" v-model="form.email" required autocomplete="email"
                                   class="mt-1 block w-full rounded-lg border-gray-300 focus:border-[#22668D] focus:ring-[#22668D]" />
                        <InputError :message="form.errors.email" class="mt-2" />
                    </div>

                    <div>
                        <InputLabel for="country" value="Country" class="text-[#002642]" />
                        <select id="country" v-model="form.country"
                                class="mt-1 block w-full rounded-lg border-gray-300 focus:border-[#22668D] focus:ring-[#22668D]">
                            <option v-for="country in countries" :key="country.code" :value="country.code">
                                {{ country.name }}
                            </option>
                        </select>
                        <InputError :message="form.errors.country" class="mt-2" />
                    </div>

                    <div>
                        <InputLabel for="phone" value="Phone Number" class="text-[#002642]" />
                        <TextInput id="phone" type="tel" v-model="form.phone" required autocomplete="tel"
                                   class="mt-1 block w-full rounded-lg border-gray-300 focus:border-[#22668D] focus:ring-[#22668D]" />
                        <InputError :message="form.errors.phone" class="mt-2" />
                    </div>

                    <div>
                        <InputLabel for="passport_number" value="Passport Number" class="text-[#002642]" />
                        <TextInput id="passport_number" v-model="form.passport_number" required
                                   class="mt-1 block w-full rounded-lg border-gray-300 focus:border-[#22668D] focus:ring-[#22668D]" />
                        <InputError :message="form.errors.passport_number" class="mt-2" />
                    </div>

                    <div>
                        <InputLabel for="password" value="Password" class="text-[#002642]" />
                        <TextInput id="password" type="password" v-model="form.password" required autocomplete="new-password"
                                   class="mt-1 block w-full rounded-lg border-gray-300 focus:border-[#22668D] focus:ring-[#22668D]" />
                        <InputError :message="form.errors.password" class="mt-2" />
                    </div>

                    <div>
                        <InputLabel for="password_confirmation" value="Confirm Password" class="text-[#002642]" />
                        <TextInput id="password_confirmation" type="password" v-model="form.password_confirmation" required
                                   class="mt-1 block w-full rounded-lg border-gray-300 focus:border-[#22668D] focus:ring-[#22668D]" />
                        <InputError :message="form.errors.password_confirmation" class="mt-2" />
                    </div>

                    <div class="flex justify-between items-center">
                        <Link :href="route('login')" class="text-sm text-[#22668D] hover:underline">
                            Already registered?
                        </Link>

                        <PrimaryButton :disabled="form.processing"
                                       class="bg-[#22668D] hover:bg-[#002642] text-white font-semibold py-2 px-6 rounded-lg transition">
                            Register
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </GuestLayout>
</template>

