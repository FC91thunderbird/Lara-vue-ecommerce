<template>
    <header class="flex items-center justify-between px-6 py-2 bg-white border-b-4 border-indigo-600">
        <div class="flex items-center">
            <button class="text-gray-500 focus:outline-none lg:hidden" @click="isOpen=true">
                <i class="pi pi-bars"></i>
            </button>

            <div class="relative mx-4 lg:mx-0">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <i class="pi pi-search"></i>
                </span>

                <input
                    class="w-32 pl-10 pr-4 text-indigo-600 border-gray-200 rounded-md sm:w-64 focus:border-indigo-600 focus:ring focus:ring-opacity-40 focus:ring-indigo-500"
                    type="text" placeholder="Search">
            </div>
        </div>

        <div class="flex items-center">
            <button class="flex mx-4 text-gray-600 focus:outline-none">
                <i class="pi pi-bell"></i>
            </button>

            <div class="relative">
                <div class="flex items-center"  @click="dropdownOpen = !dropdownOpen">
                    <div class="flex-shrink-0 h-10 w-10">
                        <img class="h-10 w-10 rounded-full" src="https://i.pravatar.cc/150?img=1" alt="">
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-900">
                            {{ authStore?.user?.name }}
                        </div>
                        <div class="text-sm text-gray-500">
                            {{ authStore?.user?.email }}
                        </div>
                    </div>
                </div>

                <div v-show="dropdownOpen" class="fixed inset-0 z-10 w-full h-full" @click="dropdownOpen = false" />

                <transition enter-active-class="transition duration-150 ease-out transform"
                    enter-from-class="scale-95 opacity-0" enter-to-class="scale-100 opacity-100"
                    leave-active-class="transition duration-150 ease-in transform"
                    leave-from-class="scale-100 opacity-100" leave-to-class="scale-95 opacity-0">
                    <div v-show="dropdownOpen"
                        class="absolute right-0 z-20 w-48 py-2 mt-2 bg-white rounded-md shadow-xl">
                        <a href="#"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white">Profile</a>
                        <a href="#"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white">Products</a>
                        <a @click="logout" class="block px-4 py-2 text-sm text-gray-700 cursor-pointer hover:bg-indigo-600 hover:text-white">
                            Log out
                        </a>
                    </div>
                </transition>
            </div>
        </div>
    </header>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router';
import useAlert from '@/services/alert'
import { useAuthStore } from '@/stores/auth'

const authStore = useAuthStore();
const router = useRouter();
const dropdownOpen = ref(false);


const logout = async () => {
    let response = await authStore.logout();
    router.push({ name: 'login' });
    useAlert().topAlert('success', response.message)
}

</script>
