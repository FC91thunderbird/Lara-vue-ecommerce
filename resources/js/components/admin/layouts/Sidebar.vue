<template>
 <div class="flex">
        <!-- Backdrop -->
        <div :class="isOpen ? 'block' : 'hidden'"
            class="fixed inset-0 z-20 transition-opacity bg-black opacity-50 lg:hidden" @click="isOpen=false" />
        <!-- End Backdrop -->

        <div :class="isOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'"
            class="fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto transition duration-300 transform bg-gray-900 lg:translate-x-0 lg:static lg:inset-0">
            <div class="flex items-center justify-center mt-8">
                <div class="flex items-center">
                    <span class="mx-2 text-2xl font-semibold text-white">V-Dashboard</span>
                </div>
            </div>

            <nav class="mt-10">
                <template v-for="(menu, index) in menuItems">
                    <template v-if="menu.children">
                        <div class="flex items-center text-gray-500 px-6 py-2 mt-4 duration-200  cursor-pointer duration-200 hover:bg-gray-600 hover:bg-opacity-25 hover:text-gray-300"
                            :class="{ 'bg-gray-600 bg-opacity-25 text-gray-100 border-gray-500': openMenu == index }" @click="toggleMenu(index)">
                            <i :class="menu.icon"></i>
                            <span class="mx-4">{{ menu.label }}</span>
                            <i class="pi pi-angle-down angle-icon"></i>
                        </div>
                        <div v-show="openMenu == index" class="ml-4 bg-gray-600 bg-opacity-25 text-gray-100 border-gray-500 ">
                            <router-link v-for="(child, childIndex) in menu.children" :key="'child' + childIndex"
                                class="flex items-center px-6 py-2 text-gray-600 duration-200 hover:bg-gray-600 hover:bg-opacity-25 hover:text-gray-300 " :class="{ 'open': isMenuActive(child) }"
                                :to="child.route ? child.route : '#'">
                                <i :class="child.icon"></i>
                                <span class="mx-4">{{ child.label }}</span>
                            </router-link>
                        </div>
                    </template>
                    <template v-else>
                        <router-link class="flex items-center text-gray-500 px-6 py-2 mt-4 duration-200 hover:bg-gray-600 hover:bg-opacity-25 hover:text-gray-300" :class="{ 'bg-gray-600 bg-opacity-25 text-gray-100 border-gray-500': isMenuActive(menu) }"
                            :to="menu.route ? menu.route : '#'">
                            <i :class="menu.icon"></i>
                            <span class="mx-4">{{ menu.label }}</span>
                        </router-link>
                    </template>
                </template>

            </nav>
        </div>
    </div>
</template>

<script setup>
import { useRoute } from 'vue-router'
import { ref, computed } from 'vue'

const route = useRoute();

const isOpen = ref(false)

// sidebar
const activeClass = ref(
  'bg-gray-600 bg-opacity-25 text-gray-100 border-gray-500',
)
const inactiveClass = ref(
  'border-gray-900 text-gray-500 hover:bg-gray-600 hover:bg-opacity-25 hover:text-gray-100',
)

const isMenuActive = (menu) => {
  if (menu.route) {
    return menu.route.name === route.name || route.name.startsWith(menu.route.name);
  }
  return false;
}

const openMenu = ref(false);

const toggleMenu = (index) => {
  if (openMenu.value === index) {
    openMenu.value = false;
  } else {
    openMenu.value = index;
  }
}

// Menu items
const menuItems = computed(() => {
  let menu = [
    {
      label: 'dashboard',
      icon: 'pi pi-calendar-plus',
        route: { name: 'admin.dashboard' }
    },
    {
      label: 'Manage',
      icon: 'pi pi-cog',
      children: [
        {
          label: 'Category',
          icon: 'pi pi-bars',
          route: "/admin/category"

        },
        {
          label: 'Subcategory',
          icon: 'pi pi-slack',
          route: "/admin/subcategory"
        },
        {
          label: 'Products',
          icon: 'pi pi-chart-bar',
          route: "/admin/product"
        },
      ]
    },
    {
      label: 'Users',
      icon: 'pi pi-users',
    //   route: { name: 'admin.users' },
    },
    
  ];

  return menu;
});
</script>
