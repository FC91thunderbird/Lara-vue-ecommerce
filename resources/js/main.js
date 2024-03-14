// import './bootstrap';

// import { createApp } from 'vue';
// import router from '@/router';

// import { createPinia } from 'pinia';

// const pinia = createPinia();
// const app = createApp();
// app.use(pinia).use(router).mount('#app');

import './bootstrap';
import router from '@/router';
import { createPinia } from 'pinia';
import globalApp from '@/services/Global';

const pinia = createPinia();
const app = globalApp.use(pinia).use(router);

app.mount('#app');