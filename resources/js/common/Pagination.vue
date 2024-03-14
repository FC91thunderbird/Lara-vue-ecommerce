<!-- Pagination.vue -->

<template>
    <div
      class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
      <span class="flex items-center col-span-3"> Showing {{ from }} - {{ to }} of {{ records }} </span>
      <span class="col-span-2"></span>
      <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
        <nav aria-label="Table navigation">
          <ul class="inline-flex items-center">
            <li>
              <button class="px-3 py-1 rounded-md rounded-l-lg focus:outline-none focus:shadow-outline-purple"
                @click="prevPage" :disabled="currentPage === 1">&laquo;</button>
            </li>
            <li v-for="page in totalPages" :key="page">
              <button
                class="px-3 py-1 mr-1 text-white dark:text-gray-800 transition-colors duration-150  rounded-md focus:outline-none focus:shadow-outline-purple"
                :class="[page === currentPage ? 'bg-blue-600 dark:bg-blue-100' : 'bg-gray-500 dark:bg-gray-100']"
                @click="goToPage(page)"> {{ page }} </button>
            </li>
  
            <li>
              <button class="px-3 py-1 rounded-md rounded-r-lg focus:outline-none focus:shadow-outline-purple"
                @click="nextPage" :disabled="currentPage === totalPages">&raquo;</button>
            </li>
  
          </ul>
        </nav>
      </span>
    </div>
  </template>
  
  <script setup>
  import { defineProps, defineEmits } from 'vue'
  
  const { currentPage, totalPages, to, from, records } = defineProps(['currentPage', 'totalPages', 'to', 'from', 'records']);
  const emit = defineEmits();
  
  const prevPage = () => {
      emit('page-change', currentPage - 1);
  };
  const nextPage = () => {
    emit('page-change', currentPage + 1);
  };
  const goToPage = (page) => {
    emit('page-change', page);
  };
  </script>