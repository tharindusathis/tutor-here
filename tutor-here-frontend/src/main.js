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
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import VueLoading from 'vuejs-loading-plugin'


import {library} from '@fortawesome/fontawesome-svg-core'
import {faUser, faLock, faAt} from '@fortawesome/free-solid-svg-icons'
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome'
import StarRating from 'vue-star-rating'

library.add(faUser, faLock, faAt)

Vue.component('font-awesome-icon', FontAwesomeIcon)

Vue.component('star-rating', StarRating);

// using default options
Vue.use(VueLoading)
// overwrite defaults
// Vue.use(VueLoading, {
//   dark: true, // default false
//   text: 'Ladataan', // default 'Loading'
//   loading: true, // default false
//   // customLoader: myVueComponent, // replaces the spinner and text with your own
//   background: 'rgb(255,255,255)', // set custom background
//   classes: ['myclass'] // array, object or string
// })


Vue.component('VueSlider', VueSlider)
Vue.use(Auth)

Vue.use(VueGoogleMaps, {
  load: {
    // key: "AIzaSyBnyQVq-k9hIIXGUlAHggymb0k1Mi_q37E",
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

//Global constants
Vue.prototype.$USER_TYPE_TUTOR = '1'
Vue.prototype.$USER_TYPE_LEARNER = 2


Router.beforeEach(
  (to, from, next) => {
    if (to.matched.some(record => record.meta.forVisitors)) {
      if (Vue.auth.isAuthenticated() && Vue.auth.getType() == 2) {
        next({
          path: '/dashboard_learner'
        })
      } else if (Vue.auth.isAuthenticated() && Vue.auth.getType() == 1) {
        next({
          path: '/dashboard_tutor'
        })
      } else next()
    } else if (to.matched.some(record => record.meta.forAuth)) {
      if (!Vue.auth.isAuthenticated()) {
        next({
          path: '/login'
        })
      } else next()
    } else next()

  },
  console.log("id: " + Vue.auth.getId())
)


new Vue({
  render: h => h(App),
  router: Router
}).$mount('#app')