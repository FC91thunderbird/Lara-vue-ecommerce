<template>
    <adminLayout>
        <div class="grid mx-5  bg-white rounded-lg ">
            <div class="flex justify-between items-center px-4 my-5">
                <h1 class="font-heading text-sm xs:text-sm md:text-2xl font-bold text-gray-900">
                    Products ({{ pagination?.total }})
                </h1>
                <div class="btn-link flex items-center text-xs text-indigo-600 ">
                    <input placeholder="search" type="search" v-model.lazy="searchTerm"
                        class="appearance-none block w-full px-3 py-1 border border-gray-300 rounded-md placeholder-gray-400 focus:outline focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">

                    <router-link to="/admin/addproduct"
                        class="w-full flex justify-center py-1 mx-1 border border-transparent text-sm font-medium rounded-md text-white bg-blue-500 hover:bg-blue-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                        Add New
                    </router-link>
                </div>
            </div>

            <div class="overflow-hidden overflow-x-auto">
                <table class="min-w-full ">
                    <thead class="bg-gray-50 text-left">
                        <tr>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500"> Id </th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500"> Title </th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500"> Category </th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500"> Subcategory </th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500"> Price </th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500"> Colors </th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500"> Sizes </th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500"> Image </th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500"> Created Date </th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500"> Actions </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="product in products" :key="product.id">
                            <td class="px-4 py-2 whitespace-nowrap"> {{ product.id }} </td>
                            <td class="px-4 py-2 whitespace-nowrap"> {{ product.title }}</td>
                            <td class="px-4 py-2 whitespace-nowrap"> {{ product.category }}</td>
                            <td class="px-4 py-2 whitespace-nowrap"> {{ product.subcategory }}</td>
                            <td class="px-4 py-2 whitespace-nowrap"> {{ product.price }}</td>
                            <td class="px-4 py-2 whitespace-nowrap"><span class="bg-gray-300 rounded p-1 mx-1" v-for="color in product.colors" :key="color">{{ formateStr(color) }}</span></td>
                            <td class="px-4 py-2 whitespace-nowrap"> <span class="bg-gray-300 rounded p-1 mx-1" v-for="size in product.sizes" :key="size" > {{ formateStr(size) }}</span> </td>
                            <td class="px-4 py-2 whitespace-nowrap"><img class="h-10 w-10 rounded"
                                    :src="'/' + product.image" :alt="product.name"> </td>
                            <td class="px-4 py-2 whitespace-nowrap"> {{ product.created_at }}</td>
                            <td class="px-4 py-2 whitespace-nowrap  text-sm font-medium">
                                <router-link :to='{ name: "admin.editproduct", params: { id: product.id } }'
                                    class="text-sm font-medium rounded-md text-white bg-blue-500 p-2 mx-1 text-indigo-600 hover:text-indigo-900">
                                    <i class="pi pi-pencil"></i> </router-link>
                                <button @click="deleteItem(product.id)"
                                    class="text-sm font-medium rounded-md text-white bg-red-400 p-2 mx-1 text-red-600 hover:text-red-900">
                                    <i class="pi pi-trash"></i> </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <Pagination :current-page="pagination?.current_page" :total-pages="pagination?.total_pages"
                    :from="pagination?.from" :to="pagination?.to" :records="pagination?.total"
                    @page-change="handlePageChange" />
            </div>
        </div>
    </adminLayout>
</template>

<script setup>
import { ref, onMounted, watch, computed } from 'vue';
import { useRouter } from 'vue-router';
import ApiService from '@/services/ApiService';
import useAlert from '@/services/alert';
import { useAuthStore } from '@/stores/auth'

const authStore = useAuthStore();

const router = useRouter();
const products = ref([]);
const searchTerm = ref('');

const pagination = ref({
    current_page: 1,
    last_page: 0,
    per_page: 10,
    total_pages: 0,
    total: 0,
    from: 0,
    to: 0
});

onMounted(() => {
    fetchProducts();
});

const formateStr = (str) => str.charAt(0).toUpperCase() + str.slice(1);

const headers = computed(() => ({
    Authorization: `Bearer ${authStore.token}`,
}));

const fetchProducts = async () => {
    let params = {
        per_page: pagination.value.per_page,
        page: pagination.value.current_page,
        search: searchTerm.value
    };

    try {
        let response = await ApiService.get("/api/admin/products", params, headers.value);

        if (response.success) {
            products.value = response.data.products.data;
            pagination.value = response.data.products.pagination;
        } else {
            if (response.status === 401) {
                // authStore.flushUser();
                router.push({ name: 'login' });
            }
        }
    } catch (error) {
        console.log('Product fetch', error);
    }
};

const handlePageChange = (newPage) => {
    pagination.value.current_page = newPage;
    fetchProducts();
};

const deleteItem = async (id) => {
    const result = await useAlert().centerAlert("warning");

    if (result.isConfirmed) {
        let response = await ApiService.delete(`/api/admin/products/${id}`, headers.value);

        if (response) {
            if (!response.success) {
                let message = 'Something went wrong';
                if (response.message) {
                    message = response.message;
                }
            } else {
                fetchProducts();
                useAlert().topAlert('success', response.message)
            }
        }
    }
};

watch(searchTerm, (newSearchTerm, oldSearchTerm) => {
    if (newSearchTerm !== oldSearchTerm) {
        fetchProducts(newSearchTerm);
    }
});
</script>
