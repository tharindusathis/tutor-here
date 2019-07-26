<template>
  <div>
    <b-list-group>
      <b-list-group-item v-for="subject in api_data">
        <p style="text-align:left;">
        {{ subject['subject_name'] }}, Level: {{ subject['grade'] }} 
        <span style="float:right;">Syllabus: {{ subject['syllabus_from'] }}</span>
        </p> 

        <p style="text-align:left;">
        Hourly Fee: <b-badge>{{ subject['hourly_rate'] }}</b-badge> 
        <span style="float:right;">
          <button class="btn btn-primary">Edit</button>
          <button class="btn btn-danger">Remove</button>
        </span>
        </p> 
      </b-list-group-item>
    </b-list-group>
    
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
    methods: {
      
    },
    created() {
      this.$http.get('tutors/' + this.idTutor +'/subjects')
        .then(response => {
          console.log(response.data); 
          this.api_data = response.data;
          console.log("ddd");
          console.log(this.api_data);
        });
    },
    computed: {
    }
  }
</script> 

<style scoped>
    
</style>