import Vue from 'vue'
import App from './App.vue'
import BootstrapVue from 'bootstrap-vue'
import VueResource from 'vue-resource';
import Router from './routes.js'
import VueBootstrapTypeahead from 'vue-bootstrap-typeahead'
import Vuelidate from 'vuelidate'
import * as VueGoogleMaps from "vue2-google-maps";
import Auth from './packages/auth/Auth.js'
import VueSlider from 'vue-slider-component'
import 'vue-slider-component/theme/default.css'

Vue.component('VueSlider', VueSlider)
Vue.use(Auth)

Vue.use(VueGoogleMaps, {
    load: {
        key: "AIzaSyCQjKoJ2wT5Crcy3oPnJN3wAbYojDSxJgM",
        libraries: "places" // necessary for places input
    }
});

Vue.config.productionTip = false
Vue.use(BootstrapVue)

Vue.use(VueResource);
Vue.http.options.root = 'http://localhost:8000/api/';

Vue.use(Vuelidate)

//Global Components
Vue.component('vue-typeahead', VueBootstrapTypeahead)


Router.beforeEach(
    (to, from, next) => {
        if (to.matched.some(record => record.meta.forVisitors)) {
            if (Vue.auth.isAuthenticated()) {
                next({
                    path: '/dashboard'
                })
            } else next()
        } else if (to.matched.some(record => record.meta.forAuth)) {
            if (!Vue.auth.isAuthenticated()) {
                next({
                    path: '/login'
                })
            } else next()
        } else next()

    }
)


import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'



new Vue({
    render: h => h(App),
    router: Router
}).$mount('#app')