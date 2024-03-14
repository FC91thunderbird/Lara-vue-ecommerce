<template>
    <adminLayout>
        <div class="grid mx-5 grid-cols-1 bg-white rounded-lg">
            <div class="flex justify-between items-center px-4 my-5">
                <h1 class="font-heading text-sm xs:text-sm md:text-2xl font-bold text-gray-900">
                    Category ({{ pagination?.total }})
                </h1>
                <div class="btn-link flex items-center text-xs text-indigo-600 ">
                    <input placeholder="search" type="search" v-model.lazy="searchTerm" class="appearance-none block w-full px-3 py-1 border border-gray-300 rounded-md placeholder-gray-400 focus:outline focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">

                    <router-link to="/admin/addcategory" class="w-full flex justify-center py-1 mx-1 border border-transparent text-sm font-medium rounded-md text-white bg-blue-500 hover:bg-blue-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                        Add New
                    </router-link>
                </div>
            </div>

            <table class="min-w-full divide-y divide-gray-200 overflow-x-auto">
                <thead class="bg-gray-50 text-left">
                    <tr>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500"> Id </th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500"> Name </th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500"> slug </th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500"> Image </th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500"> Actions </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="category in categories" :key="category.id">
                        <td class="px-4 py-2 whitespace-nowrap"> {{ category.id }} </td>
                        <td class="px-4 py-2 whitespace-nowrap"> {{ category.name }}</td>
                        <td class="px-4 py-2 whitespace-nowrap"> {{ category.slug }}</td>
                        <td class="px-4 py-2 whitespace-nowrap"><img class="h-10 w-10 rounded" :src="'/'+category.image" :alt="category.name"> </td>
                        <td class="px-4 py-2 whitespace-nowrap  text-sm font-medium">
                            <router-link :to='{ name: "admin.editcategory", params: { id: category.id } }' class="text-sm font-medium rounded-md text-white bg-blue-500 p-2 mx-1 text-indigo-600 hover:text-indigo-900"> <i class="pi pi-pencil"></i> </router-link>
                            <button @click="deleteItem(category.id)" class="text-sm font-medium rounded-md text-white bg-red-400 p-2 mx-1 text-red-600 hover:text-red-900"> <i class="pi pi-trash"></i> </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <Pagination :current-page="pagination?.current_page" :total-pages="pagination?.total_pages"
            :from="pagination?.from" :to="pagination?.to" :records="pagination?.total" @page-change="handlePageChange" />
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
const categories = ref([]);
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

onMounted(()=>{
    fetchCategory();
});

const headers = computed(() => ({
        Authorization: `Bearer ${authStore.token}`,
    }));

const fetchCategory = async () =>{
    let params = {
    per_page: pagination.value.per_page,
    page: pagination.value.current_page,
    search: searchTerm.value
  };  
 
  try {
    let response = await ApiService.get("/api/admin/category", params, headers.value);

    if(response.success){
        categories.value = response.data.categories.data;
        pagination.value = response.data.categories.pagination;
    }else{
        if(response.status === 401){
            // authStore.flushUser();
            router.push({ name: 'login' });
        }
    }
  } catch (error) {
    console.log('Category fetch', error);
  }
};

const handlePageChange = (newPage) => {
  pagination.value.current_page = newPage;
  fetchCategory();
};

const deleteItem = async (id) => {
    const result = await useAlert().centerAlert("warning");

if (result.isConfirmed) {
    let response = await ApiService.delete(`/api/admin/category/${id}`,headers.value);

    if(response){
        if(!response.success){
            let message = 'Something went wrong';
            if(response.message){
                message = response.message;
            }
        }else{
            fetchCategory();
            useAlert().topAlert('success', response.message)
        }
    }
  }
};

watch(searchTerm, (newSearchTerm, oldSearchTerm) => {
  if (newSearchTerm !== oldSearchTerm) {
    fetchCategory(newSearchTerm);
  }
});
</script>
