import Vue from 'vue';
import VueRouter from 'vue-router';

import Home from './pages/Home.vue';
import Add from './pages/Add.vue';
import Edit from './pages/Edit.vue';


Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    linkExactActiveClass: 'active',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/add',
            name: 'add',
            component: Add
        },
        {
            path: '/edit/:id',
            name: 'edit',
            component: Edit
          }
    ]
});

export default router;
