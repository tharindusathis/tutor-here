<template>
  <div>
    <b-card>
      <b-row>
        <b-col sm="12">
          <h6>
            {{ tutor.name }}
            <b-badge variant="warning" pill>{{ tutor.rating }}</b-badge>
            <b>
              <span style="float:right;">{{ dist }} KM</span>
            </b>
          </h6>
        </b-col>
      </b-row>
      <br />
      <b-row>
        <b-col sm="12">
          <b-list-group>
            <b-list-group-item
              v-for="(item,key) in  tutor.timeslots"
              class="d -flex justify-content-between align-items-center"
              :key="key"
            >
              <template>{{ item.start_time }} - {{ item.end_time }}</template>
              <!-- <template></template> -->
              <span style="float:right;">
                <!-- <b-badge variant="primary" pill></b-badge> -->
                <b-button variant="primary" pill size="sm">Request</b-button>
              </span>
              <br />
              <request :data="request_data()" :times="item"></request>
            </b-list-group-item>
          </b-list-group>
          <br />
          <b-list-group>
            <b-list-group-item
              v-for="(item,key) in  tutor.subjects"
              class="d -flex justify-content-between align-items-center"
              :key="key"
            >
              <template>
                {{ item.name }}
                <template>- {{ item.grade }}</template>
                <template>({{ item.syllabus }})</template>
              </template>

              <span style="float:right;">
                <b-badge variant="primary" pill>{{ item.hourly_rate }}</b-badge>
              </span>
            </b-list-group-item>
          </b-list-group>
          <br />
          <span style="float:right;">
            <b-button variant="primary">Request</b-button>
          </span>
        </b-col>
      </b-row>
    </b-card>
  </div>
</template>

<script>
import Request from "./Request";

export default {
  name: "TutorSearchResult",
  components: {
    Request
  },
  props: {
    idLearner: {
      default: 1
    },
    tutor: {
      default: function() {
        return {
          id: 1,
          subject: {},
          name: "Davided Watson",
          rating: "5.00",
          date: "2019-08-08",
          hourly_rate: "434343",
          idLearnerLocation: "1",
          timeslots: [
            {
              start_time: "08:00:00",
              end_time: "17:00:00"
            },
            {
              start_time: "08:00:00",
              end_time: "16:00:00"
            }
          ],
          locations: [
            {
              id: 1,
              lat: "6.83756600",
              lng: "79.89635500"
            },
            {
              id: 5,
              lat: "4.57086800",
              lng: "-74.29733300"
            },
            {
              id: 6,
              lat: "6.86358726",
              lng: "79.89796229"
            },
            {
              id: 8,
              lat: "6.89775950",
              lng: "79.91991860"
            },
            {
              id: 9,
              lat: "6.89158177",
              lng: "79.92695672"
            },
            {
              id: 10,
              lat: "6.84085177",
              lng: "79.90571426"
            }
          ],
          subjects: [
            {
              id: 1,
              name: "Mathematics",
              syllabus: "Local, Sri Lanka",
              grade: "10",
              hourly_rate: "800.00"
            },
            {
              id: 2,
              name: "Mathematics",
              syllabus: "Cambridge",
              grade: "8",
              hourly_rate: "1000.00"
            },
            {
              id: 3,
              name: "Science",
              syllabus: "Local, Sri Lanka",
              grade: "10",
              hourly_rate: null
            }
          ]
        };
      }
    },
    learnerLocation: {
      default: function() {
        return { lat: 8.3423344234, lng: 9.42342342 };
      }
    }
  },
  data() {
    return {
      dist: 0,
      request_data: function() {
        return {
          idLearner: this.idLearner,
          idTutor: this.tutor.id,
          subject: this.tutor.subject,
          date: this.tutor.date,
          dist: this.dist,
          name: this.tutor.name,
          idLearnerLocation: this.tutor.idLearnerLocation,
          hourly_rate: this.tutor.hourly_rate
        };
      }
    };
  },
  watch: {
    learnerLocation: function() {
      this.dist = this.getMinDistance();
    }
  },
  mounted: function() {
    this.dist = this.getMinDistance();
  },
  methods: {
    deg2rad(deg) {
      return deg * (Math.PI / 180);
    },
    getDistanceInKm(lat1, lon1, lat2, lon2) {
      var R = 6371; // Radius of t    he earth in km
      var dLat = this.deg2rad(lat2 - lat1); // deg2rad below
      var dLon = this.deg2rad(lon2 - lon1);
      var a =
        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(this.deg2rad(lat1)) *
          Math.cos(this.deg2rad(lat2)) *
          Math.sin(dLon / 2) *
          Math.sin(dLon / 2);
      var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
      var d = R * c; // Distance in km
      return d;
    },
    getMinDistance() {
      let min_dist = 1000000;
      for (let i = 0; i < this.tutor.locations.length; i++) {
        let dis = this.getDistanceInKm(
          this.learnerLocation.lat,
          this.learnerLocation.lng,
          this.tutor.locations[i].lat,
          this.tutor.locations[i].lat
        );
        if (dis < min_dist) min_dist = dis;
        console.log(dis);
      }
      return Math.round(min_dist);
    }
  }
};
</script>

<style scoped>
</style>