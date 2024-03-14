<template>
    <userLayout>
        <div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8 px-6">
            <div class="sm:mx-auto sm:w-full sm:max-w-md">
                <!-- <img class="mx-auto h-10 w-auto" src="https://www.svgrepo.com/show/301692/login.svg" alt="Workflow"> -->
                <h2 class="mt-6 text-center text-3xl leading-9 font-extrabold text-gray-900">
                    Create your account
                </h2>
                <p class="mt-2 text-center text-sm leading-5 text-blue-500 max-w">
                    Or
                    <router-link to="/login"
                        class="font-medium text-blue-500 hover:text-blue-500 focus:outline-none focus:underline transition ease-in-out duration-150">
                        Log in acccount
                    </router-link>
                </p>
            </div>

            <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
                <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                    <form @submit.prevent="formSubmit" method="post">
                        <div>
                            <label class="block text-sm font-medium leading-5  text-gray-700">Name</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="text" v-model="form.name" placeholder="Enter Name" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                            </div>
                            <ValidationMessage key="name_error" :modelValue="v$.name" label="name" :show="v$.name.error" />
                        </div>
                        <div class="mt-6">
                            <label class="block text-sm font-medium leading-5  text-gray-700">Username</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="text" v-model="form.username" placeholder="Enter Username" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                            </div>
                            <ValidationMessage key="username_error" :modelValue="v$.username" label="username" :show="v$.username.error" />
                        </div>
                        <div class="mt-6">
                            <label class="block text-sm font-medium leading-5  text-gray-700">Email</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="email" v-model="form.email" placeholder="Enter email" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                            </div>
                            <ValidationMessage key="email_error" :modelValue="v$.email" label="email" :show="v$.email.error" />
                        </div>
                        <div class="mt-6">
                            <label class="block text-sm font-medium leading-5  text-gray-700">Password</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="password" v-model="form.password" placeholder="*******" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                            </div>
                            <ValidationMessage key="password_error" :modelValue="v$.password" label="password" :show="v$.password.error" />
                        </div>
                        <div class="mt-6">
                            <label class="block text-sm font-medium leading-5  text-gray-700">Confirm Password</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="password" v-model="form.confirm_password" placeholder="*******" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                            </div>
                            <ValidationMessage key="confirm_password_error" :modelValue="v$.confirm_password" label="Confirm Password" :show="v$.confirm_password.error" />
                        </div>

                        <div class="mt-6">
                            <span class="block w-full rounded-md shadow-sm">
                                <button type="submit"
                                    class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-500 hover:bg-blue-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                                    Register
                                </button>
                            </span>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </userLayout>
</template>

<script setup>
import { computed, ref } from 'vue';
import { useVuelidate } from '@vuelidate/core';
import { required } from "@vuelidate/validators";
import useAlert from '@/services/alert';
import ApiService from '@/services/ApiService';
import { useAuthStore } from "@/stores/auth";
import { useRouter } from 'vue-router';

const authStore = useAuthStore();
const router = useRouter();

const form = ref({
    name: '',
    username: '',
    email: '',
    password: '',
    confirm_password: '',
});

const rules = computed(() => ({
    name: { required },
    username: { required },
    email: { required },
    password: { required },
    confirm_password: { required },
})); 

const v$ = useVuelidate(rules, form);

const formSubmit = async () => {
    v$.value.$touch();
    if (v$.value.$error) return;
    v$.value.$error = false;
    // loading.value = true;
    try {
        const response = await ApiService.post('/api/register', form.value);

        if (response.success) {
            let params = {
                email: form.value.email,
                password: form.value.password,
            };
            let loginResp = await authStore.login(params);

            if (loginResp.success) {
                router.push({ name: 'home' });
                useAlert().topAlert('success', response.message)
            }            
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

</script>
