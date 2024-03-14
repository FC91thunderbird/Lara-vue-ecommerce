<template>
  <div class="flex h-screen bg-gray-200 font-roboto">
    <!-- sidebar -->
    <Sidebar />
    <div class="flex-1 flex flex-col overflow-hidden">
      <Topbar />

      <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 bg-opacity-50">
        <div class="container mx-auto py-8">
          <slot />
        </div>
      </main>

      <Footer />
    </div>
  </div>
</template>

<script setup>
import Topbar from '@/components/admin/layouts/Topbar.vue';
import Sidebar from '@/components/admin/layouts/Sidebar.vue';
import Footer from '@/components/admin/layouts/Footer.vue';
</script>
