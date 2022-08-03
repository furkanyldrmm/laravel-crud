import {
    createWebHistory,
    createRouter
} from "vue-router";
import Product from './components/Products.vue';
import Create from './components/Create.vue';
import Edit from './components/Edit.vue';


const routes = [
    {
        name: 'home',
        path: '/',
        component: Product
    },
    {
        name: 'create',
        path: '/create',
        component: Create
    },
    {
        name: 'edit',
        path: '/edit/:id',
        component: Edit
    }
];

const router = createRouter({
    history:createWebHistory(),
    routes
});
export default router;
