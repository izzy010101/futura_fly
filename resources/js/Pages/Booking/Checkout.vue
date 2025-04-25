<script setup>
import { ref } from 'vue'
import { ethers } from 'ethers'
import { escrowABI } from '@/abi/escrowABI.js'
import { Head, router } from '@inertiajs/vue3'
import HeaderComponent from '@/Components/HeaderComponent.vue'
import Footer from '@/Components/Footer.vue'
import { ArrowLeftIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
    auth: Object,
    booking: Object,
})

const goBack = () => router.visit(route('dashboard'));

// escrow contract address validation
const escrowAddress = props.booking.escrow_contract_address;
const connected = ref(false)
const status = ref('')
const buyerAddress = ref('')
const contractAddress = ref('')

if (!escrowAddress) {
    status.value = "⚠️ No escrow contract address available for this booking.";
    console.error("Escrow contract address is not available");
} else {
    // Only proceed if the escrow address is valid
    contractAddress.value = ethers.getAddress(escrowAddress);
    console.log("Escrow contract address:", contractAddress.value);
}

const connectWallet = async () => {
    try {
        if (typeof window.ethereum !== 'undefined') {
            await window.ethereum.request({
                method: 'wallet_requestPermissions',
                params: [{ eth_accounts: {} }]
            });

            const accounts = await window.ethereum.request({
                method: 'eth_requestAccounts'
            });

            if (accounts.length > 0) {
                connected.value = true;
                buyerAddress.value = accounts[0];
                status.value = `Wallet connected ✅ (${buyerAddress.value})`;
            } else {
                status.value = '⚠️ No accounts found';
            }
        } else {
            status.value = '⚠️ Please install MetaMask';
        }
    } catch (err) {
        console.error(err);
        status.value = `❌ Wallet connection error: ${err.message}`;
    }
};

const sendCryptoPayment = async () => {
    // Check if buyerAddress is valid before making the payment
    if (!buyerAddress.value) {
        status.value = "⚠️ Please connect your wallet.";
        return;
    }

    // Ensure contract address is available before proceeding
    if (!contractAddress.value) {
        status.value = "⚠️ No escrow contract address available.";
        return;
    }

    try {
        const provider = new ethers.BrowserProvider(window.ethereum);
        const signer = await provider.getSigner();

        const tx = await signer.sendTransaction({
            to: contractAddress.value,
            value: ethers.parseEther('0.05') // Adjust based on your flight price or calculation
        });

        status.value = '⏳ Waiting for transaction confirmation...';
        await tx.wait();
        status.value = '✅ Payment sent successfully!';
    } catch (err) {
        console.error(err);
        status.value = `❌ Error: ${err.message}`;
    }
};

const confirmDelivery = async () => {
    // Ensure contract address is available before confirming delivery
    if (!contractAddress.value) {
        status.value = "⚠️ No escrow contract address available for confirmation.";
        return;
    }

    try {
        const provider = new ethers.BrowserProvider(window.ethereum)
        const signer = await provider.getSigner()
        const contract = new ethers.Contract(contractAddress.value, escrowABI, signer)

        const tx = await contract.confirmDelivery()
        status.value = '⏳ Confirming delivery...'
        await tx.wait()
        status.value = '✅ Delivery confirmed and ETH released!'
    } catch (err) {
        console.error(err)
        status.value = `❌ Error confirming delivery: ${err.message}`
    }
}
</script>



<template>
    <Head title="Checkout"/>
    <div class="min-h-screen flex flex-col">
        <HeaderComponent :auth="auth"/>

        <main class="flex-1 px-6 py-10 max-w-4xl mx-auto">
            <button
                @click="goBack"
                class="flex items-center text-sm text-blue-600 hover:underline mb-6"
            >
                <ArrowLeftIcon class="w-4 h-4 mr-1"/>
                Back to Dashboard
            </button>

            <h1 class="text-2xl font-bold mb-4 text-[#002642] dark:text-white">
                Complete Your Payment
            </h1>

            <!-- Show contract address -->
            <p v-if="booking.escrow_contract_address">
                Escrow Contract Address: {{ booking.escrow_contract_address }}
            </p>
<!--            blockchain buttons-->
            <div class="space-x-2 mb-4">
                <button
                    class="bg-blue-600 text-white px-4 py-2 rounded"
                    @click="connectWallet"
                    :disabled="connected"
                >
                    Connect Wallet
                </button>

                <button
                    class="bg-green-600 text-white px-4 py-2 rounded"
                    @click="sendCryptoPayment"
                    :disabled="!connected"
                >
                    Pay with Crypto (≈{{ (booking.price * 0.01).toFixed(2) }} tAP3X)
                </button>

                <button
                    class="bg-yellow-500 text-white px-4 py-2 rounded"
                    @click="confirmDelivery"
                    :disabled="!connected"
                >
                    Confirm Delivery
                </button>
            </div>

            <p class="text-gray-700 dark:text-gray-300">{{ status }}</p>
        </main>

        <Footer/>
    </div>
</template>
