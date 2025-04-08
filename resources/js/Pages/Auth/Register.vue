<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import axios from 'axios';
import debounce from 'lodash/debounce';

const form = useForm({
    name: '',
    email: '',
    phone: '',
    country: 'RS',
    passport_number: '',
    password: '',
    password_confirmation: '',
});

const validationErrors = ref({
    name: '',
    email: '',
    phone: '',
    passport_number: '',
    password: '',
    password_confirmation: '',
});

// Live Validation
watch(() => form.name, (val) => {
    if (!val.trim()) {
        validationErrors.value.name = 'Name is required.';
    } else if (val.trim().length < 3) {
        validationErrors.value.name = 'Name must be at least 3 characters.';
    } else {
        validationErrors.value.name = '';
    }
});

watch(() => form.email, debounce(async (email) => {
    validationErrors.value.email = '';

    if (!email) {
        validationErrors.value.email = 'Email is required.';
    } else if (!/^\S+@\S+\.\S+$/.test(email)) {
        validationErrors.value.email = 'Enter a valid email.';
    } else {
        try {
            const res = await axios.post('/validate-email', { email });
            if (res.data.exists) {
                validationErrors.value.email = 'Email is already taken.';
            }
        } catch {
            validationErrors.value.email = 'Could not validate email.';
        }
    }
}, 500));

watch(() => form.phone, (val) => {
    validationErrors.value.phone = val.trim() ? '' : 'Phone number is required.';
});

watch(() => form.passport_number, (val) => {
    validationErrors.value.passport_number = val.trim() ? '' : 'Passport number is required.';
});

watch(() => form.password, (val) => {
    validationErrors.value.password = '';
    if (!val) {
        validationErrors.value.password = 'Password is required.';
    } else if (val.length < 6) {
        validationErrors.value.password = 'Password must be at least 6 characters.';
    }
});

watch([() => form.password, () => form.password_confirmation], ([password, confirm]) => {
    validationErrors.value.password_confirmation =
        confirm !== password ? 'Passwords do not match.' : '';
});

