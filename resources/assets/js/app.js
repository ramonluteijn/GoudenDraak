import './bootstrap';

//styles
import "../sass/app.scss";

// Vue
import { createApp } from 'vue';
import marquee from './marquee.vue';
createApp(marquee).mount('#app');
