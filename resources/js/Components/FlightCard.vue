<script setup>
import { Link } from '@inertiajs/vue3'

const props = defineProps({
    flight: Object,
    canBook: Boolean,
})

function formatDate(dateStr) {
    return new Date(dateStr).toLocaleDateString(undefined, {
        month: 'short',
        day: 'numeric',
        year: 'numeric'
    })
}

function formatTime(dateStr) {
    return new Date(dateStr).toLocaleTimeString([], {
        hour: '2-digit',
        minute: '2-digit'
    })
}

function calculateDuration(start, end) {
    const departure = new Date(start)
    const arrival = new Date(end)

    const diffMs = arrival - departure
    const hours = Math.floor(diffMs / 1000 / 60 / 60)
    const minutes = Math.floor((diffMs / 1000 / 60) % 60)

    return `${hours}h ${minutes < 10 ? '0' + minutes : minutes}m`
}
</script>
<template>
    <div class="flight-card-container h-full flex flex-col">
        <div class="flight-card flex flex-col flex-grow">
            <!-- Header -->
            <div class="card-header">
                <div class="flight-number">
                    <span class="label mr-2">Flight</span>
                    <span class="value">{{ flight.flight_number }}</span>
                </div>
                <div class="airline-logo">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round" class="plane-icon">
                        <path
                            d="M17.8 19.2L16 11l3.5-3.5C21 6 21.5 4 21 3c-1-.5-3 0-4.5 1.5L13 8 4.8 6.2c-.5-.1-.9.1-1.1.5l-.3.5c-.2.5-.1 1 .3 1.3L9 12l-2 3H4l-1 1 3 2 2 3 1-1v-3l3-2 3.5 5.3c.3.4.8.5 1.3.3l.5-.2c.4-.3.6-.7.5-1.2z" />
                    </svg>
                </div>
            </div>

            <!-- Route Info -->
            <div class="route-info">
                <div class="departure">
                    <div class="city">{{ flight.departure }}</div>
                    <div class="code">{{ flight.departure_airport || 'CDG' }}</div>
                </div>
                <div class="flight-path">
                    <div class="line"></div>
                    <div class="plane">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                             fill="currentColor" class="small-plane">
                            <path
                                d="M12 2c-5.5 0-10 4.5-10 10s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2zm0 16.5c-3.6 0-6.5-2.9-6.5-6.5S8.4 5.5 12 5.5s6.5 2.9 6.5 6.5-2.9 6.5-6.5 6.5z" />
                            <path
                                d="M12 7c-2.8 0-5 2.2-5 5s2.2 5 5 5 5-2.2 5-5-2.2-5-5-5zm0 8c-1.7 0-3-1.3-3-3s1.3-3 3-3 3 1.3 3 3-1.3 3-3 3z" />
                        </svg>
                    </div>
                    <div class="line"></div>
                </div>
                <div class="arrival">
                    <div class="city">{{ flight.destination }}</div>
                    <div class="code">{{ flight.destination_airport || 'DXB' }}</div>
                </div>
            </div>

            <!-- Time Info -->
            <div class="time-info">
                <div class="departure-time">
                    <div class="time">{{ formatTime(flight.departure_time) }}</div>
                    <div class="date">{{ formatDate(flight.departure_time) }}</div>
                </div>
                <div class="flight-duration">
                    <div class="duration">{{ calculateDuration(flight.departure_time, flight.arrival_time) }}</div>
                    <div class="direct">Direct</div>
                </div>
                <div class="arrival-time">
                    <div class="time">{{ formatTime(flight.arrival_time) }}</div>
                    <div class="date">{{ formatDate(flight.arrival_time) }}</div>
                </div>
            </div>

            <!-- Footer -->
            <div class="card-footer mt-auto">
                <div class="seats-available">
                    <svg xmlns="http://www.w3.org/2000/svg" class="seat-icon" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M6 17h12a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2Z" />
                        <path d="M6 7V5a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v2" />
                        <path d="M8 17v2" />
                        <path d="M16 17v2" />
                    </svg>
                    <span>{{ flight.seats_available }} seats available</span>
                </div>
                <div class="price-section">
                    <div class="price-label">Price</div>
                    <div class="price-value">${{ flight.price }}</div>
                    <button
                        v-if="canBook"
                        class="select-button"
                    >
                        Book
                    </button>

                    <!-- Guest: Link to login with same style -->
                    <Link
                        v-else
                        href="/login"
                        class="select-button opacity-50 cursor-not-allowed"
                    >
                        Login to Book
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.flight-card-container {
    font-family: 'Inter', sans-serif;
    height: 100%;
}

