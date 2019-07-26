<template>
  <div id="app">
    <div class="container">
      <basic-navbar></basic-navbar>
      <div class="row">
        <!-- Content Column -->
        <div class="col-lg-8">
          <router-view align="center"></router-view>
        </div>
        <!--Sidebar Widgets Column-->
        <!--<div class="col-md-4">-->
        <!--<basic-sidebar></basic-sidebar>-->
        <!--</div>-->
      </div><!-- /.row -->


    </div><!-- /.container -->
    <basic-footer></basic-footer>
  </div>
</template>

<script>

  import Navbar from './basic/NavbarTutor'
  import Sidebar from '../trash/Sidebar.vue'
  import Footer from '../basic/Footer.vue'

  export default {
    name: "DashboardTutor",
    components: {
      basicNavbar: Navbar,
      basicSidebar: Sidebar,
      basicFooter: Footer
    }
  }
</script>

<style scoped>

</style>