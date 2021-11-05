<script setup>
import { CameraIcon } from '@heroicons/vue/outline'

defineProps({
    venue: Object,
    photos: Object,
})
</script>

<template>
    <div>
        <InertiaLink
            :href="route('venues.show', venue.id)"
            class="block rounded-xl overflow-hidden relative bg-gray-200 object-cover w-full pb-[100%]"
        >
            <img
                v-if="photos.items?.length"
                :src="`${photos.items[0].prefix}512${photos.items[0].suffix}`"
                :alt="`${venue.name} thumbnail`"
                class="absolute inset-0 w-full h-full transition hover:scale-105"
            />
            <div
                v-else
                class="absolute inset-0 flex flex-col items-center justify-center"
            >
                <CameraIcon class="w-10 h-10 text-gray-300" />
                <p class="font-medium text-gray-400 mt-4">No thumbnail</p>
            </div>
        </InertiaLink>
        <InertiaLink
            :href="route('venues.show', venue.id)"
            class="mt-4 font-medium block hover:underline lg:truncate"
        >
            {{ venue.name }}
        </InertiaLink>
        <p class="text-gray-700">
            {{ venue.location.city }},
            {{ venue.location.state }}
        </p>
    </div>
</template>
