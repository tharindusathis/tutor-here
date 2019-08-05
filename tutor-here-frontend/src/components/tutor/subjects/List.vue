<template>
  <div class="mt-4">
    <b-list-group>
      <b-list-group-item v-for="subject in api_data">
        <p style="text-align:left;">
          <template class="float-left">{{ subject['subject_name'] }}, Level: {{ subject['grade'] }}</template>
          <span style="float:right;">Syllabus: {{ subject['syllabus_from'] }}</span>
        </p>

        <p style="text-align:left;">
          Hourly Fee:
          <b-badge><h6>{{ subject['hourly_rate'] }}</h6></b-badge>
          <span style="float:right;">
          <!--<button class="btn btn-primary">Edit</button>-->
          <b-button variant="outline-danger">Remove</b-button>
        </span>
        </p>
      </b-list-group-item>
    </b-list-group>


    <div class="mt-3">
      <router-link to="new_subject">
        <b-button class="mrl1 float-right" variant="primary">
          Add or Create a Subject
        </b-button>
      </router-link>
    </div>

  </div>
</template>

<script>

  export default {
    name: 'TutorSubjects',
    props: {
      idTutor: {
        default: 1,
        type: Number
      }
    },
    data() {
      return {
        api_data: []
      }
    },
    methods: {},
    created() {
      this.$loading(true);
      this.$http.get('tutors/' + this.idTutor + '/subjects')
        .then(response => {
          console.log(response.data);
          this.$loading(false);
          this.api_data = response.data;
          console.log("ddd");
          console.log(this.api_data);
        }, error => {
          this.$loading(false)
          console.log(error);
        });
    },
    computed: {}
  }
</script>

<style scoped>

</style>