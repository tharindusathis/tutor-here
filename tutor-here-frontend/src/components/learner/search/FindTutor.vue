<template>
  <div>
    <!--overlay-->
    <!--:img-src="require('../../../assets/img4.2.png')"-->
    <!--img-alt="Card Image"-->
    <b-card title="New Tuition Request"

            sub-title="Enter the request details."
    >

      <!--<div class=" justify-content-center align-items-center">-->
      <!--<b-button aling="center" variant="primary">Create New Tuition Request</b-button>-->
      <!--</div>-->
      <br>
      <b-form @submit="onSubmit" @reset="onReset">
        <div class="op-8 mt-2">
          <b-input-group prepend="Subject">
            <b-form-input
                id="input-subject"
                v-model="form.subject"
                :state="states.subject"
                trim
                placeholder="Name of subject"
                list="list-subject"
            ></b-form-input>
            <b-datalist id="list-subject">
              <option
                  v-for="item in api_data.subjects"
                  :label="item['subject_count']"
              >{{ item['name'] }}
              </option>
            </b-datalist>
          </b-input-group>

          <b-collapse id="collapse-grade" :visible="visibility.grade">
            <b-input-group prepend="Grade">
              <b-form-input
                  id="input-grade"
                  v-model="form.grade_raw"
                  :state="states.grade"
                  trim
                  placeholder="Your Grade/Level/Year"
                  list="list-grade"
              ></b-form-input>
              <!--<datalist v-if="form.grade.length >= 1" id="list-grade">-->
              <!--<option v-for="item in api_data.grades">{{ item }}</option>-->
              <!--</datalist>-->
              <b-datalist id="list-grade">
                <option
                    v-for="(item,i) in api_data.grades"
                    :label="item['tutor_count']"
                >{{ item['grade_name'] }}
                </option>
              </b-datalist>
            </b-input-group>
          </b-collapse>

          <b-collapse id="collapse-date-loc" :visible="visibility.date_loc">
            <b-input-group prepend="Date">
              <b-form-input id="input-date" v-model="form.date" :state="states.date" type="date"></b-form-input>
            </b-input-group>

            <b-input-group prepend="Location">
              <b-form-select
                  id="input-location"
                  v-model="form.location"
                  :options="api_data.location_options"
              ></b-form-select>
            </b-input-group>
          </b-collapse>
        </div>

        <!--<b-button v-b-toggle="'collapse-options'">More options</b-button>-->
        <!--<br>-->
        <!--<b-collapse id="collapse-options">-->
        <!--<b-input-group prepend="Time">-->
        <!--<b-form-input-->
        <!--id="input-time"-->
        <!--v-model="form.time"-->
        <!--:state="states.time"-->
        <!--type="time">-->
        <!--</b-form-input>-->
        <!--</b-input-group>-->
        <!--</b-collapse>-->
        <br/>
        <span style="float:right;" class="mb-5">
          <b-button type="Search Tutor" variant="primary">Submit</b-button>
        </span>
      </b-form>

      <!-- <b-card v-if="1">
        <b-list-group>
          <b-list-group-item v-for="item in api_data.search_results">
            {{ item }}
            <b-button>Request</b-button>
          </b-list-group-item>
        </b-list-group>
      </b-card>-->
    </b-card>
    <template v-for="i in api_data.search_results">
      <br/>
      <tutor-search-result :tutor="i" :learnerLocation="form.location.value"
                           :idLearner="idLearner"></tutor-search-result>
    </template>
  </div>
</template>

<script>
  import TutorSearchResult from "./TutorSearchResult";

  export default {
    name: "FindTutor",
    props: {
      idLearner: {
        default: 1,
        type: Number
      }
    },
    components: {
      TutorSearchResult
    },
    data() {
      return {
        tem: "ff",
        api_data: {
          subjects: [],
          grades: [],
          //grades_array: [],
          search_results: [],
          location_options: []
        },
        form: {
          subject: null,
          location: null,
          lng: "",
          lat: "",
          date: "",
          grade_raw: "",
          grade: "",
          grade_id: null
        },
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
    mounted() {
      this.loadContent();
    },
    created() {
      //this.loadContent();
    },
    watch: {
      "form.subject": function (newVal, oldVal) {
        if (newVal) {
          this.visibility.grade = true;
          this.getSubjects(newVal);
        } else {
          this.visibility.grade = false;
        }
      },
      "form.grade_raw": function (newVal, oldVal) {
        if (newVal) {
          this.visibility.date_loc = true;

          let grade = this.searchGradeName(newVal, this.api_data.grades);
          if (grade) this.form.grade = grade;
          else this.form.grade = null;
        } else {
          this.visibility.date_loc = false;
          this.form.grade = null;
        }
      }
    },
    methods: {
      loadContent() {
        this.$http.get("subjects/search/subjects").then(response => {
          console.log(response.data);
          this.api_data.subjects = response.data;
        });
        this.$http
          .get("learners/" + this.idLearner + "/locations")
          .then(response => {
            console.log(response.data);
            let locations = response.data;
            let i;
            for (i in locations) {
              let id = locations[i]["idLearnerLocation"];
              let lat = locations[i]["lat"];
              let lng = locations[i]["lng"];
              let address = locations[i]["address"];
              let obj = {
                value: {id: id, value: {lat: lat, lng: lng}},
                text: address
              };
              this.api_data.location_options.push(obj);
              console.log("loction item added");
            }
          });
      },
      searchGradeName(nameKey, myArray) {
        for (var i = 0; i < myArray.length; i++) {
          if (myArray[i].grade_name === nameKey) {
            return myArray[i];
          }
        }
      },
      onSubmit(evt) {
        evt.preventDefault();
        this.getTutors();
      },
      onReset(evt) {
        evt.preventDefault();
        // Reset our form values
        this.form.subject = "";
        this.form.location = "";
        this.form.lng = "";
        this.form.lat = "";
        this.form.grade = "";
        this.form.date = "";
      },
      getSubjects(name) {
        let req = {
          subject_name: name
        };
        this.$http.post("subjects/search/grades", req).then(response => {
          console.log(response.data);
          this.api_data.grades = response.data;
        });
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
          this.api_data.search_results = this.formatSearchResults(response.data);
        });
      },
      formatSearchResults(input) {
        let output = {};
        let data = input;
        let ids = data.ids;

        for (const [key, value] of Object.entries(ids)) {
          //console.log(key, value);
          let id = value;
          let all = {};
          let timeslots = [];
          let locations = [];
          let subjects = [];
          let sub_id = this.form.grade.idSubject;
          let hourly_rate = 0;

          for (const [key, value] of Object.entries(data.subjects)) {
            if (value.idTutor == id && value.idSubject == sub_id) {
              hourly_rate = value.hourly_rate;
            }
          }

          all["subject"] = this.form.grade;
          all["hourly_rate"] = hourly_rate;
          all["date"] = this.form.date;
          all["idLearnerLocation"] = this.form.location.id;
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
        return output;
      }
    }
  };
</script>

<style scoped>
  .input-group > .input-group-prepend {
    flex: 0 0 20%;
  }

  .input-group .input-group-text {
    width: 100%;
  }

  .op-8 {
    opacity: 0.8;
  }

</style>