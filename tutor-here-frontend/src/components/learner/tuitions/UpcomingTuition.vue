<template>
  <b-card>
    <h6>Tutions Status</h6>

    <div v-for="item in items" v-if="(item.status != 2)&&(item.status != 9)&&(item.status != 5)">
      <router-link :to="`tuition/${ parseInt(item.idRequest) }`">
        <b-card>
          <!--:title="(item.subject_name)">-->
          <!--&lt;!&ndash;img-src="https://picsum.photos/600/300/?image=25"&ndash;&gt;-->
          <!--&lt;!&ndash;img-alt="Image"&ndash;&gt;-->
          <!--&lt;!&ndash;img-top&ndash;&gt;-->
          <!--&lt;!&ndash;tag="article"&ndash;&gt;-->
          <!--&lt;!&ndash;style="max-width: 20rem;"&ndash;&gt;-->
          <!--&lt;!&ndash;class="mb-2"&ndash;&gt;-->
          <!--<b-card-text>-->

          <h6>{{ item.subject_name }}

            <b-badge v-if="item.status == 0" pill variant="primary">PENDING</b-badge>
            <b-badge v-if="item.status == 2" pill variant="danger">DECLINED</b-badge>
            <b-badge v-if="item.status == 1" pill variant="success">ACCEPTED</b-badge>
            <b-badge v-if="item.status == 9" pill variant="secondary">DELETED</b-badge>
            <b-badge v-if="item.status == 4" pill variant="warning">STARTED</b-badge>
            <b-badge v-if="item.status == 5" pill variant="info">FINISHED</b-badge>
            <b-badge v-if="item.status == 3" pill variant="warning">ARRIVING</b-badge>

          </h6>
          <p>{{ item.tutor_name }}</p>
          <h6>
            <div class="row ml-1">
              <div>
                <b-badge align="center" variant="dark">{{ item.date }}</b-badge>
              </div>
              <div class="ml-auto mr-3">
                <b-badge align="center" variant="dark">{{ item.start_time }}</b-badge>
              </div>
            </div>
          </h6>

          <!--</b-card-text>-->

        </b-card>
      </router-link>
    </div>
  </b-card>

</template>

<script>
  import VueBootstrapTypeaheadList from "vue-bootstrap-typeahead/src/components/VueBootstrapTypeaheadList";

  export default {
    name: "RequestsSideBar",
    components: {VueBootstrapTypeaheadList},
    props: {
      idLearner: {
        default: 1,
        type: Number
      }
    },
    data() {
      return {
        items: []
      }
    },
    mounted() {
      this.loadContent();
    },
    methods: {
      loadContent() {
        this.$http.get('learners/' + this.idLearner + '/requests')
          .then(response => {
            console.log(response);
            this.items = response.data;
          }, error => {
            console.log(error);
            this.items = [];
          });
      }
    }
  }
</script>

<style scoped>

</style>