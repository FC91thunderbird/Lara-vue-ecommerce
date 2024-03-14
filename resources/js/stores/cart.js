import { ref } from "vue";
import { defineStore } from "pinia";
import useAlert from '@/services/alert';
import ApiService from '@/services/ApiService';

export default defineStore('cartStore', () => {

    const cartItems = ref([]);
    const totalItems = ref(0);
    const totalCost = ref(0);

    const fetchCartItem = async () => {
        try {
            let response = await ApiService.get('/api/cart');
            if (response.success) {
                cartItems.value = response.data.cartItems;
                totalCost.value = response.data.total;
            } else {
                console.log(response.message);
            }
        } catch (error) {
            console.log('cart fetch', error);
        }
    }

    const addCartItem = async (item) => {
        try {
            let response = await ApiService.post(`/api/cart/${item}`);
            if (response.success) {
                fetchCartItem();
                useAlert().topAlert('success', response.message)
            } else {
                console.log(response.message);
            }
        } catch (error) {
            console.log('add cart', error);
        }
    };

    const increment = async (item, quantity) => {
        try {
            if (quantity >= 1) {
                let response = await ApiService.put(`/api/cart/${item}`, { quantity: quantity });
                if (response.success) {
                    fetchCartItem();
                    useAlert().topAlert('success', response.message)
                } else {
                    console.log(response.message);
                }
            }
        } catch (error) {
            console.log('cart increment', error);
        }
    }

    // const decrement = async (item, quantity) => {
    //     if (quantity >= 1) {
    //         try {
    //             let response = await ApiService.put(`/api/cart/${item}`, { quantity: quantity });
    //             if (response.success) {
    //                 fetchCartItem();
    //                 useAlert().topAlert('success', response.message)
    //             } else {
    //                 console.log(response.message);
    //             }
    //         } catch (error) {
    //             console.log('cart increment', error);
    //         }
    //     }
    // }

    const removeCart = async (item) => {
        try {
            let response = await ApiService.delete(`/api/cart/${item.id}`);
            if (response.success) {
                fetchCartItem();
                useAlert().topAlert('success', response.message)
            } else {
                console.log(response.message);
            }
        } catch (error) {
            console.log('cart increment', error);
        }
    }

    return {
        cartItems,
        addCartItem,
        removeCart,
        fetchCartItem,
        increment,
        totalItems,
        totalCost
    };
});