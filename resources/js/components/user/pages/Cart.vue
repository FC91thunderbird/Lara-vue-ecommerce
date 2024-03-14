<template>
    <userLayout>
        <div class="py-8">
            <div class="container mx-auto px-4">
                <h1 class="text-2xl font-semibold mb-4">Shopping Cart</h1>
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="md:w-3/4">
                        <div class="bg-white rounded-lg border shadow-md p-6 mb-4">

                            <table class="w-full">
                                <thead>
                                    <tr>
                                        <th class="text-left font-semibold">Product</th>
                                        <th class="text-left font-semibold">Price</th>
                                        <th class="text-left font-semibold">Quantity</th>
                                        <th class="text-left font-semibold">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- {{ cartStore.cartItems }} -->
                                    <tr v-for="cart in cartStore.cartItems" :key="cart.id">
                                        {{ cart.name }}
                                        <td class="py-4">
                                            <div class="flex items-center">
                                                <img class="h-16 w-16 mr-4 bg-gray-200 flex flex-col justify-between bg-cover bg-center" :src="'/'+ cart.image" :alt="cart.title" >
                                                <span class="font-semibold">{{ cart.title }}</span>
                                                <span class="font-semibold">{{ cart.category }}</span>
                                                <span class="font-semibold">{{ cart.subcategory }}</span>
                                            </div>
                                        </td>
                                        <td class="py-4">Rs. {{ cart.price }}</td>
                                        <td class="py-4">
                                            <div class="flex items-center">
                                                <button class="border rounded-md py-2 px-2 mr-2"  @click="cartStore.increment(cart.id,--cart.quantity)" :disabled="cart.quantity === 1">-</button>
                                                <span class="text-center w-8">{{ cart.quantity }}</span>
                                                <button class="border rounded-md py-2 px-2 ml-2" @click="cartStore.increment(cart.id, ++cart.quantity)">+</button>
                                            </div>
                                        </td>
                                        <td class="py-4">Rs. {{ cart.price * cart.quantity }}</td>
                                    </tr>
                                    <!-- More product rows -->
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="md:w-1/4">
                        <div class="bg-white rounded-lg border shadow-md p-6">
                            <h2 class="text-lg font-semibold mb-4">Summary</h2>
                            <div class="flex justify-between mb-2">
                                <span>Subtotal</span>
                                <span>--</span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span>Taxes</span>
                                <span>--</span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span>Shipping</span>
                                <span>--</span>
                            </div>
                            <hr class="my-2">
                            <div class="flex justify-between mb-2">
                                <span class="font-semibold">Total</span>
                                <span class="font-semibold">Rs. {{ cartStore.totalCost }}</span>
                            </div>
                            <router-link to="/checkout" class="bg-blue-500 text-white py-2 px-4 rounded-lg mt-4 w-full">Checkout</router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>

      
    </userLayout>
</template>

<script setup>
import useCartStore  from '@/stores/cart'
const cartStore = useCartStore();
</script>
