<template>
    <div class="text-center py-5 px-5" v-if="props.title">
        <span
            class="inline-block py-1 px-3 mb-4 text-sm font-semibold text-orange-900 bg-orange-50 rounded-full">Latest</span>
        <h1 class="font-heading text-lg xs:text-lg md:text-5xl font-bold text-gray-900">
            {{ props.title }}
        </h1>
    </div>

    <div v-if="props.content"
        class="w-full min-h-32 max-w-[400px] dark:bg-gray-900 dark:text-gray-100 border dark:border-0 mx-auto relative rounded-md hover:shadow-xl cursor-pointer duration-200">
        <span
            class="bg-blue-600 text-white px-2 py-1 absolute top-0 right-0 text-xs  md:tex t-sm rounded-bl-md">New</span>
        <router-link :to="'category/' + props.content.slug">
            <div class="overflow-hidden p-1 rounded-md">
                <img :src="props.content.image" :alt="props.content.name" loading="lazy"
                    class="h-32 w-full bg-gray-200 flex flex-col justify-between bg-cover bg-center"
                    style="color: transparent;">
            </div>
            <div class="px-2 py-3">
                <h5 class="text-base font-semibold text-center"> {{ props.content.name }}</h5>
            </div>
        </router-link>
    </div>
</template>

<script setup>
import { defineProps } from 'vue';

const props = defineProps(['title', 'content']);
</script>