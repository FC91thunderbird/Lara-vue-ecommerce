<template>
    <adminLayout>
        <div class="bg-white border rounded-lg shadow relative mx-5">
            <div class="flex items-start justify-between p-5 border-b rounded-t">
                <h3 class="text-xl font-semibold"> {{ title }} </h3>
                <RouterLink to="/admin/subcategory" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                    <i class="pi pi-times"></i>
                </RouterLink>
            </div>

            <form @submit.prevent="formSubmit" method="post">
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-3">
                            <label class="text-sm font-medium text-gray-900 block mb-2"> Name</label>
                            <input type="text" v-model="form.name" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                placeholder="Enter Category name">
                                <ValidationMessage key="name_error" :modelValue="v$.name" label="Name" :show="v$.name.error" />
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label class="text-sm font-medium text-gray-900 block mb-2">Category</label>
                            <select v-model="form.category_id" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5">
                                <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
                            </select>

                            <ValidationMessage key="category_id_error" :modelValue="v$.category_id" label="Category Name" :show="v$.category_id.error" />
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label class="text-sm font-medium text-gray-900 block mb-2">Image</label>
                            <input type="file" @change="handleImageUpload" accept="image/jpeg" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5">
                            <ValidationMessage key="image_error" :modelValue="v$.image" label="image" :show="v$.image.error" />
                        </div>
                    </div>
                </div>

                <div class="p-6 border-t border-gray-200 rounded-b">
                    <button type="submit" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center">{{ button }}</button>
                </div>
            </form>

        </div>
    </adminLayout>
</template>

<script setup>
import { RouterLink, useRoute, useRouter } from 'vue-router';
import { ref, computed, onMounted } from 'vue';
import ApiService from '@/services/ApiService';
import { useVuelidate } from '@vuelidate/core';
import { required } from "@vuelidate/validators";
import useAlert from '@/services/alert';
import { useAuthStore } from '@/stores/auth'

const authStore = useAuthStore();

const route = useRoute();
const router = useRouter();
const categories = ref([]);

const form = ref({
    name:'',
    category_id: '',
    image: null
});

const rules = computed(() => ({
    name: { required },
    category_id: { required },
    image: { },
}));
const v$ = useVuelidate(rules, form);

const title = computed(() => {
    return route.name === 'admin.editsubcategory' ? 'Edit SubCategory' : 'Create SubCategory';
});

const button = computed(() => {
    return route.name === 'admin.editsubcategory' ? 'Update' : 'Save';
});

const headers = computed(() => ({
        Authorization: `Bearer ${authStore.token}`,
        'Content-Type': 'multipart/form-data',
    }));

onMounted(() => {
    if (route.name === 'admin.editsubcategory') {
        getById();
    }
    fetchCategories();
});

const fetchCategories = async () => {
    try {
        const response = await ApiService.get(`/api/admin/category`, headers.value);
        if (response.success) {
            categories.value = response.data.categories.data
        } else {
            let message = response.message || 'something_went_wrong';
            console.log(message);
        }
    } catch (error) {
        console.log(error);
    }
};

const getById = async () => {
    try {
        const response = await ApiService.get(`/api/admin/subcategory/${route.params.id}`, headers.value);
        if (response.success) {
            form.value = response.data.subcategory
        } else {
            let message = response.message || 'something_went_wrong';
            console.log(message);
        }
    } catch (error) {
        console.log(error);
    }
};


const formSubmit = async () => {
    v$.value.$touch();
    if (v$.value.$error) return;
    v$.value.$error = false;
    // loading.value = true;
    try {
        const response = route.name === 'admin.editsubcategory' ? await ApiService.post(`/api/admin/subcategory/${route.params.id}`, form.value, headers.value) : await ApiService.post('/api/admin/subcategory', form.value, headers.value);

        if (response.success) {
            router.push({ name: 'admin.subcategory' });
            useAlert().topAlert('success', response.message)
        } else {
            if (response.errors) {
                for (let key in response.errors) {
                    let error = response.errors[key];
                    v$.value[key].$serverError = error
                    v$.value[key].error = true
                }
            }
            let message = response.message || 'something_went_wrong';
            useAlert().topAlert('info', message)
        }
    } catch (error) {
        console.log('Catch error', error);
    } 
};

const handleImageUpload = (event) => {
    form.value.image = event.target.files[0];
    let reader = new FileReader();
    reader.addEventListener("load", function () {
        // imagePreview.value = reader.result;
    }.bind(this), false);
    if (form.value.image) {
        if (/\.(jpe?g|png|gif)$/i.test(form.value.image.name)) {
            reader.readAsDataURL(form.value.image);
        }
    }
};

</script>
