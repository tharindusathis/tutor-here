<template>
  <div id="app">
    <div class="page-container">
      <div class="">
        <router-view class="mt-4"></router-view>
      </div><!-- /.container -->
      <basic-footer></basic-footer>
    </div><!-- /.container -->
  </div>
</template>

<script>
  import Footer from '../basic/Footer.vue'

  export default {
    name: "DashboardVisitor",
    components: {
      basicFooter: Footer,
    },
    methods: {}
  }
</script>

<style scoped>

  .page-container {
    position: relative;
    min-height: 200vh;
  }
</style>