<script setup>
import { ArrowSmLeftIcon } from '@heroicons/vue/solid'
import { ClockIcon } from '@heroicons/vue/solid'
import { StarIcon } from '@heroicons/vue/solid'
import { ThumbUpIcon } from '@heroicons/vue/solid'
import TipMedia from '@/Components/TipMedia.vue'

defineProps({ venue: Object })
</script>

<template>
    <div class="w-full max-w-2xl mx-auto px-6 py-12">
        <InertiaLink
            :href="route('home')"
            class="inline-flex items-center space-x-2"
        >
            <ArrowSmLeftIcon class="w-5 h-5 text-gray-500" />
            <span class="text-gray-700 font-medium">Back</span>
        </InertiaLink>
        <h1 class="text-2xl font-semibold mt-4">{{ venue.name }}</h1>
        <p class="text-gray-700 mt-2">
            {{ venue.location.formattedAddress.join(', ') }}
        </p>
        <div class="flex flex-wrap mt-4">
            <span
                v-if="venue.defaultHours"
                class="inline-flex items-center space-x-2 px-2 py-1 border rounded-lg mr-2 mb-2"
            >
                <ClockIcon class="w-5 h-5 text-green-500" />
                <span class="font-medium">{{ venue.defaultHours.status }}</span>
            </span>
            <span
                class="inline-flex items-center space-x-2 px-2 py-1 border rounded-lg mr-2 mb-2"
            >
                <ThumbUpIcon class="w-5 h-5 text-blue-500" />
                <span class="font-medium">{{ venue.likes.count }}</span>
            </span>
            <span
                class="inline-flex items-center space-x-2 px-2 py-1 border rounded-lg mr-2 mb-2"
            >
                <StarIcon class="w-5 h-5 text-yellow-500" />
                <span class="font-medium">{{ venue.rating }}</span>
            </span>
        </div>
        <div class="relative pb-[75%] mt-6">
            <img
                class="absolute w-full h-full object-cover rounded-2xl"
                :src="`${venue.bestPhoto.prefix}original${venue.bestPhoto.suffix}`"
                :alt="`${venue.name} thumbnail`"
            />
        </div>
        <div v-if="venue.tips.groups[0]" class="mt-8 space-y-4">
            <TipMedia
                class="flex items-start"
                v-for="tip in venue.tips.groups[0].items"
                :tip="tip"
                :key="tip.id"
            />
        </div>
    </div>
</template>
