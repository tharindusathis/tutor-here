<template>
  <div>
    <b-card>
      <b-row>
        <h6>
          Creating request for
          <b>{{ data.name }}</b>
          <span></span>
          <span style="float:right;">
            <b-badge variant="primary" pill>{{ data.dist }} KM</b-badge>
          </span>
        </h6>
      </b-row>
      <b-row>
        <b-col sm="12">
          <h6>Select Time Range:</h6>

          <br />
          <br />
          <vue-slider v-model="slider.value" :marks="slider. marks" :data="slider.data">
            <template v-slot:process="{ start, end, style }">
              <div class="vue-slider-process" :style="style">
                <div
                  :class="[ 'merge-tooltip', 'vue-slider-dot-tooltip-inner','vue-slider-dot-tooltip-inner-top',]"
                >{{ slider.value[0] }} - {{ slider.value[1] }}</div>
              </div>
            </template>
          </vue-slider>
        </b-col>
      </b-row>
      <br />
      <b-row></b-row>
      <b-row>
        <b-button>Calculate Fare</b-button>
        <b-button @click="submitRequest()">Submit</b-button>
      </b-row>
    </b-card>
  </div>
</template>

<script>
export default {
  name: "Request",
  props: {
    idLearner: {
      default: 1
    },
    times: {
      default: function() {
        return {
          start_time: "08:00:00",
          end_time: "17:00:00"
        };
      }
    },
    data: {
      default: function() {
        return {
          idLearner: 1,
          idTutor: 1,
          date: "2019-01-01",
          dist: 12,
          name: "Davided Watson",
          learnerLocation: {
            id: 1,
            lat: "6.83756600",
            lng: "79.89635500"
          },
          subject: {
            idSubject: 1,
            name: "Mathematics",
            grade_name: "dfsdffs",
            syllabus_from: "Local, Sri Lanka",
            grade: "10"
          },
          hourly_rate: 400
        };
      }
    }
  },
  data() {
    return {
      slider: {
        value: [0, 50],
        data: [51, 3, 2, 3, 4],
        marks: []
      },
      fare: 23
    };
  },
  watch: {
    learnerLocation: function() {}
  },
  mounted: function() {
    let times = this.setTimes(
      this.times.start_time,
      this.times.end_time,
      11,
      5
    );
    this.slider.data = times.times;
    this.slider.marks = times.marks;
    this.slider.value = [
      this.slider.data[0],
      this.slider.data[times.times.length - 1]
    ];
  },
  methods: {
    calculateFare() {
      let minutes = 0;
      let start_time = this.slider.value[0];
      let end_time = this.slider.value[1];
      console.log("fare", start_time, end_time);
      let s =
        parseInt(start_time.split(":")[0]) * 60 +
        parseInt(start_time.split(":")[1]);
      let e =
        parseInt(end_time.split(":")[0]) * 60 +
        parseInt(end_time.split(":")[1]);
      minutes = e - s;

      let fare = (minutes * parseInt(this.data.hourly_rate)) / 60.0;
      console.log(e, s, fare);
      return fare;
    },
    submitRequest() {
      let req = {
        start_time: this.slider.value[0] + ":00",
        end_time: this.slider.value[1] + ":00",
        date: this.data.date,
        idTimeslot: this.data.idTimeslot,
        Tutor_has_Subject_Tutor_idTutor: this.data.idTutor,
        Tutor_has_Subject_Subject_idSubject: this.data.subject.idSubject,
        Learner_idLearner: this.data.idLearner,
        LearnerLocation_idLearnerLocation: this.data.idLearnerLocation,
        payment: this.calculateFare()
      };
      console.log(req);
      this.$http.post("requests", req).then(response => {
        console.log(response.data);
      });
    },
    setTimes(start_time, end_time, intervals, n_marks) {
      var x = 5; //minutes interval
      x = n_marks;
      var times = []; // time array
      var marks = []; // marks array

      var tt =
        parseInt(start_time.split(":")[0]) * 60 +
        parseInt(start_time.split(":")[1]);
      var tt_end =
        parseInt(end_time.split(":")[0]) * 60 +
        parseInt(end_time.split(":")[1]);
      var ap = ["AM", "PM"]; // AM-PM

      //loop to increment the time and push results in array
      for (var i = 0; tt <= tt_end; i++) {
        var hh = Math.floor(tt / 60); // getting hours of day in 0-24 format
        var mm = tt % 60; // getting minutes of the hour in 0-55 format
        times[i] = ("0" + hh).slice(-2) + ":" + ("0" + mm).slice(-2); // ap[Math.floor(hh/12)];
        tt = tt + x;
      }

      if (
        times[times.length - 1] !=
        end_time.split(":")[0] + ":" + end_time.split(":")[1]
      ) {
        times[times.length] =
          end_time.split(":")[0] + ":" + end_time.split(":")[1];
      }
      for (
        var i = 0, j = 0;
        i <= times.length;
        i += parseInt(times.length / intervals), j++
      ) {
        if (times[i]) marks[j] = times[i];
      }

      if (marks[marks.length - 1] != times[times.length - 1])
        marks[marks.length - 1] = times[times.length - 1];

      let values = [];
      values[0] = times.length[0];
      values[1] = times.length[1];

      return { times: times, marks: marks, values: values };
    }
  }
};
</script>

<style scoped>
.merge-tooltip {
  position: absolute;
  left: 50%;
  bottom: 100%;
  transform: translate(-50%, -15px);
}
</style>