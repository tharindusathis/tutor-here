<template>
  <div id="app">
    <div class="container">
      <basic-navbar></basic-navbar>
      <div class="row">
        <!-- Content Column -->
        <div v-bind:class="[showSideBar ? styles.colLg8 : styles.colLg12]">
          <router-view align="center"></router-view>
        </div>

        <div v-show="showSideBar" v-bind:class="styles.colLg4">
          <basic-sidebar></basic-sidebar>
        </div>
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
    data() {
      return {
        idTutor: 1,
        styles: {
          colLg4: 'col-lg-4',
          colLg8: 'col-lg-8',
          colLg12: 'col-lg-12',
        }
      }
    },
    components: {
      basicNavbar: Navbar,
      basicSidebar: Sidebar,
      basicFooter: Footer
    },
    created() {
      // if (true) {
      //   console.log(this.$route.path);
      // }
    },
    created() {
      this.idTutor = this.$auth.getId()
    },

    computed: {
      showSideBar() {
        console.log(this.$route.path);
        if (this.$route.path != '/dashboard_tutor/requests') {
          return true;
          console.log("yass");
        }
        else {
          console.log("nooooo");
          return false;
        }
      }
    }
  }
</script>

<style scoped>

</style>