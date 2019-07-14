import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter);
import CreateSubject from './components/create/Subject.vue'
import EditSubject from './components/edit/Subject.vue'
import LearnerProfile from './components/settings/LearnerProfile.vue'
import TutorProfile from './components/settings/TutorProfile.vue'
import TutorTimeslots from './components/settings/TutorTimeslots.vue'

import Login from './components/auth/Login.vue'
import Register from './components/auth/Register.vue'
import DashboardTutor from './components/pages/DashboardTutor.vue'
import DashboardLearner from './components/pages/DashboardLearner.vue'
import LoginPage from './components/pages/LoginPage.vue'
import RegisterTutor from './components/pages/RegisterTutor.vue'
import RegisterLearner from './components/pages/RegisterLearner.vue'


import Hello from './components/HelloWorld.vue'
import Test from './components/pages/DashboardLearner.vue'
import Test2 from './components/universal/CreateNew.vue'
import FindTutors from './components/learner/FindTutor.vue'
//import TestChild from './components/learner/Request.vue'
import TestChild from './components/learner/TutorSearchResult.vue'



const router = new VueRouter({
    mode: 'history',
    routes: [{
            path: "/test",
            component: Test,
            children: [{
                path: "a",
                component: TestChild,
            }, {
                path: "b",
                component: TestChild,
            }]
        }, {
            path: "/dashboard_learner",
            name: "Dashboard",
            component: DashboardLearner,
            meta: {
                forAuth: true
            },
            children: [{
                path: "profile",
                name: "Edit Profile",
                component: LearnerProfile,
            }, {
                path: "find_tutors",
                name: "Find Tutors",
                component: FindTutors,
            }, ]
        }, {
            path: "/dashboard_tutor",
            name: "Dashboard",
            component: DashboardTutor,
            meta: {
                forAuth: true
            },
            children: [{
                path: "s",
                name: "CreateSubject",
                component: LoginPage,
            }]
        },
        {
            path: "/login",
            name: "Login",
            component: Login,
            meta: {
                forVisitors: true
            }
        },
        {
            path: "/register_tutor",
            name: "RegisterTutor",
            component: RegisterTutor,
            meta: {
                forVisitors: true
            }
        },
        {
            path: "/register_learner",
            name: "RegisterLearner",
            component: RegisterLearner,
            meta: {
                forVisitors: true
            }
        },
    ]
})

export default router