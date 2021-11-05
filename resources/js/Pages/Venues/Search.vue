<script setup>
import { ArrowSmLeftIcon } from '@heroicons/vue/solid'
import VenueCard from '@/Components/VenueCard.vue'

defineProps({
    request: Object,
    venues: Array,
})
</script>

<template>
    <div class="w-full max-w-4xl mx-auto px-6 py-12">
        <InertiaLink :href="route('home')" class="inline-flex items-center space-x-2">
            <ArrowSmLeftIcon class="w-5 h-5 text-gray-500" />
            <span class="text-gray-700 font-medium">Back</span>
        </InertiaLink>
        <h2 class="font-bold text-2xl tracking-tight mt-4">
            Search results for "{{ request.query }}"
        </h2>
        <div class="mt-12 grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <VenueCard
                v-for="venue in venues"
                :photos="venue.photos"
                :venue="venue"
                :key="venue.id"
            />
        </div>
    </div>
</template>
