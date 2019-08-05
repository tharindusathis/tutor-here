<template>
  <div>
    <b-list-group class="mt-4 mb-3">
      <b-list-group-item v-if="api_data.length === 0" class="text-center">
        No one-time timeslots added.
      </b-list-group-item>
      <b-list-group-item v-for="item in api_data">
        <p>
        <span style="float:left;">
          <h5><b-badge variant="dark">{{ item['start_datetime']}}</b-badge> -
            <b-badge variant="dark">{{ item['end_datetime']}}</b-badge>
        </h5></span>
          <span style="float:right;">
          
          <b-button block variant="outline-danger"
                    @click="deleteData( item['idSingleTimeslot'] )">Remove</b-button> </span>
        </p>
      </b-list-group-item>
    </b-list-group>

    <b-button v-b-modal.modal-single variant="outline-primary">Add a one-time timeslot</b-button>

    <!-- ------------------------------------------ -->
    <div>
      <b-modal

          id="modal-single"
          ref="modal"
          title="Add a new timeslot"
          @show="resetModal"
          @hidden="resetModal"
          @ok="handleOk"
          ok-title="Add Timeslot"
          class="pac-container"
      >

        <template>
          <b-container fluid>
            <b-row class="my-1">
              <b-col sm="3">
                <label for="input-date-start">Date:</label>
              </b-col>
              <b-col sm="9">
                <b-form-input id="input-date-start" type="date" v-model="new_data.start_date"></b-form-input>
              </b-col>
            </b-row>

            <b-row class="my-1">
              <b-col sm="3">
                <label for="input-time-start">Start Time:</label>
              </b-col>
              <b-col sm="9">
                <b-form-input id="input-time-start" type="time" v-model="new_data.start_time"
                              description="ddd"></b-form-input>
              </b-col>
            </b-row>
            <!--<b-row class="my-1">-->
            <!--<b-col sm="3">-->
            <!--<label for="input-date-end">End Date:</label>-->
            <!--</b-col>-->
            <!--<b-col sm="9">-->
            <!--<b-form-input id="input-date-end" type="date" v-model="new_data.end_date"></b-form-input>-->
            <!--</b-col>-->
            <!--</b-row>-->
            <b-row class="my-1">
              <b-col sm="3">
                <label for="input-time-end">End Time:</label>
              </b-col>
              <b-col sm="9">
                <b-form-input id="input-time-end" type="time" v-model="new_data.end_time"></b-form-input>
              </b-col>
            </b-row>
          </b-container>
        </template>
      </b-modal>
    </div>
  </div>
</template>

<script>

  export default {
    name: 'TutorTimeslotSingle',
    props: {
      idTutor: {
        default: 1
      }
    },
    data() {
      return {
        api_data: [],
        new_data: {
          Tutor_idTutor: '',
          start_date: new Date().toJSON().slice(0, 10),
          end_date: new Date().toJSON().slice(0, 10),
          start_time: '08:00',
          end_time: '16:00',
          start_datetime: '',
          start_datetime: ''
        },
        new_data_sending: {
          Tutor_idTutor: '',
          start_datetime: '',
          start_datetime: ''
        }
      }
    },
    methods: {
      listData() {
        this.$loading(true)
        this.$http.get('tutors/' + this.idTutor + '/singletimeslots')
          .then(response => {
            console.log(response.data);
            this.$loading(false);
            this.api_data = response.data;
            console.log(this.api_data);
          }, error => {

            this.$loading(false)
            console.log(error);
          });
      },
      resetModal() {

      },
      handleOk(bvModalEvt) {
        //let town =  this.api_location_info[0].address_components[1].long_name;
        let st_datetime = this.new_data.start_date;
        st_datetime = st_datetime + " " + this.new_data.start_time + ":00";
        this.new_data_sending.start_datetime = st_datetime;
        let en_datetime = this.new_data.start_date;
        en_datetime = en_datetime + " " + this.new_data.end_time + ":00";
        this.new_data_sending.end_datetime = en_datetime;


        console.log("this.new_data_sending");
        console.log(this.new_data_sending);

        this.$http.post('singletimeslots', this.new_data_sending)
          .then(response => {

            console.log(response);
            this.listData();
          }, error => {
            console.log(error);
          });
      },
      deleteData(id) {
        this.$http.delete('singletimeslots/' + id)
          .then(response => {
            console.log(response.data);
            this.listData();
          });
      }
    },
    created() {
      this.listData();
      this.new_data.Tutor_idTutor = this.idTutor;
      this.new_data_sending.Tutor_idTutor = this.idTutor;
    },
    computed: {}
  }
</script>

<style scoped>
  .pac-container {
    background-color: #FFF;
    z-index: 20;
    position: fixed;
    display: inline-block;
    float: left;
  }

  .modal {
    z-index: 20;
  }

  .modal-backdrop {
    z-index: 10;
  }
</style>