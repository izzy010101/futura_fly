<script setup>
import { ref, watch } from 'vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import debounce from 'lodash/debounce';
import axios from 'axios';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

defineProps({
    mustVerifyEmail: Boolean,
    status: String,
});

const user = usePage().props.auth.user;

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

const form = useForm({
    name: user.name,
    email: user.email,
    country: '',
    phone: user.phone,
    passport_number: user.passport_number,
});



const validationErrors = ref({
    name: '',
    email: '',
    country: '',
    phone: '',
    passport_number: '',
});

// Live validation
watch(() => form.name, (val) => {
    validationErrors.value.name = val.trim().length < 3 ? 'Name must be at least 3 characters.' : '';
});

watch(() => form.email, debounce(async (email) => {
    validationErrors.value.email = '';
    if (!email) {
        validationErrors.value.email = 'Email is required.';
        return;
    }
    if (!/^\S+@\S+\.\S+$/.test(email)) {
        validationErrors.value.email = 'Invalid email format.';
        return;
    }
    if (email !== user.email) {
        const res = await axios.post('/validate-email', { email });
        validationErrors.value.email = res.data.exists ? 'Email already exists.' : '';
    }
}, 500));

watch(() => form.phone, (val) => {
    validationErrors.value.phone = val.trim() ? '' : 'Phone number is required.';
});

watch(() => form.passport_number, (val) => {
    validationErrors.value.passport_number = val.trim() ? '' : 'Passport number is required.';
});

const submit = () => {
    if (Object.values(validationErrors.value).some(err => err !== '')) return;
    form.patch(route('profile.update'));
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                Profile Information
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                Update your account's profile information.
            </p>
        </header>

        <form @submit.prevent="submit" class="mt-6 space-y-6">
            <div>
                <InputLabel for="name" value="Name" />
                <TextInput
                    id="name"
                    v-model="form.name"
                    class="mt-1 block w-full"
                    :class="{ 'border-red-500': validationErrors.name || form.errors.name }"
                    autofocus
                />
                <InputError :message="validationErrors.name || form.errors.name" class="mt-2" />
            </div>

            <div>
                <InputLabel for="email" value="Email" />
                <TextInput
                    id="email"
                    type="email"
                    v-model="form.email"
                    class="mt-1 block w-full"
                    :class="{ 'border-red-500': validationErrors.email || form.errors.email }"
                />
                <InputError :message="validationErrors.email || form.errors.email" class="mt-2" />
            </div>

<!--            country codes-->
            <div>
                <InputLabel for="country" value="Country Code" class="text-[#002642]" />
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
                <InputLabel for="phone" value="Phone" />
                <TextInput
                    id="phone"
                    type="text"
                    v-model="form.phone"
                    class="mt-1 block w-full"
                    :class="{ 'border-red-500': validationErrors.phone || form.errors.phone }"
                />
                <InputError :message="validationErrors.phone || form.errors.phone" class="mt-2" />
            </div>

            <div>
                <InputLabel for="passport_number" value="Passport Number" />
                <TextInput
                    id="passport_number"
                    v-model="form.passport_number"
                    class="mt-1 block w-full"
                    :class="{ 'border-red-500': validationErrors.passport_number || form.errors.passport_number }"
                />
                <InputError :message="validationErrors.passport_number || form.errors.passport_number" class="mt-2" />
            </div>



            <div v-if="mustVerifyEmail && !user.email_verified_at">
                <p class="mt-2 text-sm text-gray-800">
                    Your email address is unverified.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="text-sm text-gray-600 underline hover:text-gray-900"
                    >
                        Click here to re-send the verification email.
                    </Link>
                </p>
                <div v-show="status === 'verification-link-sent'" class="mt-2 text-sm text-green-600">
                    A new verification link has been sent.
                </div>
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>
                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
