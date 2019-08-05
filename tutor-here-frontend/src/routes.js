import Vue from 'vue'
import VueRouter from 'vue-router'
import Auth from './packages/auth/Auth.js'

Vue.use(Auth)
Vue.use(VueRouter);

import Login from './components/auth/LoginPage.vue'
import RegisterTutor from './components/auth/RegisterTutor.vue'
import RegisterLearner from './components/auth/RegisterLearner.vue'
import RegisterComplete from './components/auth/RegisterSuccessful'

import DashboardVisitor from './components/auth/DashboardVisitor'

import DashboardTutor from './components/tutor/DashboardTutor.vue'
import DashboardLearner from './components/learner/DashboardLearner.vue'

//tutor
import TutorHome from './components/tutor/Home.vue'
import CreateSubject from './components/tutor/subjects/Create.vue'
import TutorSubjects from './components/tutor/subjects/List'
import TutorProfile from './components/tutor/settings/TutorProfile.vue'
import TutorTuition from './components/tutor/tuitions/Tuition'
import TutorTimeslots from './components/tutor/timeslots/TutorTimeslots.vue'
import TutorRequests from './components/tutor/tuitions/RequestsTable'

//learner
import LearnerHome from './components/learner/Home.vue'
import LearnerProfile from './components/learner/settings/LearnerProfile.vue'
import FindTutors from './components/learner/search/FindTutor.vue'
import LearnerRequests from './components/learner/tuitions/RequestTable'
import LearnerTuition from './components/learner/tuitions/Tuition'


//test only
import Hello from './components/trash/HelloWorld.vue'
//import Test from './components/learner/DashboardLearner.vue'
//import Test2 from './components/trash/universal/CreateNew.vue'
import TestChild2 from './components/tutor/tuitions/RequestsTable.vue'


const router = new VueRouter({
  mode: 'history',
  routes: [

    {
      path: "/test",
      component: DashboardLearner,
      children: [{
        path: "a",
        component: TestChild2,
      }, {
        path: "b",
        component: TestChild2,
      }]
    }, {
      path: "/test2",
      component: TestChild2,
    }, {
      path: "/hello",
      component: Hello,
    },


    {
      path: "/dashboard_learner",
      name: "Learner Dashboard",
      redirect: "/dashboard_learner/home",
      component: DashboardLearner,
      meta: {
        forAuth: true,
        forLearner: true
      },
      children: [
        {
          path: "home",
          name: "Learner Home",
          component: LearnerHome,
        }, {
          path: "profile",
          name: "Edit Profile",
          component: LearnerProfile,
          props: {idLearner: Vue.auth.getId()}
        }, {
          path: "find_tutors",
          name: "Find Tutors",
          component: FindTutors,
          props: {idLearner: Vue.auth.getId()}
        }, {
          path: "requests",
          name: "Tuitions",
          component: LearnerRequests,
          props: {idLearner: Vue.auth.getId()}
        }, {
          path: "tuition/:idRequest",
          name: "Tuition",
          component: LearnerTuition,
          props: true,
        }
      ]
    }, {
      path: "/dashboard_tutor",
      name: "Tutor Dashboard",
      component: DashboardTutor,
      redirect: "/dashboard_tutor/home",
      meta: {
        forAuth: true,
        forTutor: true
      },
      children: [
        {
          path: "home",
          name: "Tutor Home",
          component: TutorHome,
        }, {
          path: "profile",
          name: "Edit Profile",
          component: TutorProfile,
          props: {idTutor: Vue.auth.getId()}
        }, {
          path: "timeslots",
          name: "Edit Timeslots",
          component: TutorTimeslots,
          props: {idTutor: Vue.auth.getId()}
        }, {
          path: "subjects",
          name: "Subjects",
          component: TutorSubjects,
          props: {idTutor: Vue.auth.getId()}
        }, {
          path: "new_subject",
          name: "New Subjects",
          component: CreateSubject,
          props: {idTutor: Vue.auth.getId()}
        }, {
          path: "requests",
          name: "Tuitions",
          component: TutorRequests,
          props: {idTutor: Vue.auth.getId()}
        }, {
          path: "tuition/:idRequest",
          name: "Tuition",
          component: TutorTuition,
          props: true,
        }
      ]
    },
    {
      path: "/",
      redirect: "/login",
      meta: {
        forVisitors: true
      }
    },
    {
      path: "/v",
      redirect: "/login",
      component: DashboardVisitor,
      meta: {
        forVisitors: true
      },
      children: [
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
        {
          path: "/register_confirm",
          name: "RegisterFinish",
          component: RegisterComplete,
          meta: {
            forVisitors: true
          }
        }
      ]
    },

  ]
})

export default router