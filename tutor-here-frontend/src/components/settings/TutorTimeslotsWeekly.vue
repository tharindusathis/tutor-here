<template>
  <div>
    
    <b-list-group>
      <b-list-group-item v-if="api_data.length === 0" class="text-center">
          No one-time timeslots added.
      </b-list-group-item>
      <b-list-group-item v-for="item in api_data">
        <p style="text-align:left;">
          {{ item['start_time']}}<span v-if="item['city']">,</span>
          {{ item['end_time']}}
          {{ week[item['week_day']] }}
        <span style="float:right;"> 
          
          <b-button size="sm" variant="outline-danger" @click="deleteData( item['idWeeklyTimeslot'] )" >Remove</b-button> </span>
        </p>
      </b-list-group-item>
    </b-list-group>

    <b-button v-b-modal.modal-weekly  variant="outline-primary" >Add a repeating timeslot</b-button>

    <!-- ------------------------------------------ -->
    <div>
        <b-modal
          centered
          id="modal-weekly"
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
                  <label for="input-date-start">Day of week:</label>
                </b-col>
                <b-col sm="9">
                  <b-form-select id="input-date-start"  v-model="new_data.week_day" :options="week_options"></b-form-select>
                </b-col>
              </b-row>

            <b-row class="my-1">
                <b-col sm="3">
                  <label for="input-time-start">Start Time:</label>
                </b-col>
                <b-col sm="9">
                  <b-form-input id="input-time-start" type="time" v-model="new_data.start_time" description="ddd"></b-form-input>
                </b-col> 
              </b-row>
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
    name: 'TutorTimeslotWeekly',
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
          week_day: '1',
          start_time: '08:00',
          end_time: '16:00'
        },
        week_options: [
          { value: 1, text: 'Monday' },
          { value: 2, text: 'Tuesday' },
          { value: 3, text: 'Wednesday' },
          { value: 4, text: 'Thursday' },
          { value: 5, text: 'Friday'},
          { value: 6, text: 'Saturday'},
          { value: 7, text: 'Sunday'}   
        ],
        week: [
          "", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"
        ]
      }
    },
    methods: {
      listData() {
        this.$http.get('tutors/' + this.idTutor +'/weeklytimeslots')
        .then(response => {
          console.log(response.data); 
          this.api_data = response.data;
          console.log(this.api_data);
        });
      },
      resetModal() { 

      },
      handleOk(bvModalEvt) {
         //let town =  this.api_location_info[0].address_components[1].long_name;
         
         //this.new_data.start_time += ":00";
         //this.new_data.end_time += ":00"; 
         console.log("this.new_data");
         console.log(this.new_data);


        this.$http.post('weeklytimeslots', this.new_data)
          .then(response => {
            
            console.log(response);
            this.listData();
          }, error => {
            console.log(error);
          });
      },
      deleteData(id){
        this.$http.delete('weeklytimeslots/' + id)
            .then(response => {
              console.log(response.data);
              this.listData();
            });
      }
    },
    created() {
      this.listData();
      this.new_data.Tutor_idTutor = this.idTutor;  
    },
    computed: {
    }
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
    .modal{
        z-index: 20;   
    }
    .modal-backdrop{
        z-index: 10;        
    }
</style>