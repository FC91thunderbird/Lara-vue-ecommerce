import { defineStore } from "pinia";
import { ref, computed } from "vue";
import ApiService from "@/services/ApiService";

export const useAuthStore = defineStore("auth", () => {
    const token = ref(null);
    const user = ref(null);

    // check if token is in local storage
    if (localStorage.getItem("token")) {
        token.value = localStorage.getItem("token");
    }else{
        token.value = sessionStorage.getItem("token");
        user.value = JSON.parse(sessionStorage.getItem("user"));
    }

    const isAuthenticated = computed(() => !!token.value);

    const headers = computed(() => ({
        Authorization: `Bearer ${token.value}`,
    }));

    const isAdmin = computed(() => {
        if (user.value) {
            // return user.value.isAdmin;
            return user.value;
        } else {
            getUserDetail();
            // return user.value.isAdmin;
            return user.value;
        }
    });

    function setToken(tokenValue, remember = null) {
        if (tokenValue == null) {
            localStorage.removeItem("token");
            sessionStorage.removeItem("token");
            sessionStorage.removeItem("user");
        }else if (remember){
            localStorage.setItem('token', tokenValue.token);
        }else{
            sessionStorage.setItem('token', tokenValue.token);
        } 
        token.value = tokenValue?.token;
        sessionStorage.setItem('user', JSON.stringify(tokenValue?.user));
    };

    // const setToken = (tokenValue) => {
    //     if (tokenValue == null) {
    //         localStorage.removeItem("token");
    //     } else {
    //         localStorage.setItem("token", tokenValue);
    //     }
    //     token.value = tokenValue;
    // };

    const setUser = (userValue) => {
        user.value = userValue;
        sessionStorage.setItem('user', JSON.stringify(userValue));
    };

    const getUserDetail = async () => {
        const body = {};
        const response = await ApiService.get("/api/user", body, headers.value);
        if (response.success) {
            setUser(response.data.user);
        }
        return response;
    };

    const login = async (data) => {
        const response = await ApiService.post("/api/login", {
            email: data.email,
            password: data.password,
        });
        if (response.success) {
            setToken(response.data, data.remember);
            setUser(response.data.user);
        }
        return response;
    };

    const forgotPassword = async (email) => {
        const response = await ApiService.post("/api/forgot-password", {
            email,
        });
        return response;
    };

    const resetPassword = async (data) => {
        const response = await ApiService.post("/api/reset-password", data);
        return response;
    };

    const logout = async () => {
        if (!token.value) {
            flushUser();
            return { success: true };
        }
        try {
            const response = await ApiService.post(
                "/api/logout",
                {},
                headers.value);
            if (response.success) {
                flushUser();
            }
            return response;
        } catch (error) {
            console.log(error);
        }
    };

    const flushUser = () => {
        setToken(null);
        setUser(null);
    };


    return {
        token,
        user,
        isAuthenticated,
        isAdmin,
        login,
        forgotPassword,
        resetPassword,
        setToken,
        setUser,
        flushUser,
        getUserDetail,
        logout,
    };
});