const countries = [
    { code: 'RS', name: 'Serbia (+381)' },
    { code: 'US', name: 'United States (+1)' },
    { code: 'AF', name: 'Afghanistan (+93)' },
    { code: 'AL', name: 'Albania (+355)' },
    { code: 'DZ', name: 'Algeria (+213)' },
    { code: 'AS', name: 'American Samoa (+1-684)' },
    { code: 'AD', name: 'Andorra (+376)' },
    { code: 'AO', name: 'Angola (+244)' },
    { code: 'AI', name: 'Anguilla (+1-264)' },
    { code: 'AQ', name: 'Antarctica (+672)' },
    { code: 'AG', name: 'Antigua and Barbuda (+1-268)' },
    { code: 'AR', name: 'Argentina (+54)' },
    { code: 'AM', name: 'Armenia (+374)' },
    { code: 'AW', name: 'Aruba (+297)' },
    { code: 'AU', name: 'Australia (+61)' },
    { code: 'AT', name: 'Austria (+43)' },
    { code: 'AZ', name: 'Azerbaijan (+994)' },
    { code: 'BS', name: 'Bahamas (+1-242)' },
    { code: 'BH', name: 'Bahrain (+973)' },
    { code: 'BD', name: 'Bangladesh (+880)' },
    { code: 'BB', name: 'Barbados (+1-246)' },
    { code: 'BY', name: 'Belarus (+375)' },
    { code: 'BE', name: 'Belgium (+32)' },
    { code: 'BZ', name: 'Belize (+501)' },
    { code: 'BJ', name: 'Benin (+229)' },
    { code: 'BM', name: 'Bermuda (+1-441)' },
    { code: 'BT', name: 'Bhutan (+975)' },
    { code: 'BO', name: 'Bolivia (+591)' },
    { code: 'BA', name: 'Bosnia and Herzegovina (+387)' },
    { code: 'BW', name: 'Botswana (+267)' },
    { code: 'BR', name: 'Brazil (+55)' },
    { code: 'BN', name: 'Brunei (+673)' },
    { code: 'BG', name: 'Bulgaria (+359)' },
    { code: 'BF', name: 'Burkina Faso (+226)' },
    { code: 'BI', name: 'Burundi (+257)' },
    { code: 'KH', name: 'Cambodia (+855)' },
    { code: 'CM', name: 'Cameroon (+237)' },
    { code: 'CA', name: 'Canada (+1)' },
    { code: 'CV', name: 'Cape Verde (+238)' },
    { code: 'CF', name: 'Central African Republic (+236)' },
    { code: 'TD', name: 'Chad (+235)' },
    { code: 'CL', name: 'Chile (+56)' },
    { code: 'CN', name: 'China (+86)' },
    { code: 'CO', name: 'Colombia (+57)' },
    { code: 'KM', name: 'Comoros (+269)' },
    { code: 'CD', name: 'Congo (DRC) (+243)' },
    { code: 'CG', name: 'Congo (Republic) (+242)' },
    { code: 'CR', name: 'Costa Rica (+506)' },
    { code: 'HR', name: 'Croatia (+385)' },
    { code: 'CU', name: 'Cuba (+53)' },
    { code: 'CY', name: 'Cyprus (+357)' },
    { code: 'CZ', name: 'Czech Republic (+420)' },
    { code: 'DK', name: 'Denmark (+45)' },
    { code: 'DJ', name: 'Djibouti (+253)' },
    { code: 'DM', name: 'Dominica (+1-767)' },
    { code: 'DO', name: 'Dominican Republic (+1-809)' },
    { code: 'EC', name: 'Ecuador (+593)' },
    { code: 'EG', name: 'Egypt (+20)' },
    { code: 'SV', name: 'El Salvador (+503)' },
    { code: 'GQ', name: 'Equatorial Guinea (+240)' },
    { code: 'ER', name: 'Eritrea (+291)' },
    { code: 'EE', name: 'Estonia (+372)' },
    { code: 'SZ', name: 'Eswatini (+268)' },
    { code: 'ET', name: 'Ethiopia (+251)' },
    { code: 'FJ', name: 'Fiji (+679)' },
    { code: 'FI', name: 'Finland (+358)' },
    { code: 'FR', name: 'France (+33)' },
    { code: 'GA', name: 'Gabon (+241)' },
    { code: 'GM', name: 'Gambia (+220)' },
    { code: 'GE', name: 'Georgia (+995)' },
    { code: 'DE', name: 'Germany (+49)' },
    { code: 'GH', name: 'Ghana (+233)' },
    { code: 'GR', name: 'Greece (+30)' },
    { code: 'GD', name: 'Grenada (+1-473)' },
    { code: 'GT', name: 'Guatemala (+502)' },
    { code: 'GN', name: 'Guinea (+224)' },
    { code: 'GW', name: 'Guinea-Bissau (+245)' },
    { code: 'GY', name: 'Guyana (+592)' },
    { code: 'HT', name: 'Haiti (+509)' },
    { code: 'HN', name: 'Honduras (+504)' },
    { code: 'HK', name: 'Hong Kong (+852)' },
    { code: 'HU', name: 'Hungary (+36)' },
    { code: 'IS', name: 'Iceland (+354)' },
    { code: 'IN', name: 'India (+91)' },
    { code: 'ID', name: 'Indonesia (+62)' },
    { code: 'IR', name: 'Iran (+98)' },
    { code: 'IQ', name: 'Iraq (+964)' },
    { code: 'IE', name: 'Ireland (+353)' },
    { code: 'IL', name: 'Israel (+972)' },
    { code: 'IT', name: 'Italy (+39)' },
    { code: 'JM', name: 'Jamaica (+1-876)' },
    { code: 'JP', name: 'Japan (+81)' },
    { code: 'JO', name: 'Jordan (+962)' },
    { code: 'KZ', name: 'Kazakhstan (+7)' },
    { code: 'KE', name: 'Kenya (+254)' },
    { code: 'KI', name: 'Kiribati (+686)' },
];

