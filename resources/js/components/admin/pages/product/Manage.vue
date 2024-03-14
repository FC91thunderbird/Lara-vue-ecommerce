<template>
    <adminLayout>
        <div class="bg-white border rounded-lg shadow relative mx-5">
            <div class="flex items-start justify-between p-5 border-b rounded-t">
                <h3 class="text-xl font-semibold"> {{ title }} </h3>
                <RouterLink to="/admin/product"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                    <i class="pi pi-times"></i>
                </RouterLink>
            </div>

            <form @submit.prevent="formSubmit" method="post">
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-2 ">
                            <label class="text-sm font-medium text-gray-900 block mb-2"> Title</label>
                            <input type="text" v-model="form.title"
                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                placeholder="Enter Product name">
                            <ValidationMessage key="title_error" :modelValue="v$.title" label="Title"
                                :show="v$.title.error" />
                        </div>
                        <div class="col-span-6 sm:col-span-2">
                            <label class="text-sm font-medium text-gray-900 block mb-2">Category</label>
                            <select v-model="form.category_id" @change="fetchSubcategoies($event.target.value)"
                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5">
                                <option v-for="category in categories" :key="category.id" :value="category.id">{{
                    category.name }}</option>
                            </select>

                            <ValidationMessage key="category_id_error" :modelValue="v$.category_id"
                                label="Category Name" :show="v$.category_id.error" />
                        </div>
                        <div class="col-span-6 sm:col-span-2">
                            <label class="text-sm font-medium text-gray-900 block mb-2">SubCategory</label>
                            <select v-model="form.subcategory_id"
                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5">
                                <option v-for="subcat in subcategories" :key="subcat.id" :value="subcat.id">{{
                    subcat.name }}</option>
                            </select>

                            <ValidationMessage key="subcategory_id_error" :modelValue="v$.subcategory_id"
                                label="Subcategory Name" :show="v$.subcategory_id.error" />
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label class="text-sm font-medium text-gray-900 block mb-2">Buy Price</label>
                            <input type="number" v-model="form.buy_price"
                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                placeholder="Enter buy_price">
                            <ValidationMessage key="buy_price_error" :modelValue="v$.buy_price" label="Buy Price"
                                :show="v$.buy_price.error" />
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label class="text-sm font-medium text-gray-900 block mb-2"> Price</label>
                            <input type="number" v-model="form.price"
                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                placeholder="Enter Price">
                            <ValidationMessage key="price_error" :modelValue="v$.price" label="Price"
                                :show="v$.price.error" />
                        </div>

                        <div class="col-span-6 sm:col-span-3 border rounded p-4">
                            <label class="block text-gray-700 font-medium mb-2">Colors</label>
                            <div class="flex flex-wrap -mx-2">
                                <div class="px-2 w-1/3" v-for="(color,key) in colors" :key="key" >
                                    <label :for="'color_' + color" class="block text-gray-700 font-medium mb-2">
                                        <input type="checkbox" :id="'color_' + color" v-model="form.colors" :value="color" class="mr-2">
                                        {{ color}}
                                    </label>
                                </div>
                                <ValidationMessage key="colors_error" :modelValue="v$.colors" label="Colors"
                                :show="v$.colors.error" />
                            </div>
                        </div>
                        <div class="col-span-6 sm:col-span-3 border rounded p-4">
                            <label class="block text-gray-700 font-medium mb-2">Sizes</label>
                            <div class="flex flex-wrap -mx-2">
                                <div class="px-2 w-1/3" v-for="(size,key) in sizes" :key="key">
                                    <label :for="'size_' + size" class="block text-gray-700 font-medium mb-2">
                                        <input type="checkbox" :id="'size_' + size" class="mr-2" v-model="form.sizes" :value="size">
                                        {{ size }}
                                    </label>
                                </div>
                                <ValidationMessage key="sizes_error" :modelValue="v$.sizes" label="Sizes"
                                :show="v$.sizes.error" />
                            </div>
                        </div>

                        <div class="col-span-full">
                            <label class="text-sm font-medium text-gray-900 block mb-2"> Description</label>
                            <textarea v-model="form.description"
                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                placeholder="Enter description" />
                            <ValidationMessage key="description_error" :modelValue="v$.description" label="description"
                                :show="v$.description.error" />
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label class="text-sm font-medium text-gray-900 block mb-2">Image</label>
                            <input type="file" @change="handleImageUpload" accept="image/jpeg"
                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5">
                            <ValidationMessage key="image_error" :modelValue="v$.image" label="image"
                                :show="v$.image.error" />
                        </div>
                    </div>
                </div>

                <div class="p-6 border-t border-gray-200 rounded-b">
                    <button type="submit"
                        class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center">{{
                        button }}</button>
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
const subcategories = ref([]);

const colors = ref(['red', 'yellow', 'green', 'blue', 'black', 'white']);
const sizes = ref(['s', 'm', 'l', 'xl', 'xxl', 'xxxl']);

const form = ref({
    title: '',
    category_id: '',
    subcategory_id: '',
    buy_price: '',
    price: '',
    colors: [],
    sizes: [],
    description: '',
    image: null
});

const rules = computed(() => ({
    title: { required },
    category_id: { required },
    subcategory_id: { required },
    buy_price: { required },
    price: { required },
    colors: { required },
    sizes: { required },
    description: { required },
    image: {},
}));
const v$ = useVuelidate(rules, form);

const title = computed(() => {
    return route.name === 'admin.editproduct' ? 'Edit Product' : 'Create Product';
});

const button = computed(() => {
    return route.name === 'admin.editproduct' ? 'Update' : 'Save';
});

const headers = computed(() => ({
    Authorization: `Bearer ${authStore.token}`,
    'Content-Type': 'multipart/form-data',
}));

onMounted(() => {
    if (route.name === 'admin.editproduct') {
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

const fetchSubcategoies = async (catId) => {
    if (catId) {
        try {
            const response = await ApiService.get(`/api/admin/subcategory/${catId}/fetch`, headers.value);
            if (response.success) {
                subcategories.value = response.data.subcategory
            } else {
                let message = response.message || 'something_went_wrong';
                console.log(message);
            }
        } catch (error) {
            console.error('fetch subcat', error);
        }
    }
}

const getById = async () => {
    try {
        const response = await ApiService.get(`/api/admin/products/${route.params.id}`, headers.value);
        if (response.success) {
            form.value = response.data.products
            fetchSubcategoies(response.data.products.category_id);
        } else {
            let message = response.message || 'something_went_wrong';
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
        const response = route.name === 'admin.editproduct' ? await ApiService.post(`/api/admin/products/${route.params.id}`, form.value, headers.value) : await ApiService.post('/api/admin/products', form.value, headers.value);

        if (response.success) {
            router.push({ name: 'admin.product' });
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
            // toast.add({ severity: 'error', summary: 'error', detail: message, life: 3000 });
        }
    } catch (error) {
        console.log('Catch error', error);
        // toast.add({ severity: 'error', summary: 'error', detail: error.message, life: 3000 });
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
