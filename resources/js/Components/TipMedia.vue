<script setup>
import { computed } from 'vue'
import { ThumbDownIcon } from '@heroicons/vue/solid'
import { ThumbUpIcon } from '@heroicons/vue/solid'
import { UserIcon } from '@heroicons/vue/solid'
import formatRelative from 'date-fns/formatRelative'

let props = defineProps({ tip: Object })

let createdAtRelativeTime = computed(() => {
    return formatRelative(new Date(props.tip.createdAt * 1000), new Date())
})

let displayName = computed(() => {
    return [props.tip.user.firstName, props.tip.user.lastName]
        .filter((part) => part)
        .join(' ')
})
</script>

<template>
    <div class="flex items-start border rounded-lg p-6">
        <img
            v-if="tip.photo"
            class="w-10 h-10 rounded-full object-cover"
            :src="`${tip.photo.prefix}256${tip.photo.suffix}`"
            :alt="`${displayName} photo`"
        />
        <span
            v-else
            class="w-10 h-10 rounded-full bg-gray-200 inline-flex items-center justify-center"
        >
            <UserIcon class="w-6 h-6 text-gray-500" />
        </span>
        <div class="flex-1 ml-6">
            <div class="flex items-center space-x-2">
                <span class="font-medium">{{ displayName }}</span>
                <span class="text-gray-400">•</span>
                <span>Added {{ createdAtRelativeTime }}</span>
            </div>
            <p class="text-gray-700 mt-2">{{ tip.text }}</p>
            <div class="flex items-center space-x-2 mt-4">
                <span
                    class="inline-flex items-center space-x-2 px-2 py-1 border rounded-lg"
                >
                    <ThumbUpIcon class="w-5 h-5 text-blue-500" />
                    <span class="font-medium text-sm">
                        {{ tip.agreeCount }}
                    </span>
                </span>
                <span
                    class="inline-flex items-center space-x-2 px-2 py-1 border rounded-lg"
                >
                    <ThumbDownIcon class="w-5 h-5 text-gray-500" />
                    <span class="font-medium text-sm">
                        {{ tip.disagreeCount }}
                    </span>
                </span>
            </div>
        </div>
    </div>
</template>
