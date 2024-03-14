
import { createApp } from 'vue';
import Pagination from '@/common/Pagination.vue';
import ValidationMessage from '@/common/ValidationMessage.vue';

import adminLayout from '@/components/adminLayout.vue'
import userLayout from '@/components/userLayout.vue';

const app = createApp();

// Register global components
app.component('Pagination', Pagination);
app.component('ValidationMessage', ValidationMessage);
app.component('adminLayout', adminLayout);
app.component('userLayout', userLayout);

export default app;