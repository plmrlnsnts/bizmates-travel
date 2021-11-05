<script setup>
import { ChevronRightIcon } from '@heroicons/vue/outline'
import WeatherIcon from '@/Components/WeatherIcon.vue'

defineProps({ weather: Object })
</script>

<template>
    <a
        :href="`https://openweathermap.org/city/${weather.id}`"
        class="border border-gray-300 p-6 flex items-center rounded-2xl transition shadow-sm hover:shadow-md"
        target="_blank"
        rel="noopener noreferrer"
    >
        <WeatherIcon
            :description="weather.weather[0].description"
            class="flex-none"
        />
        <div class="flex-1 px-6">
            <h2 class="font-bold text-lg lg:text-xl">
                {{ $page.props.request.near || 'Kyoto' }}, Japan
            </h2>
            <p class="text-lg">
                <span class="capitalize">
                    {{ weather.weather[0].description }}
                </span>
                <span>, {{ weather.main.temp }} °C</span>
            </p>
        </div>
        <ChevronRightIcon class="flex-none w-8 h-8 text-gray-300" />
    </a>
</template>
