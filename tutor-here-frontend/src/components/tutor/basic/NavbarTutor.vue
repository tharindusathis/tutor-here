<template>
  <div>

    <b-navbar toggleable="lg" class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <router-link to="/">
          <b-navbar-brand href="/">TutorHere</b-navbar-brand>
        </router-link>

        <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

        <b-collapse id="nav-collapse" is-nav>
          <b-navbar-nav>
            <b-nav-item to="requests">Requests</b-nav-item>
            <b-nav-item to="timeslots">Timeslots</b-nav-item>
            <b-nav-item to="subjects">Subjects</b-nav-item>
            <b-nav-item to="profile">Profile</b-nav-item>
          </b-navbar-nav>

          <!-- Right aligned nav items -->
          <b-navbar-nav class="ml-auto">

            <b-nav-item-dropdown text="Notificiations" right>
              <b-dropdown-item href="#" v-for="item in notifications">
                {{item}}
              </b-dropdown-item>
            </b-nav-item-dropdown>

            <b-nav-item-dropdown text="Messages" right>
              <b-dropdown-item href="#" v-for="item in messages">
                {{item}}
              </b-dropdown-item>
            </b-nav-item-dropdown>

            <b-nav-item-dropdown text="User" right>
              <!--<router-link to="/dashboard_tutor/profile">-->
              <b-dropdown-item to="profile">Profile</b-dropdown-item>
              <b-dropdown-item @click="signout">Sign Out</b-dropdown-item>
            </b-nav-item-dropdown>

          </b-navbar-nav>
        </b-collapse>
      </div>
    </b-navbar>
  </div>
</template>

<script>
  export default {
    name: 'NavbarTutor',
    data() {
      return {
        notifications: ['THis is good', 'Yeah sure'],
        messages: ['Msg 1', 'Dr Doe'],
      }
    },
    methods: {
      signout() {
        this.$auth.destroyToken();
        this.$router.push("/login");
      },
      editProfile() {
        this.$router.push("/dashboard_tutor/profile");
      }
    }
  }
</script>

<style scoped>

</style>