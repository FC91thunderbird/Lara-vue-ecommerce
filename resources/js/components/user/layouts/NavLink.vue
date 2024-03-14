<template>
    <li class="w-full">
      <router-link
        class="md:px-4 py-2 text-sm bg-transparent rounded-lg text-gray-100 hover:text-gray-300 focus:outline-none focus:shadow-outline"
        :to="url"
      >
        {{ name }}
      </router-link>
    </li>
  </template>
  
  <script setup>
  import { defineProps } from 'vue';

  const { name, url } = defineProps(['name', 'url']);
  </script>
  