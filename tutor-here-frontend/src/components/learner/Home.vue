<template>
  <div>
    <find-tutor :id-learner="idLearner"></find-tutor>
  </div>
</template>

<script>
  import FindTutor from './search/FindTutor';

  export default {
    name: "Home",
    data() {
      return {
        idLearner: 1
      }
    },
    components: {
      FindTutor
    },
    created() {
      this.idLearner = this.$auth.getId()
    }
  }
</script>

<style scoped>

</style>