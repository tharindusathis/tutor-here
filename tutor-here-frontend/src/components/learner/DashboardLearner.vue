<template>
  <div id="app">
    <div class="container">
      <basic-navbar></basic-navbar>
      <div class="row" v-if="(this.$route.path == '/dashboard_learner/requests')">
        <!-- Content Column -->
        <div class="col-lg-12">
          <router-view></router-view>
        </div>
        <!-- Sidebar Widgets Column -->
        <!--<div class="col-md-4">-->
        <!--<basic-sidebar></basic-sidebar>-->
        <!--</div>-->
      </div><!-- /.row -->


      <div class="row" v-if="(this.$route.path != '/dashboard_learner/requests')">
        <!-- Content Column -->
        <div class="col-lg-8">
          <router-view></router-view>
        </div>
        <!-- Sidebar Widgets Column -->
        <div class="col-md-4">
          <basic-sidebar></basic-sidebar>
        </div>
      </div><!-- /.row -->


    </div><!-- /.container -->
    <basic-footer></basic-footer>
  </div>
</template>

<script>

  import Navbar from './basic/NavbarLearner.vue'
  import Sidebar from './basic/Aside.vue'
  import Footer from '../basic/Footer.vue'

  export default {
    name: "DashboardTutor",
    components: {
      basicNavbar: Navbar,
      basicSidebar: Sidebar,
      basicFooter: Footer
    },
    methods: {
      showSideBar() {
        if (this.$route.path != '/dashboard_learner/requests')
          return true;
        else
          return false;
      }
    }
  }
</script>

<style scoped>

</style>