.flight-card {
    background-color: white;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    padding: 1.5rem;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    display: flex;
    flex-direction: column;
    height: 100%;
}

.flight-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    border-bottom: 1px solid #f0f0f0;
    padding-bottom: 1rem;
}

.flight-number .label {
    font-size: 0.75rem;
    color: #6b7280;
}

.flight-number .value {
    font-size: 1.25rem;
    font-weight: 700;
    color: #111827;
}

.airline-logo {
    background-color: #2c6c8e;
    width: 40px;
    height: 40px;
    border-radius: 9999px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.plane-icon {
    width: 24px;
    height: 24px;
    color: white;
}

.route-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.departure,
.arrival {
    flex: 1;
    text-align: center;
}

.city {
    font-size: 1.125rem;
    font-weight: 600;
    color: #111827;
}

.code {
    font-size: 0.875rem;
    color: #6b7280;
}

.flight-path {
    display: flex;
    align-items: center;
    flex: 2;
    padding: 0 1rem;
}

.line {
    flex: 1;
    height: 2px;
    background-color: #e5e7eb;
}

.plane {
    margin: 0 0.5rem;
    transform: rotate(90deg);
}

.small-plane {
    width: 20px;
    height: 20px;
    color: #2c6c8e;
}

.time-info {
    display: flex;
    justify-content: space-between;
    border-bottom: 1px solid #f0f0f0;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
}

.departure-time,
.arrival-time,
.flight-duration {
    flex: 1;
    text-align: center;
}

.time {
    font-size: 1rem;
    font-weight: 600;
    color: #111827;
}

.date {
    font-size: 0.75rem;
    color: #6b7280;
}

.duration {
    font-size: 0.875rem;
    font-weight: 600;
    color: #111827;
}

.direct {
    font-size: 0.75rem;
    color: #10b981;
    background-color: #d1fae5;
    padding: 0.125rem 0.5rem;
    border-radius: 9999px;
    display: inline-block;
    margin-top: 0.25rem;
}

.card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: auto;
}

.seats-available {
    display: flex;
    align-items: center;
    color: #6b7280;
    font-size: 0.875rem;
}

.seat-icon {
    width: 18px;
    height: 18px;
    margin-right: 0.5rem;
}

.price-section {
    display: flex;
    align-items: center;
}

.price-label {
    font-size: 0.75rem;
    color: #6b7280;
    margin-right: 0.5rem;
}

.price-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: #111827;
    margin-right: 1rem;
}

.select-button {
    background-color: #2c6c8e;
    color: white;
    border: none;
    border-radius: 6px;
    padding: 0.5rem 1.25rem;
    font-weight: 600;
    font-size: 0.875rem;
    cursor: pointer;
    transition: background-color 0.2s ease;
}

.select-button:hover {
    background-color: #235a78;
}

/* Responsive Tweaks */
@media (max-width: 640px) {
    .time-info {
        flex-direction: column;
        gap: 1rem;
    }

    .flight-duration {
        order: -1;
        margin-bottom: 0.5rem;
    }

    .card-footer {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }

    .price-section {
        width: 100%;
        justify-content: space-between;
    }
}
</style>
