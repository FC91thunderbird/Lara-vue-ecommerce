<template>
    <nav id="navbar" class="relative z-10 w-full text-neutral-800 bg-gray-500">
        <div class="flex flex-col max-w-screen-xl px-8 mx-auto lg:items-center lg:justify-between lg:flex-row">
            <div class="flex flex-col lg:flex-row items-center space-x-4 xl:space-x-8">
                <div class="w-full flex flex-row items-center justify-between py-6">
                    <div>
                        <img  class="w-24 xl:w-28" alt="Nefa Logo" />
                    </div>
                    <button class="rounded-lg lg:hidden focus:outline-none focus:shadow-outline" @click="open = !open">
                        <!-- <SegmentIcon v-if="!open" :size="24" />
                        <CloseIcon v-else :size="24" /> -->
                    </button>
                </div>
                <ul :class="[open ? 'flex' : 'hidden lg:flex']"
                    class="w-full h-auto flex flex-col flex-grow lg:items-center pb-4 lg:pb-0 lg:justify-end lg:flex-row origin-top duration-300 xl:space-x-2 space-y-3 lg:space-y-0">

                    <NavLink name="Home" url="/" />
                    <NavLink name="About" url="/about" />
                    <NavLink name="Shop" url="#" />
                    <NavLink name="NFT" url="#" />
                    <NavLink name="Dashboard" url="/admin/dashboard"  /> 
                    <!-- <li class="relative group">
                        <button
                            class="md:px-4 py-2 text-sm bg-transparent rounded-lg text-gray-100 hover:text-gray-300 focus:outline-none focus:shadow-outline flex items-center"
                            @click="dropdownToggler" @blur="dropdownToggler">
                            <span>Products</span>
                        </button>
                            <ul v-if="dropdownNavbar" class="flex lg:absolute flex-col max-w-42 py-1 lg:bg-white rounded-md lg:shadow-md pl-2 lg:pl-0">
                                <li>
                                    <a href="#"
                                        class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100">Exchange</a>
                                </li>
                            </ul>
                    </li> -->
                </ul>
            </div>
            <div :class="[open ? 'flex' : 'hidden lg:flex']" class="space-x-3">
                <router-link to="/cart" class="px-2 py-2 mt-0 text-white">
                    <i class="pi pi-cart-plus"></i>
                    <span class="bg-white rounded-full text-purple-500 px-1">{{ cartStore?.cartItems?.length ?? 0 }}</span>
                </router-link>
                <button  class="px-2 py-2 mt-0 text-white">
                    <i class="pi pi-heart-fill"></i>
                </button>

                <li class="" v-if="authStore?.isAuthenticated">
                        <button class="md:px-4 py-2 text-sm bg-transparent rounded-lg text-gray-100 hover:text-gray-300 focus:outline-none focus:shadow-outline flex items-center"
                            @click="dropdownToggler" @blur="dropdownToggler">
                            <span>{{ authStore.user.name }}</span>
                        </button>
                            <ul v-if="dropdownNavbar" class="flex lg:absolute flex-col max-w-42 py-1 lg:bg-white rounded-md lg:shadow-md pl-2 lg:pl-0">
                                <li>
                                    <button @click="logoutUser" class="block py-2 px-4 cursor-pointer text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                                </li>
                            </ul>
                    </li>


                <router-link v-else to="/login" class="px-5 py-2 mt-0 rounded bg-gradient-to-r from-[#468ef9] to-[#0c66ee] text-white">
                    Login
                </router-link>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { ref } from 'vue'
import NavLink from './NavLink.vue'
import useCartStore  from '@/stores/cart'
import { useRouter } from 'vue-router';
import { useAuthStore } from '@/stores/auth'
import useAlert from '@/services/alert'

const authStore = useAuthStore();
const router = useRouter();

const open = ref(false);
const dropdownNavbar = ref(false);
const cartStore = useCartStore();

const dropdownToggler = () => {
    dropdownNavbar.value = !dropdownNavbar.value
}

const logoutUser = async () => {
    console.log('logout');
    let response = await authStore.logout();
    router.push({ name: 'home' });
    useAlert().topAlert('success', response.message)
}
</script>