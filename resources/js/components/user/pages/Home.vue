<template>
    <div>
        <userLayout>
            <carousel :items-to-show="1" :autoplay="3000" :wrapAround="true" :transition="300">

                <slide v-for="slide in slider" :key="slide"
                    class="carousel-item inset-0 relative w-full h-500 transform transition-all duration-500 ease-in-out">
                    <img :src="slide" alt="">
                </slide>
                <template #addons>
                    <navigation />
                    <!-- <pagination /> -->
                </template>
            </carousel>

            <Heading title="All Categories" />


            <div
                class="relative container px-10 mx-auto w-full h-full md:h-auto grid grid-cols-1 md:grid-cols-5 gap-4 px-2 py-4">
                <Heading v-for="category in categories" :key="category.id" :content="category" />
            </div>


            <Heading title="Latest Products" />

            <div
                class="relative container px-10 mx-auto w-full h-full md:h-auto grid grid-cols-1 md:grid-cols-4 gap-6 py-5">

                <Products v-for="product in products" :key="product.id" :content="product" />

                <!-- item 3 -->
                <!-- <div class="mb-6 w-full bg-white rounded-lg shadow-lg border">
                    <div class="relative pb-40 ">
                        <a href="#" class="cursor-pointer">
                            <img class="absolute h-400 rounded-lg object-cover border-b shadow-lg cursor-pointer"
                                src="https://images.unsplash.com/photo-1461141346587-763ab02bced9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=600&q=80"
                                alt="product name" />
                        </a>
                    </div>

                    <div class="relative">
                        <div class="">
                            <div class="px-5 py-2">
                                <a class="text-gray-800 block truncate hover:underline font-medium text-lg" href="#">
                                    Beats Headsets - with a really long model name
                                </a>
                                <div class="flex justify-between items-center py-2">
                                    <div class="opacity-75 text-sm">
                                        <a class="hover:underline" href="#"> Category </a>
                                    </div>
                                    <span class="text-green-500 rounded-full bg-teal-200 px-3 py-1 text-xs">
                                        In Stock
                                    </span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <div class="opacity-75 text-sm">
                                        <a class="hover:underline" href="#"> SubCategory </a>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-between items-center px-4 pb-5">
                                <div>
                                    <div class="text-gray-800 text-lg">
                                        <span class="line-through opacity-75">$1500</span>
                                        <span class="font-medium">$1000</span>
                                    </div>
                                </div>

                                <div>
                                    <a class="btn-link flex items-center text-xs text-indigo-600 " href="#">
                                        <span class="text-white rounded-full bg-gray-500 px-3 py-2 mr-1 text-xs hover:bg-gray-300 hover:text-gray-700"> <i class="pi pi-cart-plus"></i> </span>

                                        <span class="text-white rounded-full bg-gray-500 px-3 py-2 text-xs hover:bg-gray-300 hover:text-gray-700"> <i class="pi pi-heart"></i> </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->

            </div>



        </userLayout>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import Heading from '@/components/user/layouts/Heading.vue';
import Products from '@/components/user/layouts/Products.vue';
import ApiService from '@/services/ApiService';

import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel'

const categories = ref([]);
const products = ref([]);

onMounted(()=>{
    fetchCategoryAndProducts();
});

const fetchCategoryAndProducts = async()=>{
    try {
        let response = await ApiService.get('/api/category_products');
        if(response.success){
            categories.value = response.data.categories;
            products.value = response.data.products;
        }else{
            console.log(response.message);
        }
    } catch (error) {
        console.log(error);
    }
}

const slider = ref(['https://www.ballonfahren.ch/images/Slideshow/en/slider-panorama-see.jpg', 'https://www.ballonfahren.ch/images/Slideshow/en/Take-Off-Seeland-2023.jpg', 'https://www.ballonfahren.ch/images/Slideshow/en/Take-Off-Balloon-AG-Slider-Aarebier.jpg']);


</script>
