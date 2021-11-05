<script setup>
import { debounce } from 'lodash'
import { Inertia } from '@inertiajs/inertia'
import { ref, watch } from 'vue'
import { SearchIcon } from '@heroicons/vue/outline'
import { useForm } from '@inertiajs/inertia-vue3'
import { usePage } from '@inertiajs/inertia-vue3'
import axios from 'axios'

let page = usePage()
let suggestions = ref([])
let selectedSuggestion = ref(-1)
let showSuggestions = ref(false)

let cities = ['Kyoto', 'Nagoya', 'Osaka', 'Sapporo', 'Tokyo', 'Yokohama']
let form = useForm({
    query: page.props.value.request.query,
    near: page.props.value.request.near || 'Kyoto',
})

function selectSuggestion(i) {
    form.query = suggestions.value[i].name
    selectedSuggestion.value = -1
    showSuggestions.value = false
}

watch(
    () => form.near,
    () => Inertia.reload({ data: { near: form.near } })
)

watch(
    () => showSuggestions.value,
    () => (selectedSuggestion.value = -1)
)

watch(
    () => form.query,
    debounce(async (query) => {
        let params = { near: form.near, query }
        let response = await axios.get(route('venues.autocomplete'), { params })

        suggestions.value = response.data.suggestions
        selectedSuggestion.value = -1
    }, 300)
)
</script>

<template>
    <section class="relative">
        <h2 class="font-bold text-2xl tracking-tight">
            Where do you want to go?
        </h2>
        <form
            class="mt-6 relative flex flex-wrap shadow-sm rounded-2xl -space-y-px lg:space-y-0 lg:-space-x-px"
            @submit.prevent="form.get(route('venues.search'))"
        >
            <div
                class="w-full border border-gray-300 overflow-hidden rounded-t-2xl focus-within:z-10 focus-within:ring-2 focus-within:ring-blue-500 lg:w-56 lg:rounded-r-none lg:rounded-l-2xl"
            >
                <label
                    for="search-city"
                    class="inline-block text-sm font-medium text-gray-700 px-5 pt-3"
                >
                    Choose a city
                </label>
                <select
                    id="search-city"
                    class="block w-full px-5 pt-0 pb-3 border-0 text-lg font-medium focus:outline-none focus:ring-0"
                    v-model="form.near"
                >
                    <option v-for="city in cities" :key="city">
                        {{ city }}
                    </option>
                </select>
            </div>
            <div class="flex-1 relative">
                <div
                    class="h-full border border-gray-300 focus-within:z-10 focus-within:ring-2 focus-within:ring-blue-500"
                >
                    <label
                        for="search-location"
                        class="inline-block text-sm font-medium text-gray-700 px-5 pt-3"
                    >
                        Search location
                    </label>
                    <div class="relative">
                        <input
                            id="search-location"
                            class="block w-full px-5 pt-0 pb-3 border-0 text-lg font-medium focus:outline-none focus:ring-0"
                            placeholder="Destinations or activities"
                            v-model="form.query"
                            type="text"
                            @focus="showSuggestions = true"
                            @blur="showSuggestions = false"
                            @keydown.prevent.enter="
                                selectedSuggestion > -1
                                    ? selectSuggestion(selectedSuggestion)
                                    : form.get(route('venues.search'))
                            "
                            @keydown.prevent.down="
                                selectedSuggestion =
                                    selectedSuggestion < suggestions.length - 1
                                        ? selectedSuggestion + 1
                                        : 0
                            "
                            @keydown.prevent.up="
                                selectedSuggestion =
                                    selectedSuggestion > 0
                                        ? selectedSuggestion - 1
                                        : suggestions.length - 1
                            "
                        />
                    </div>
                </div>
                <transition
                    enter-active-class="transition duration-100 ease-out"
                    enter-from-class="transform scale-95 opacity-0"
                    enter-to-class="transform scale-100 opacity-100"
                    leave-active-class="transition duration-75 ease-in"
                    leave-from-class="transform scale-100 opacity-100"
                    leave-to-class="transform scale-95 opacity-0"
                >
                    <div
                        v-if="showSuggestions && suggestions.length"
                        class="mt-2 origin-top bg-white rounded-lg absolute isolate top-full w-full shadow-lg py-2 ring-1 ring-black/5 z-10"
                    >
                        <button
                            v-for="(suggestion, i) in suggestions"
                            @mousedown.prevent="selectSuggestion(i)"
                            tabindex="-1"
                            type="button"
                            class="block w-full text-left font-medium px-5 py-3 hover:bg-gray-100"
                            :class="{
                                'bg-blue-500 text-white hover:bg-blue-600':
                                    i === selectedSuggestion,
                            }"
                        >
                            {{ suggestion.name }}
                        </button>
                    </div>
                </transition>
            </div>
            <button
                class="w-full relative self-stretch pl-5 pr-7 py-3 rounded-b-2xl border border-blue-600 bg-blue-600 text-lg text-white font-semibold inline-flex items-center justify-center focus:z-10 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 lg:w-auto lg:rounded-l-none lg:rounded-r-2xl"
            >
                <SearchIcon class="w-6 h-6" />
                <span class="ml-3">Search</span>
            </button>
        </form>
    </section>
</template>
