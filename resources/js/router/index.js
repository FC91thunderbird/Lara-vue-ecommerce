import { createWebHistory, createRouter } from 'vue-router'
import { useAuthStore } from "@/stores/auth";
import useCartStore  from '@/stores/cart';


const routes = [
    {
        path: "/",
        name: "home",
        component: () => import('@/components/user/pages/Home.vue'),
        meta: { guest: true, title: `Homepage` },
    },
    {
        path: "/about",
        name: "about",
        component: () => import('@/components/user/pages/About.vue'),
        meta: { guest: true, title: `About Us` },
    },
    {
        path: "/cart",
        name: "cart",
        component: () => import('@/components/user/pages/Cart.vue'),
        meta: { guest: true, title: `Cart` },
    },
    {
        path: "/checkout",
        name: "checkout",
        component: () => import('@/components/user/pages/Checkout.vue'),
        meta: { guest: true, title: `Checkout` },
    },


    {
        path: "/login",
        name: "login",
        component: () => import('@/components/user/Login.vue'),
        meta: { guest: true, title: `Login` }
    },
    {
        path: "/register",
        name: "register",
        component: () => import('@/components/user/Register.vue'),
        meta: { guest: true, title: `Register` }
    },

    {
        path: "/admin/dashboard",
        name: "admin.dashboard",
        component: () => import('@/components/admin/pages/Dashboard.vue'),
        meta: { auth: true, title: `Dashboard` }
    },
    {
        path: "/admin/category",
        name: "admin.category",
        component: () => import('@/components/admin/pages/category/Category.vue'),
        meta: { auth: true, title: `Category List` }
    },
    {
        path: "/admin/addcategory",
        name: "admin.addcategory",
        component: () => import('@/components/admin/pages/category/Manage.vue'),
        meta: { auth: true, title: `Add Category` }
    },
    {
        path: "/admin/editcategory/:id",
        name: "admin.editcategory",
        component: () => import('@/components/admin/pages/category/Manage.vue'),
        meta: { auth: true, title: `Add Category` }
    },


    {
        path: "/admin/subcategory",
        name: "admin.subcategory",
        component: () => import('@/components/admin/pages/subcategory/Subcategory.vue'),
        meta: { auth: true, title: `Subcategory List` }
    },
    {
        path: "/admin/addsubcategory",
        name: "admin.addsubcategory",
        component: () => import('@/components/admin/pages/subcategory/Manage.vue'),
        meta: { auth: true, title: `Add SubCategory` }
    },
    {
        path: "/admin/editsubcategory/:id",
        name: "admin.editsubcategory",
        component: () => import('@/components/admin/pages/subcategory/Manage.vue'),
        meta: { auth: true, title: `Edit SubCategory` }
    },


    {
        path: "/admin/product",
        name: "admin.product",
        component: () => import('@/components/admin/pages/product/Products.vue'),
        meta: { auth: true, title: `Products List` }
    },
    {
        path: "/admin/addproduct",
        name: "admin.addproduct",
        component: () => import('@/components/admin/pages/product/Manage.vue'),
        meta: { auth: true, title: `Add Product` }
    },
    {
        path: "/admin/editproduct/:id",
        name: "admin.editproduct",
        component: () => import('@/components/admin/pages/product/Manage.vue'),
        meta: { auth: true, title: `Edit Product` }
    },
    // {
    //     path: "/admin/dashboard",
    //     name: 'admin.dashboard',
    //     component: () => import('@/components/backend/layouts/Main.vue'),
    //     meta: {
    //         middleware: "auth",
    //         requiresAuth: true
    //     },
    //     children: [
    //         {
    //             path: '/dashboard',
    //             name: "dashboard",
    //             component: () => import('@/components/backend/pages/Dashboard.vue'),
    //             meta: {
    //                 title: `Dashboard`,
    //                 requiresAuth: true
    //             }
    //         },

    //         { //category
    //             path: '/admin/category',
    //             name: 'admin.category',
    //             component: () => import('@/components/backend/pages/category/Category.vue'),
    //             meta: {
    //                 middleware: 'auth',
    //                 title: 'Category List',
    //                 requiresAuth: true
    //             }
    //         },
    //         {
    //             path: '/admin/addcategory',
    //             name: 'admin.addcategory',
    //             component: () => import('@/components/backend/pages/category/addCategory.vue'),
    //             meta: {
    //                 middleware: 'auth',
    //                 title: 'Add Category',
    //                 requiresAuth: true
    //             }
    //         },
    //         {
    //             path: '/admin/category/:id',
    //             name: 'admin.editCat',
    //             component: () => import('@/components/backend/pages/category/addCategory.vue'),
    //             meta: {
    //                 middleware: 'auth',
    //                 title: 'Edit Category',
    //                 requiresAuth: true
    //             }
    //         },

    //         { //subcategory
    //             path: '/admin/subcategory',
    //             name: 'admin.subcategory',
    //             component: () => import('@/components/backend/pages/subcategory/Subcategory.vue'),
    //             meta: {
    //                 middleware: 'auth',
    //                 title: 'Sub-Category List',
    //                 requiresAuth: true
    //             }
    //         },
    //         {
    //             path: '/admin/addsubcategory',
    //             name: 'admin.addsubcategory',
    //             component: () => import('@/components/backend/pages/subcategory/addSubcategory.vue'),
    //             meta: {
    //                 middleware: 'auth',
    //                 title: 'Add Subcategory',
    //                 requiresAuth: true
    //             }
    //         },
    //         {
    //             path: '/admin/subcategory/:id',
    //             name: 'admin.editsubcategory',
    //             component: () => import('@/components/backend/pages/subcategory/addSubcategory.vue'),
    //             meta: {
    //                 middleware: 'auth',
    //                 title: 'Edit Subcategory',
    //                 requiresAuth: true
    //             }
    //         },

    //         { //Product
    //             path: '/admin/product',
    //             name: 'admin.product',
    //             component: () => import('@/components/backend/pages/product/Products.vue'),
    //             meta: {
    //                 middleware: 'auth',
    //                 title: 'Products List',
    //                 requiresAuth: true
    //             }
    //         },
    //         {
    //             path: '/admin/addproduct',
    //             name: 'admin.addProduct',
    //             component: () => import('@/components/backend/pages/product/addProduct.vue'),
    //             meta: {
    //                 middleware: 'auth',
    //                 title: 'Products List',
    //                 requiresAuth: true
    //             }
    //         },
    //         {
    //             path: '/admin/editproduct/:id',
    //             name: 'admin.editProduct',
    //             component: () => import('@/components/backend/pages/product/addProduct.vue'),
    //             meta: {
    //                 middleware: 'auth',
    //                 title: 'Products List',
    //                 requiresAuth: true
    //             }
    //         },


    //         { // users
    //             path: '/admin/users',
    //             name: 'admin.users',
    //             component: () => import('@/components/backend/pages/users/Users.vue'),
    //             meta: {
    //                 middleware: 'auth',
    //                 title: 'Users List',
    //                 requiresAuth: true
    //             }
    //         },
    //         {
    //             path: '/admin/addUpdate',
    //             name: 'admin.adduser',
    //             component: () => import('@/components/backend/pages/users/addUser.vue'),
    //             meta: {
    //                 middleware: 'auth',
    //                 title: 'Users Add or Update',
    //                 requiresAuth: true
    //             }
    //         },
    //         {
    //             path: '/admin/useredit/:id',
    //             name: 'admin.userEdit',
    //             component: () => import('@/components/backend/pages/users/addUser.vue'),
    //             meta: {
    //                 middleware: 'auth',
    //                 title: 'Users Add or Update',
    //                 requiresAuth: true
    //             }
    //         },

    //         // {
    //         //     path: '/admin/setting',
    //         //     name: 'admin.setting',
    //         //     component: () => import('@/components/backend/setting/Setting.vue'),
    //         //     meta: {
    //         //         middleware: 'auth',
    //         //         title: 'Site Settings',
    //         //         requiresAuth: true
    //         //     }
    //         // },

    //         // {
    //         //     path: '/admin/profile',
    //         //     name: 'admin.profile',
    //         //     component: () => import('@/components/backend/setting/Profile.vue'),
    //         //     meta: {
    //         //         middleware: 'auth',
    //         //         title: 'Admin Profile',
    //         //         requiresAuth: true
    //         //     }
    //         // },

    //     ]
    // },

];


