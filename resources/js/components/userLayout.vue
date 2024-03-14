<template>
    <div class="min-h-screen font-sans antialiased relative">
        <div class="relative">
            <div class="absolute top-0 left-0 w-full  cover-gradient-2 sm:cover-gradient">  <!-- h-[125vh] sm:h-[225vh] lg:h-[125vh] -->
            </div>
            <Navbar />

            <main class="text-neutral-800">
                <slot />
            </main>
            <Footer />
        </div>
    </div>
</template>

<script setup>
import Navbar from './user/layouts/Navbar.vue';
import Footer from './user/layouts/Footer.vue';

</script>
