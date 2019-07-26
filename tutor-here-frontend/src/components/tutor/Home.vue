<template>
  <div>
    <requests-table></requests-table>
  </div>
</template>

<script>
  import RequestsTable from './tuitions/RequestsTable';

  export default {
    name: "Home",
    components: {
      RequestsTable
    }
  }
</script>

<style scoped>

</style>