<template>
  <div> <!--style="max-width: 30rem;"-->
    <b-card
        no-body

        :img-src="require('../../../assets/pc.jpg')"
        img-alt="Image"
        img-top
    >
      <h4 slot="header" align="center">Tuition Request</h4>

      <b-card-body align="center">
        <b-card-title>
          {{ data.subject_name }}
        </b-card-title>
        <b-card-sub-title class="mb-2">{{ data.syllabus }}</b-card-sub-title>
        <b-card-text>
          <p><b>Learner: </b>{{ data.learner_name }}</p>
          <p>{{ data.mobile }}</p>
          <p>{{ data.email }}</p>
        </b-card-text>
      </b-card-body>

      <b-list-group flush>
        <b-list-group-item>
          <b-row>
            <b-col sm="6">
              <b-card align="center">{{ data.start_time }}</b-card>
            </b-col>
            <b-col sm="6">
              <b-card align="center">{{ data.end_time }}</b-card>
            </b-col>
          </b-row>
        </b-list-group-item>

        <b-list-group-item>{{ data.address }}</b-list-group-item>


        <b-list-group-item v-if="(parseInt(data.status) === 0)" align="center" variant="warning">PENDING
        </b-list-group-item>
        <b-list-group-item v-if="(parseInt(data.status) === 1)" align="center" variant="success">REQUEST ACCEPTED
        </b-list-group-item>
        <b-list-group-item v-if="(parseInt(data.status) === 3)" align="center" variant="warning">TRAVELLING
        </b-list-group-item>
        <b-list-group-item v-if="(parseInt(data.status) === 2)" align="center" variant="warning">DECLINED
        </b-list-group-item>
        <b-list-group-item v-if="(parseInt(data.status) === 4)" align="center" variant="warning">STARTED
        </b-list-group-item>
        <b-list-group-item v-if="(parseInt(data.status) === 5)" align="center" variant="warning">FINISHED
        </b-list-group-item>

        <b-list-group-item>
          <b-button v-if="(parseInt(data.status) === 0)" variant="primary" block @click="accpetRequest()">ACCEPT
            REQUEST
          </b-button>
          <b-button v-if="(parseInt(data.status) === 0)" variant="danger" block @click="declineRequest()">DECLINE
            REQUEST
          </b-button>
          <b-button v-if="(parseInt(data.status) === 1)" variant="primary" block @click="comingRequest()">START TO GO
          </b-button>
          <b-button v-if="(parseInt(data.status) === 3)" variant="primary" block @click="startRequest()">START TUITION
          </b-button>
          <b-button v-if="(parseInt(data.status) === 4)" variant="primary" block @click="finishRequest()">COLLECT FEES
          </b-button>
        </b-list-group-item>
      </b-list-group>

      <b-card-body>
        <a href="#" class="card-link">Card link</a>
        <a href="#" class="card-link">Another link</a>
      </b-card-body>


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
        data: {
          idRequest: 1,
          idLearner: 1,
          status: 1,
          date: "2019-01-01",
          dist: 12,
          payment: 12,
          start_time: 12,
          end_time: 12,
          learner_name: "Davided Watson",
          syllabus: "Grade 10, dfdfs",
          subject_name: "Science",
          mobile: 4003443234,
          address: "sfsdf",
          district: 400,
          email: "ff@dd.c",
          lat: 400,
          lng: 400,
        }
      }
    },
    created() {
      this.getstatus();
    }
    ,
    methods: {
      getstatus() {
        this.$http.get('request/' + this.idRequest)
          .then(response => {
            this.data = response.data[0];
            console.log(response.data);
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
      },
    }
  }
</script>