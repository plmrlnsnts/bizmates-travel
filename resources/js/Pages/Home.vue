<script setup>
import SearchVenuesForm from '@/Components/SearchVenuesForm.vue'
import VenueCard from '@/Components/VenueCard.vue'
import WeatherButton from '@/Components/WeatherButton.vue'

defineProps({
    recommendations: Array,
    weather: Object,
})
</script>

<template>
    <div class="w-full max-w-4xl mx-auto px-6 py-12 space-y-12">
        <SearchVenuesForm />
        <WeatherButton :weather="weather" />
        <section v-for="(recommendation, i) in recommendations" :key="i">
            <h2 class="font-bold text-2xl tracking-tight">
                {{ recommendation.type }}
            </h2>
            <div class="mt-6 grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <VenueCard
                    v-for="item in recommendation.items"
                    :photos="item.photos"
                    :venue="item.venue"
                    :key="item.venue.id"
                />
            </div>
        </section>
    </div>
</template>
