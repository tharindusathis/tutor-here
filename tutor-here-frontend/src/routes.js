import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter);

import HelloWorld from './components/HelloWorld.vue'
import CreateSubject from './components/create/Subject.vue'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: "/add",
            component: CreateSubject
        }

    ]
})

export default router