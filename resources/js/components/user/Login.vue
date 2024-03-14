<template>
    <userLayout>
        <div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8 px-6">
            <div class="sm:mx-auto sm:w-full sm:max-w-md">
                <!-- <img class="mx-auto h-10 w-auto" src="https://www.svgrepo.com/show/301692/login.svg" alt="Workflow"> -->
                <h2 class="mt-6 text-center text-3xl leading-9 font-extrabold text-gray-900">
                    Sign in to your account
                </h2>
                <p class="mt-2 text-center text-sm leading-5 text-blue-500 max-w">
                    Or
                    <router-link to="/register"
                        class="font-medium text-blue-500 hover:text-blue-500 focus:outline-none focus:underline transition ease-in-out duration-150">
                        create a new acccount
                    </router-link>
                </p>
            </div>

            <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
                <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                    <p class="text-md font-medium text-gray-700 dark:text-gray-300 text-center">{{ errors }}</p>
                    <form @submit.prevent="formSubmit" method="post">
                        <div>
                            <label for="email" class="block text-sm font-medium leading-5  text-gray-700">Email
                                address</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="email" v-model="form.email" placeholder="user@example.com" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                                <ValidationMessage key="email_error" :modelValue="v$.email" label="email" :show="v$.email.error" />
                            </div>
                        </div>
                        <div class="mt-6">
                            <label for="email" class="block text-sm font-medium leading-5  text-gray-700">Password</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="password" v-model="form.password" placeholder="*******" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                                <ValidationMessage key="password_error" :modelValue="v$.password" label="password" :show="v$.password.error" />
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-between">
                            <div class="flex items-center">
                                <input type="checkbox" id="remember_me" v-model="form.remember" class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                                <label for="remember_me" class="ml-2 block text-sm leading-5 text-gray-900">Remember me</label>
                            </div>
                            <div class="text-sm leading-5">
                                <a href="#" class="font-medium text-blue-500 hover:text-blue-500 focus:outline-none focus:underline transition ease-in-out duration-150">
                                    Forgot your password?
                                </a>
                            </div>
                        </div>

                        <div class="mt-6">
                            <span class="block w-full rounded-md shadow-sm">
                                <button type="submit"
                                    class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-500 hover:bg-blue-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                                    Sign in
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
import { ref, computed } from 'vue';
import { useRouter } from 'vue-router';
import { useVuelidate } from "@vuelidate/core"
import { email, required } from "@vuelidate/validators";
import { useAuthStore } from '@/stores/auth'
import useAlert from '@/services/alert';

const authStore = useAuthStore();
const router = useRouter();

const errors = ref('');
const form = ref({
    email: '',
    password: '',
	remember: ''
});

const rules = computed(() => ({
    email: { required },
    password: { required },
}));
const v$ = useVuelidate(rules, form);

const formSubmit = async() =>{
	errors.value = '';
	v$.value.$touch();
    if (v$.value.$error) return;
    v$.value.$error = false;

	let response = await authStore.login(form.value);
    if (response) {
        if (!response.success) {
			errors.value = response.message;
            if (response.errors) {
                for (let key in response.errors) {
                    let error = response.errors[key];
                    v$.value[key].$serverError = error
                    v$.value[key].error = true
                }
            }
            else if (response.message) {
                useAlert().topAlert('info', response.message)
            }
        } else {
            if(response.data.user.role_id ===1){
                router.push({ name: 'admin.dashboard' });
            }else{
                router.push({ name: 'home' });
            }
            useAlert().topAlert('success', response.message)
        }
    }
}
</script>
