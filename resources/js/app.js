import './bootstrap';

import {createApp} from 'vue';
import router from './router.js'
import axios from 'axios'
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

import App from './components/Home.vue'

const app = createApp(App).use(router).use(VueSweetalert2);

app.config.globalProperties.axios = axios
app.mount("#app")
