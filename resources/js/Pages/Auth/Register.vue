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
    country: 'US', // Default
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

        <form @submit.prevent="submit">

            <div>
                <InputLabel for="name" value="Name" />
                <TextInput id="name" v-model="form.name" required autofocus autocomplete="name" />
                <InputError :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email" />
                <TextInput id="email" type="email" v-model="form.email" required autocomplete="email" />
                <InputError :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="country" value="Country" />
                <select id="country" v-model="form.country" class="border-gray-300 rounded w-full">
                    <option v-for="country in countries" :key="country.code" :value="country.code">
                        {{ country.name }}
                    </option>
                </select>
                <InputError :message="form.errors.country" />
            </div>

            <div class="mt-4">
                <InputLabel for="phone" value="Phone Number" />
                <TextInput id="phone" type="tel" v-model="form.phone" required autocomplete="tel" />
                <InputError :message="form.errors.phone" />
            </div>

            <div class="mt-4">
                <InputLabel for="passport_number" value="Passport Number" />
                <TextInput id="passport_number" v-model="form.passport_number" required />
                <InputError :message="form.errors.passport_number" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />
                <TextInput id="password" type="password" v-model="form.password" required autocomplete="new-password" />
                <InputError :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirm Password" />
                <TextInput id="password_confirmation" type="password" v-model="form.password_confirmation" required />
                <InputError :message="form.errors.password_confirmation" />
            </div>

            <div class="mt-4 flex justify-end">
                <Link :href="route('login')" class="text-sm text-gray-600 underline">Already registered?</Link>
                <PrimaryButton :disabled="form.processing" class="ml-4">Register</PrimaryButton>
            </div>

        </form>
    </GuestLayout>
</template>
