<template>

    <div class="w-full min-h-32 max-w-[400px] dark:bg-gray-900 dark:text-gray-100 border dark:border-0 mx-auto relative rounded-md hover:shadow-xl cursor-pointer duration-200">
        <span
            class="bg-blue-600 text-white px-2 py-1 absolute top-0 right-0 text-xs  md:tex t-sm rounded-bl-md">New</span>
        <div class="overflow-hidden p-1 rounded-md">
            <img :src="props.content.image" :alt="props.content.name" loading="lazy" class="w-full h-72 bg-gray-200 flex flex-col justify-between bg-cover bg-center" style="color: transparent;">

        </div>
        <div class="px-4 py-3">
            <h5 class="text-base font-semibold "> {{ props.content.title }}</h5>
            <h5 class="text-base font-semibold "> {{ props.content.category }}</h5>
            <h5 class="text-base font-semibold "> {{ props.content.subcategory }}</h5>
            <p class="text-left text-xs font-semibold flex gap-2 my-2"><del
                    class="text-gray-500">Rs. {{ props.content.buy_price }}</del><span>Rs. {{ props.content.price }}</span></p>
            <div class="text-xs flex mt-1">
                <button class="flex items-center px-2 py-1  bg-blue-600 border-2 border-blue-600 hover:bg-transparent rounded text-white hover:text-inherit" title="Add to cart" @click="addToCart(props.content.id)">  <i class="pi pi-cart-plus"></i> </button>

                    <button class="flex items-center px-2 py-1 mx-2 bg-blue-600 border-2 border-blue-600 hover:bg-transparent rounded text-white hover:text-inherit" title="Add to Wishlist" @click="addToWishlist(props.content.id)">  <i class="pi pi-heart"></i> </button>

                    <router-link :to="'/product/'+ props.content.slug" class=" place-items-end px-2 py-1 bg-blue-600 border-2 border-blue-600 hover:bg-transparent rounded text-white hover:text-inherit">View </router-link>
            </div>
        </div>
    </div>
    
</template>

<script setup>
import { defineProps } from 'vue';
import useCartStore  from '@/stores/cart'

const props = defineProps(['content']);
const cartStore = useCartStore();

const addToCart = async (id) =>{
    cartStore.addCartItem(id);

    console.log('cart', id);
};

const addToWishlist = async(id) =>{
    console.log('wish', id);
};

</script>