const router = createRouter({
    mode: 'history',
    history: createWebHistory(),
    routes,
});


router.beforeEach((to, from, next) => {
    document.title = `E-commerce - ${to.meta.title} | TailAdmin - Vue.js Tailwind CSS Dashboard Template`
    handleRouteMiddlwares(to, from, next);
    // next()
});



const handleRouteMiddlwares = async (to, from, next) => {
    const authStore = useAuthStore();
    const cartStore = useCartStore();
    cartStore.fetchCartItem();


    // if true
    if (to.meta.auth && !authStore.isAuthenticated) {
        next({ name: "login" });
    }

    // if (to.meta.auth || to.meta.guest && authStore.isAuthenticated) { 

    // }

    if (to.meta.auth && !authStore.user) {
        let response = await authStore.getUserDetail();
        if (!response.success) {
            authStore.flushUser();
            next({ name: "login" });
        }
    }

    if (to.meta.guest && authStore.isAuthenticated) {

        if(authStore.user.role_id===3){

        }
        
        // if (authStore.user) {
        //     next({ name: "home" });
        // }

        // let response = await authStore.getUserDetail();
        // if (response.success) {
        //     next({ name: "admin.dashboard" });
        // } else {
        //     // authStore.flushUser();
        // }
    }

    next();
}
export default router



