import './bootstrap';
import { createApp } from 'vue';
import DashboardIndex from './components/DashboardIndex.vue';

const app = createApp({});

app.component('dashboard-index', DashboardIndex);

app.mount('#app');
