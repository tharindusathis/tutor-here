<template>
  <div class="hello">
    <h1>{{ msg }}</h1>
    <b-row>
      <b-col>
        <button @click="format">Format</button>
        <pre>{{ api_data.search_results }}</pre>
      </b-col>
      <b-col>
        <pre>{{ formatted }}</pre>
      </b-col>
    </b-row>
  </div>
</template>

<script>
export default {
  name: "FindTutor",
  props: {
    idLearner: {
      default: 1
    }
  },
  components: {},
  data() {
    return {
      tem: "ff",
      api_data: {
        subjects: [],
        grades: [],
        grades_array: [],
        search_results: [],
        location_options: []
      },
      form: {
        subject: "Mathematics",
        location: null,
        lng: "",
        lat: "",
        date: "2019-1-1",
        grade_raw: "",
        grade: "",
        grade_id: null
      },
      formatted: "dd  ",
      states: {
        subject: null,
        location: null,
        lng: null,
        lat: null,
        date: null,
        grade: null
      },
      visibility: {
        grade: false,
        date_loc: false
      }
    };
  },
  created() {
    this.getTutors();
  },

  methods: {
    format() {
      console.log("formatiing");
      let output = {};
      let data = this.api_data.search_results;
      let ids = data.ids;

      for (const [key, value] of Object.entries(ids)) {
        //console.log(key, value);
        let id = value;
        let all = {};
        let timeslots = [];
        let locations = [];
        let subjects = [];

        for (const t of data.timeslots) {
          if (t.idTutor == id) {
            all["id"] = id;
            all["name"] = t.tutor_name;
            all["rating"] = t.rating;
            let timeslot = {};
            timeslot["start_time"] = t.start_time;
            timeslot["end_time"] = t.end_time;

            timeslots.push(timeslot);
          }
        }
        timeslots = timeslots.reduce((unique, o) => {
          if (
            !unique.some(
              obj =>
                obj.start_time === o.start_time && obj.end_time === o.end_time
            )
          ) {
            unique.push(o);
          }
          return unique;
        }, []);

        for (const [key, value] of Object.entries(data.subjects)) {
          if (value.idTutor == id) {
            let subject = {};
            subject["id"] = value.idSubject;
            subject["name"] = value.name;
            subject["syllabus"] = value.syllabus_from;
            subject["grade"] = value.grade;
            subject["hourly_rate"] = value.hourly_rate;
            subjects.push(subject);
          }
        }

        for (const t of data.locations) {
          if (t.idTutor == id) {
            let location = {};
            location["id"] = t.idTutorLocation;

            location["lat"] = t.lat;
            location["lng"] = t.lng;
            locations.push(location);
          }
        }

        all["timeslots"] = timeslots;
        all["locations"] = locations;
        all["subjects"] = subjects;
        output[id] = all;
      }
      this.formatted = output;
    },
    getTutors() {
      let grd = "";
      let syl = "";
      if (this.form.grade) {
        grd = this.form.grade.grade;
        syl = this.form.grade.syllabus_from;
      }
      let req = {
        subject_name: this.form.subject,
        grade: grd,
        syllabus_from: syl,
        date: this.form.date
      };
      this.$http.post("tutors/search", req).then(response => {
        console.log(response.data);
        this.api_data.search_results = response.data;
      });
    }
  }
};
</script>



<style scoped>
h3 {
  margin: 40px 0 0;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
}
</style>
