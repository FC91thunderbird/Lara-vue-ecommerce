<template>
    <userLayout>
        <div class=" py-8">
            <div class="container mx-auto px-4">
                <h1 class="text-2xl font-semibold mb-4">Checkout</h1>
                <form @submit.prevent="formSubmit">
                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="md:w-3/4">
                            <div class="bg-white rounded-lg border shadow-md p-6 mb-4">

                                <div class="p-6 space-y-6">
                                    <div class="grid grid-cols-6 gap-6">
                                        <div class="col-span-3 sm:col-span-3 ">
                                            <label class="text-sm font-medium text-gray-900 block mb-2">
                                                Firstname</label>
                                            <input type="text" v-model="form.firstname"
                                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                                placeholder="Enter firstname">
                                            <ValidationMessage key="firstname_error" :modelValue="v$.firstname"
                                                label="firstname" :show="v$.firstname.error" />
                                        </div>
                                        <div class="col-span-3 sm:col-span-3 ">
                                            <label class="text-sm font-medium text-gray-900 block mb-2">
                                                Lastname</label>
                                            <input type="text" v-model="form.lastname"
                                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                                placeholder="Enter lastname">
                                            <ValidationMessage key="lastname_error" :modelValue="v$.lastname"
                                                label="lastname" :show="v$.lastname.error" />
                                        </div>

                                        <div class="col-span-6 sm:col-span-2">
                                            <label class="text-sm font-medium text-gray-900 block mb-2">Country</label>
                                            <select v-model="form.country"
                                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5">
                                                <option> Select Country</option>
                                                <option> india</option>
                                            </select>
                                            <ValidationMessage key="country_error" :modelValue="v$.country"
                                                label="Country" :show="v$.country.error" />
                                        </div>
                                        <div class="col-span-6 sm:col-span-2">
                                            <label class="text-sm font-medium text-gray-900 block mb-2">State</label>
                                            <select v-model="form.state"
                                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5">
                                                <option> Select state</option>
                                                <option> india</option>
                                            </select>
                                            <ValidationMessage key="state_error" :modelValue="v$.state" label="state"
                                                :show="v$.state.error" />
                                        </div>
                                        <div class="col-span-6 sm:col-span-2">
                                            <label class="text-sm font-medium text-gray-900 block mb-2">City</label>
                                            <select v-model="form.city"
                                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5">
                                                <option> Select city</option>
                                                <option> india</option>
                                            </select>
                                            <ValidationMessage key="city_error" :modelValue="v$.city" label="city"
                                                :show="v$.city.error" />
                                        </div>



                                        <div class="col-span-3 sm:col-span-3">
                                            <label class="text-sm font-medium text-gray-900 block mb-2">
                                                Address</label>
                                            <textarea v-model="form.address"
                                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                                placeholder="Enter address" />
                                            <ValidationMessage key="address_error" :modelValue="v$.address"
                                                label="address" :show="v$.address.error" />
                                        </div>
                                        <div class="col-span-3 sm:col-span-3">
                                            <label class="text-sm font-medium text-gray-900 block mb-2">
                                                Address 2</label>
                                            <textarea v-model="form.address2"
                                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                                placeholder="Enter address2" />
                                        </div>

                                        <div class="col-span-6 sm:col-span-2 ">
                                            <label class="text-sm font-medium text-gray-900 block mb-2">
                                                Zip Code</label>
                                            <input type="number" v-model="form.zip"
                                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                                placeholder="Enter zip">
                                            <ValidationMessage key="zip_error" :modelValue="v$.zip" label="zip"
                                                :show="v$.zip.error" />
                                        </div>
                                        <div class="col-span-6 sm:col-span-2 ">
                                            <label class="text-sm font-medium text-gray-900 block mb-2">
                                                Phone</label>
                                            <input type="number" v-model="form.phone"
                                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5"
                                                placeholder="Enter phone">
                                            <ValidationMessage key="phone_error" :modelValue="v$.phone" label="phone"
                                                :show="v$.phone.error" />
                                        </div>

                                    </div>
                                </div>


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

                                <hr class="my-2">

                                <h2 class="text-lg font-semibold mb-4">Payment Method</h2>
                                <div class="flex justify-between mb-2">
                                    <label  class="block text-gray-700 font-medium mb-2">
                                        <input type="radio" class="mr-2" v-model="form.payment" value="paypal"> Paypal
                                    </label>
                                </div>
                                <div class="flex justify-between mb-2">
                                    <label  class="block text-gray-700 font-medium mb-2">
                                        <input type="radio" class="mr-2" v-model="form.payment" value="payumoney"> PayUmoney
                                    </label>
                                </div>
                                <div class="flex justify-between mb-2">
                                    <label  class="block text-gray-700 font-medium mb-2">
                                        <input type="radio" class="mr-2" v-model="form.payment" value="cod"> COD
                                    </label>
                                </div>
                                <ValidationMessage key="payment_error" :modelValue="v$.payment"
                                                label="Payment" :show="v$.payment.error" />
                                                
                                <button v-if="authStore.isAuthenticated" type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-lg mt-4 w-full">
                                    Process Payment</button>
                                <router-link v-else to="/login"  type="submit" class="bg-blue-500 text-center text-white py-2 px-4 rounded-lg mt-4 w-full">
                                    Login</router-link>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>


    </userLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import useCartStore from '@/stores/cart';
import { useAuthStore } from "@/stores/auth";
import useAlert from '@/services/alert';
import ApiService from '@/services/ApiService';
import { useVuelidate } from '@vuelidate/core';
import { required } from "@vuelidate/validators";

const cartStore = useCartStore();
const authStore = useAuthStore();

const form = ref({
    firstname: '',
    lastname: '',
    country: '',
    city: '',
    state: '',
    address: '',
    address2: '',
    zip: '',
    phone: '',
    payment: ''
});

const rules = computed(() => ({
    firstname: { required },
    lastname: { required },
    country: { required },
    city: { required },
    state: { required },
    address: { required },
    zip: { required },
    phone: { required },
    payment: { required },
}));

const v$ = useVuelidate(rules, form);

const headers = computed(() => ({
    Authorization: `Bearer ${authStore.token}`,
}));

const formSubmit = async () => {
    v$.value.$touch();
    if (v$.value.$error) return;
    v$.value.$error = false;
    // loading.value = true;
    try {
        const response = await ApiService.post('/api/checkout', form.value, headers.value);

        if (response.success) {

            if (response.data.stripeUrl) {
                window.location.href = response.data.stripeUrl;
            }else{
                // router.push({name: 'orderSuccess' })
            }
            // router.push({ name: 'admin.product' });
            // useAlert().topAlert('success', response.message)
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
