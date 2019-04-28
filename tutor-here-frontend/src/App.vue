<template>
  <div id="app">
    <div class="container">
      <app-navbar></app-navbar>
      <div class="row">
        <!-- Content Column -->
        <div class="col-lg-8">
            <student-profile></student-profile>  
            <!-- <app-tutor-subjects></app-tutor-subjects> -->
            <router-view></router-view>
        </div>
        <!-- Sidebar Widgets Column -->
        <div class="col-md-4">
            <app-sidebar></app-sidebar>
        </div>
      </div><!-- /.row -->
    </div><!-- /.container -->
    <app-footer></app-footer>
  </div>
</template>

<script>

import TutorLocations from './components/settings/TutorLocations.vue'
import LearnerLocations from './components/settings/LearnerLocations.vue'
import StudentProfile from './components/settings/StudentProfile.vue'
import CreateSubject from './components/create/Subject.vue'
import TeacherSubjects from './components/list/TeacherSubjects.vue'
import TutorSubjects from './components/list/TutorSubjects.vue'
import Navbar from './components/basic/Navbar.vue'
import Sidebar from './components/basic/Sidebar.vue'
import Footer from './components/basic/Footer.vue'

export default {
  name: 'app',
  components: {
    appCreateSubject: CreateSubject,
    appNavbar: Navbar,
    appSidebar: Sidebar,
    appFooter: Footer,
    appTeacherSubjects: TeacherSubjects,
    appTutorSubjects: TutorSubjects,
    TutorLocations,
    LearnerLocations,
    StudentProfile
  }
}
</script>

<style>
#app {
  font-family: 'montserrat' , sans-serif;
  font-size: small;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
   color: #2c3e50;
  margin: 60px; 
}
</style>
