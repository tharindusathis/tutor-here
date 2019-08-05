<template>
  <div>
    <requests-table :idTutor="idTutor"></requests-table>
  </div>
</template>

<script>
  import RequestsTable from './tuitions/RequestsTable';

  export default {
    name: "Home",
    components: {
      RequestsTable
    },
    data() {
      return {
        idTutor: 1
      }
    },
    created() {
      this.idTutor = this.$auth.getId()
    }
    ,
  }
</script>

<style scoped>

</style>