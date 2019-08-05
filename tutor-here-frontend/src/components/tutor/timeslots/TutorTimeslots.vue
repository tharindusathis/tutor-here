<template>
  <div>

    <b-card align="left" class="mt-3">
      <h6>One-time Timeslots</h6>
      <tutor-timeslots-single :idTutor='idTutor'></tutor-timeslots-single>

    </b-card>

    <b-card align="left" class="mt-4">
      <h6>Weekly Repeating Timeslots</h6>
      <tutor-timeslots-weekly :idTutor='idTutor' class="mt-2 mb-2"></tutor-timeslots-weekly>
    </b-card>
  </div>
</template>

<script>

  import TutorTimeslotsWeekly from './TutorTimeslotsWeekly.vue'
  import TutorTimeslotsSingle from './TutorTimeslotsSingle.vue'


  export default {
    name: 'TutorProfile',
    components: {
      TutorTimeslotsWeekly,
      TutorTimeslotsSingle
    },
    props: {
      idTutor: {
        default: 1
      }
    },
  }
</script> 

