<template>
  <div>
    <b-card>
          <h4>Onetime Timeslots</h4>
          <tutor-timeslots-single :idTutor='idTutor'></tutor-timeslots-single>
    </b-card>
    <b-card>
          <h4>Repeating Timeslots</h4>
          <tutor-timeslots-weekly :idTutor='idTutor'></tutor-timeslots-weekly>
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

