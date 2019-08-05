<template>
  <div> <!--style="max-width: 30rem;"-->
    <b-card
        no-body
    >
      <h4 slot="header" align="center">Tuition Status</h4>

      <b-card-body align="center">
        <b-card-title>
          {{ data.subject_name }}
        </b-card-title>
        <b-card-sub-title class="mb-2">{{ data.syllabus }}</b-card-sub-title>
        <b-card-text>
          <p><b>Tutor: </b>{{ data.tutor_name }}</p>
          <p>{{ data.tutor_mobile }}</p>
          <p>{{ data.tutor_email }}</p>
        </b-card-text>
      </b-card-body>

      <b-list-group flush>
        <b-list-group-item>
          <b-row>
            <b-col sm="6">
              <b-card align="center">
                <h5>
                  <b-badge variant="dark">{{ data.start_time }}</b-badge>
                </h5>
              </b-card>
            </b-col>
            <b-col sm="6">
              <b-card align="center">
                <h5>
                  <b-badge variant="dark">{{ data.end_time }}</b-badge>
                </h5>
              </b-card>
            </b-col>
          </b-row>
        </b-list-group-item>
      </b-list-group>

      <b-list-group flush>
        <b-list-group-item>
          <b-row>
            <b-col sm="6">
              <b-card class="w-100" align="center" border-variant="primary"><h6>Fare: {{ data.payment }}</h6></b-card>
            </b-col>
            <b-col sm="6">
              <b-card class="w-100" align="center" border-variant="primary"><h6> {{ data.dist }} KM</h6></b-card>
            </b-col>
          </b-row>
        </b-list-group-item>
      </b-list-group>

      <b-list-group flush>
        <b-list-group-item>
          <b-row>
            <b-col sm="12">
              <a :href="this.getLocationLink()" target="_blank">
                <b-card class="w-100" align="center" border-variant="primary"><h6> {{ data.address }}</h6></b-card>
              </a>
            </b-col>
          </b-row>
        </b-list-group-item>
      </b-list-group>


      <b-list-group-item v-if="(parseInt(data.status) === 0)" align="center" variant="warning">PENDING
      </b-list-group-item>
      <b-list-group-item v-if="(parseInt(data.status) === 1)" align="center" variant="success">REQUEST ACCEPTED
      </b-list-group-item>
      <b-list-group-item v-if="(parseInt(data.status) === 3)" align="center" variant="warning">TRAVELLING
      </b-list-group-item>
      <b-list-group-item v-if="(parseInt(data.status) === 2)" align="center" variant="danger">DECLINED
      </b-list-group-item>
      <b-list-group-item v-if="(parseInt(data.status) === 4)" align="center" variant="warning">STARTED
      </b-list-group-item>
      <b-list-group-item v-if="(parseInt(data.status) === 5)" align="center" variant="warning">FINISHED
      </b-list-group-item>


      <b-list-group-item v-show="(parseInt(data.status) === 5)">
        <b-row>
          <b-col sm="6">
            <star-rating v-model="rating" v-bind:star-size="40"></star-rating>

          </b-col>
          <b-col sm="6">
            <b-button block variant="success" @click="submitReview()"> RATE
            </b-button>
          </b-col>
        </b-row>
      </b-list-group-item>

      <!--<b-list-group-item>-->
      <!--<b-button v-if="(parseInt(data.status) === 0)" variant="danger" block @click="declineRequest()"> RATE-->
      <!--</b-button>-->
      <!--</b-list-group-item>-->


      <b-list-group-item>
        <b-button v-if="(parseInt(data.status) === 0)" variant="danger" block @click="declineRequest()">DECLINE
          REQUEST
        </b-button>
      </b-list-group-item>

    </b-card>
  </div>
</template>

<script>
  export default {
    props: {
      idTutor: {
        default: 1,
        type: Number
      },
      idRequest: {
        default: 1,
        type: Number
      }
    },
    data() {
      return {
        rating: 0,
        data: {
          idRequest: 1,
          idLearner: 1,
          status: 1,
          date: "2019-01-01",
          dist: 888,
          payment: 0,
          start_time: 0,
          end_time: 1,
          learner_name: "Tutor",
          tutor_name: "",
          tutor_rating: "",
          syllabus: "",
          subject_name: "",
          tutor_mobile: 0,
          address: "",
          district: 400,
          tutor_email: "",
          lat: 400,
          lng: 400,
        }
      }
    },
    created() {
      this.getstatus();
    },
    mounted() {
    },
    methods: {
      getstatus() {
        this.$loading(true);
        this.$http.get('request/' + this.idRequest)
          .then(response => {
            this.data = response.data[0];
            console.log(response.data);
            this.$loading(false);
          }).catch(error => {
          this.$loading(false);
          console.log("err");
          console.log(error);
          console.log(error.data);
        });
      }
      ,
      accpetRequest() {
        this.data.status = 1;
        this.$http.get('request/accept/' + this.idRequest)
          .then(response => {
            console.log(response);
          }, error => {
            console.log(error);
          });
      }
      ,
      declineRequest() {
        this.data.status = 2;
        this.$http.get('request/decline/' + this.idRequest)
          .then(response => {
            console.log(response);
          }, error => {
            console.log(error);
          });
      }
      ,
      comingRequest() {
        this.data.status = 3;
        this.$http.get('request/coming/' + this.idRequest)
          .then(response => {
            console.log(response);
          }, error => {
            console.log(error);
          });
      }
      ,
      startRequest() {
        this.data.status = 4;
        this.$http.get('request/start/' + this.idRequest)
          .then(response => {
            console.log(response);
          }, error => {
            console.log(error);
          });

        let tuition = {
          'status': '1',
          'Request_idRequest': this.idRequest
        }

        this.$http.post('tuitions', tuition)
          .then(response => {
            console.log(response);
          }, error => {
            console.log(error);
          });
      }
      ,
      finishRequest() {
        this.data.status = 5;
        this.$http.get('request/finish/' + this.idRequest)
          .then(response => {
            console.log(response);
          }, error => {
            console.log(error);
          });

        let payment = {
          'method': '1',
          'Tuition_Request_idRequest': this.idRequest
        }

        this.$http.post('payments', payment)
          .then(response => {
            console.log(response);
          }, error => {
            console.log(error);
          });
      }
      ,
      submitReview() {
        let review = {
          'rating': this.rating,
          'Tuition_Request_idRequest': this.idRequest
        }

        this.$http.post('reviews', review)
          .then(response => {
            console.log(response);
          }, error => {
            console.log(error);
          });
      }
      ,
      getLocationLink() {
        let url = "https://www.google.com/maps/search/?api=1&query=" + this.data.lat + "," + this.data.lng;
        return url;
      }
    }
  }
</script>