const submit = () => {
    form.clearErrors();
    if (Object.values(validationErrors.value).some(msg => msg)) return;

    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />
        <div class="grid grid-cols-1 lg:grid-cols-2 min-h-screen w-full bg-white">
            <div class="hidden lg:flex flex-col justify-center items-center bg-gradient-to-br from-[#002642] via-[#22668D] to-[#6EA8DA] text-white p-10">
                <h1 class="text-4xl font-bold mb-4">Create Account</h1>
                <p class="text-lg text-white/80 text-center max-w-xs">Join FuturaFly and start planning your journey with ease.</p>
            </div>

            <div class="flex flex-col justify-center p-8 sm:p-12 w-full max-w-2xl mx-auto">
                <form @submit.prevent="submit" class="space-y-6">
                    <div class="text-center">
                        <h2 class="text-2xl font-bold text-[#002642]">Register</h2>
                        <p class="text-sm text-gray-500 mt-1">Fill in your details to get started.</p>
                    </div>

                    <div>
                        <InputLabel for="name" value="Name" class="text-[#002642]" />
                        <TextInput
                            id="name"
                            v-model="form.name"
                            :class="[
                                'mt-1 block w-full rounded-lg transition',
                                validationErrors.name ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-[#22668D] focus:ring-[#22668D]'
                            ]"
                        />
                        <InputError :message="validationErrors.name || form.errors.name" class="mt-2" />
                    </div>

                    <div>
                        <InputLabel for="email" value="Email" class="text-[#002642]" />
                        <TextInput
                            id="email"
                            type="email"
                            v-model="form.email"
                            :class="[
                                'mt-1 block w-full rounded-lg transition',
                                validationErrors.email ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-[#22668D] focus:ring-[#22668D]'
                            ]"
                        />
                        <InputError :message="validationErrors.email || form.errors.email" class="mt-2" />
                    </div>

                    <div>
                        <InputLabel for="country" value="Country" class="text-[#002642]" />
                        <select
                            id="country"
                            v-model="form.country"
                            class="mt-1 block w-full rounded-lg border-gray-300 focus:border-[#22668D] focus:ring-[#22668D]"
                        >
                            <option v-for="country in countries" :key="country.code" :value="country.code">
                                {{ country.name }}
                            </option>
                        </select>
                        <InputError :message="form.errors.country" class="mt-2" />
                    </div>

                    <div>
                        <InputLabel for="phone" value="Phone Number" class="text-[#002642]" />
                        <TextInput
                            id="phone"
                            type="tel"
                            v-model="form.phone"
                            :class="[
                                'mt-1 block w-full rounded-lg transition',
                                validationErrors.phone ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-[#22668D] focus:ring-[#22668D]'
                            ]"
                        />
                        <InputError :message="validationErrors.phone || form.errors.phone" class="mt-2" />
                    </div>

                    <div>
                        <InputLabel for="passport_number" value="Passport Number" class="text-[#002642]" />
                        <TextInput
                            id="passport_number"
                            v-model="form.passport_number"
                            :class="[
                                'mt-1 block w-full rounded-lg transition',
                                validationErrors.passport_number ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-[#22668D] focus:ring-[#22668D]'
                            ]"
                        />
                        <InputError :message="validationErrors.passport_number || form.errors.passport_number" class="mt-2" />
                    </div>

                    <div>
                        <InputLabel for="password" value="Password" class="text-[#002642]" />
                        <TextInput
                            id="password"
                            type="password"
                            v-model="form.password"
                            autocomplete="new-password"
                            :class="[
                                'mt-1 block w-full rounded-lg transition',
                                validationErrors.password ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-[#22668D] focus:ring-[#22668D]'
                            ]"
                        />
                        <InputError :message="validationErrors.password || form.errors.password" class="mt-2" />
                    </div>

                    <div>
                        <InputLabel for="password_confirmation" value="Confirm Password" class="text-[#002642]" />
                        <TextInput
                            id="password_confirmation"
                            type="password"
                            v-model="form.password_confirmation"
                            :class="[
                                'mt-1 block w-full rounded-lg transition',
                                validationErrors.password_confirmation ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-[#22668D] focus:ring-[#22668D]'
                            ]"
                        />
                        <InputError :message="validationErrors.password_confirmation || form.errors.password_confirmation" class="mt-2" />
                    </div>

                    <div class="flex justify-between items-center">
                        <Link :href="route('login')" class="text-sm text-[#22668D] hover:underline">
                            Already registered?
                        </Link>
                        <PrimaryButton
                            :disabled="form.processing"
                            class="bg-[#22668D] hover:bg-[#002642] text-white font-semibold py-2 px-6 rounded-lg transition"
                        >
                            Register
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </GuestLayout>
</template>
