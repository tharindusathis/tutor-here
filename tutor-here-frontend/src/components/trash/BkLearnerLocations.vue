<template>
  <div>
    <b-list-group>
      <b-list-group-item v-if="api_data_locations.length === 0" class="text-center">
        No locations added.
      </b-list-group-item>
      <b-list-group-item v-for="item in api_data_locations">
        <p style="text-align:left;">
          {{ item['address']}}<span v-if="item['city']">,</span>

          <span style="float:right;">
          
          <b-button size="sm" variant="outline-danger"
                    @click="deleteLocation( item['idLearnerLocation'] )">Remove</b-button> </span>
        </p>
      </b-list-group-item>
    </b-list-group>

    <b-button v-b-modal.modal-location-pick variant="outline-primary">Add a location</b-button>

    <!-- ------------------------------------------ -->
    <div>
      <b-modal
          centered
          id="modal-location-pick"
          ref="modal"
          title="Add location"
          @show="resetModal"
          @hidden="resetModal"
          @ok="handleOk"
          ok-title="Add Location"
          class="pac-container"
      >
        <div>
          <b-form-group id="location-in" :description="new_location.address">
            <gmap-autocomplete class="form-control" style="width: 100%" @place_changed="setPlace"
                               placeholder="Enter the location here">
            </gmap-autocomplete>
          </b-form-group>
        </div>
        <gmap-map
            :center="center"
            :zoom="15"
            style="width:100%;  height: 400px;"
            :options="mapOptions"
        >
          <gmap-marker
              :position="marker.position"
              @click="center=marker.position"
              :draggable="true"
              @dragend="setMiddle($event)"

          ></gmap-marker>
        </gmap-map>
      </b-modal>
    </div>
  </div>
</template>

<script>

  export default {
    name: 'LearnerLocations',
    props: {
      idLearner: {
        default: 14,
        type: Number
      }
    },
    data() {
      return {
        api_data_locations: [],
        api_location_info: [],
        new_location: {
          Learner_idLearner: '',
          address: '',
          lat: 0.0,
          lng: 0.0
        },
        address: '',
        url: '',
        center: {lat: 45.508, lng: -73.587},
        marker: {
          position: this.center
        },
        places: [],
        currentPlace: null,
        mapOptions: {
          disableDefaultUI: true,
          streetViewControl: false,
          styles:
            [
              {
                "featureType": "landscape.natural",
                "elementType": "geometry",
                "stylers": [
                  {
                    "color": "#dde2e3"
                  },
                  {
                    "visibility": "on"
                  }
                ]
              },
              {
                "featureType": "poi.park",
                "elementType": "all",
                "stylers": [
                  {
                    "color": "#c6e8b3"
                  },
                  {
                    "visibility": "on"
                  }
                ]
              },
              {
                "featureType": "poi.park",
                "elementType": "geometry.fill",
                "stylers": [
                  {
                    "color": "#c6e8b3"
                  },
                  {
                    "visibility": "on"
                  }
                ]
              },
              {
                "featureType": "road",
                "elementType": "geometry.fill",
                "stylers": [
                  {
                    "visibility": "on"
                  }
                ]
              },
              {
                "featureType": "road",
                "elementType": "geometry.stroke",
                "stylers": [
                  {
                    "visibility": "off"
                  }
                ]
              },
              {
                "featureType": "road",
                "elementType": "labels",
                "stylers": [
                  {
                    "visibility": "on"
                  }
                ]
              },
              {
                "featureType": "road",
                "elementType": "labels.text.fill",
                "stylers": [
                  {
                    "visibility": "on"
                  }
                ]
              },
              {
                "featureType": "road",
                "elementType": "labels.text.stroke",
                "stylers": [
                  {
                    "visibility": "on"
                  }
                ]
              },
              {
                "featureType": "road.highway",
                "elementType": "geometry.fill",
                "stylers": [
                  {
                    "color": "#c1d1d6"
                  },
                  {
                    "visibility": "on"
                  }
                ]
              },
              {
                "featureType": "road.highway",
                "elementType": "geometry.stroke",
                "stylers": [
                  {
                    "color": "#a9b8bd"
                  },
                  {
                    "visibility": "on"
                  }
                ]
              },
              {
                "featureType": "road.local",
                "elementType": "all",
                "stylers": [
                  {
                    "color": "#f8fbfc"
                  }
                ]
              },
              {
                "featureType": "road.local",
                "elementType": "labels.text",
                "stylers": [
                  {
                    "color": "#979a9c"
                  },
                  {
                    "visibility": "on"
                  },
                  {
                    "weight": 0.5
                  }
                ]
              },
              {
                "featureType": "road.local",
                "elementType": "labels.text.fill",
                "stylers": [
                  {
                    "visibility": "on"
                  },
                  {
                    "color": "#827e7e"
                  }
                ]
              },
              {
                "featureType": "road.local",
                "elementType": "labels.text.stroke",
                "stylers": [
                  {
                    "color": "#3b3c3c"
                  },
                  {
                    "visibility": "off"
                  }
                ]
              },
              {
                "featureType": "water",
                "elementType": "geometry.fill",
                "stylers": [
                  {
                    "color": "#a6cbe3"
                  },
                  {
                    "visibility": "on"
                  }
                ]
              }
            ]

        }
      }
    },
    methods: {
      listLocations() {
        this.$http.get('learners/' + this.idLearner + '/locations')
          .then(response => {
            console.log(response.data);
            this.api_data_locations = response.data;
            console.log("ddd");
            console.log(this.api_data_locations);
          });
      },
      resetModal() {

      },
      handleOk(bvModalEvt) {
        //let town =  this.api_location_info[0].address_components[1].long_name;
        this.$http.post('learnerlocations', this.new_location)
          .then(response => {
            console.log(response);
            this.listLocations();
          }, error => {
            console.log(error);
          });
      },
      getLocationInfo(url) {
        this.$http.get(url)
          .then(response => {
            this.api_location_info = response.data;
            //console.log(this.api_location_info.results[0].formatted_address);
            console.log(url);
            this.new_location.address = this.api_location_info.results[0].formatted_address;
            this.new_location.Learner_idLearner = this.idLearner;
            this.new_location.lat = this.center.lat;
            this.new_location.lng = this.center.lng;
            console.log(this.new_location);
          });

      },
      deleteLocation(id) {
        this.$http.delete('learnerlocations/' + id)
          .then(response => {
            this.api_location_info = response.data;
            console.log(response.data);
            this.listLocations();
          });
      },
      // receives a place object via the autocomplete component
      setPlace(place) {
        if (typeof(place.geometry) != 'undefined') {
          this.currentPlace = place;
          this.addMarker();
        }
      },
      setMiddle(location) {

        const marker = {
          lat: location.latLng.lat(),
          lng: location.latLng.lng()
        };

        this.marker = {position: marker};
        this.places.push(this.currentPlace);
        this.center = marker;
        this.currentPlace = null;
        // this.url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' + this.center.lat + ',' +
        //   this.center.lng + '&key=AIzaSyCQjKoJ2wT5Crcy3oPnJN3wAbYojDSxJgM';
        this.url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' + this.center.lat + ',' +
          this.center.lng + '&key=AIzaSyBnyQVq-k9hIIXGUlAHggymb0k1Mi_q37E';
        this.getLocationInfo(this.url);

      },
      addMarker() {
        if (this.currentPlace) {
          const marker = {
            lat: this.currentPlace.geometry.location.lat(),
            lng: this.currentPlace.geometry.location.lng()
          };
          this.marker = {position: marker};
          this.places.push(this.currentPlace);
          this.center = marker;
          this.currentPlace = null;
          // this.url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' + this.center.lat + ',' +
          //   this.center.lng + '&key=AIzaSyCQjKoJ2wT5Crcy3oPnJN3wAbYojDSxJgM';  //'&result_type=locality'
          this.url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' + this.center.lat + ',' +
            this.center.lng + '&key=AIzaSyBnyQVq-k9hIIXGUlAHggymb0k1Mi_q37E';  //'&result_type=locality'
          this.getLocationInfo(this.url);
        }
      },
      geolocate: function () {
        navigator.geolocation.getCurrentPosition(position => {
          this.center = {
            lat: position.coords.latitude,
            lng: position.coords.longitude
          };
        });
      }
    },
    created() {
      this.listLocations();
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




<template>
  <div>
    <b-list-group>
      <b-list-group-item v-if="api_data_locations.length === 0" class="text-center">
        No locations added.
      </b-list-group-item>
      <b-list-group-item v-for="item in api_data_locations">
        <p style="text-align:left;">
          {{ item['address']}}<span v-if="item['city']">,</span>

          <span style="float:right;">

          <b-button size="sm" variant="outline-danger"
                    @click="deleteLocation( item['idLearnerLocation'] )">Remove</b-button> </span>
        </p>
      </b-list-group-item>
    </b-list-group>

    <b-button v-b-modal.modal-location-pick variant="outline-primary">Add a location</b-button>

    <!-- ------------------------------------------ -->
    <div>
      <b-modal
          centered
          id="modal-location-pick"
          ref="modal"
          title="Add location"
          @show="resetModal"
          @hidden="resetModal"
          @ok="handleOk"
          ok-title="Add Location"
          class="pac-container"
      >
        <div>
          <b-form-group id="location-in" :description="new_location.address">
            <gmap-autocomplete class="form-control" style="width: 100%" @place_changed="setPlace"
                               placeholder="Enter the location here">
            </gmap-autocomplete>
          </b-form-group>
        </div>
        <gmap-map
            :center="center"
            :zoom="15"
            style="width:100%;  height: 400px;"
            :options="mapOptions"
        >
          <gmap-marker
              :position="marker.position"
              @click="center=marker.position"
              :draggable="true"
              @dragend="setMiddle($event)"

          ></gmap-marker>
        </gmap-map>
      </b-modal>
    </div>
  </div>
</template>

<script>

  export default {
    name: 'LearnerLocations',
    props: {
      idLearner: {
        default: 14,
        type: Number
      }
    },
    data() {
      return {
        api_data_locations: [],
        api_location_info: [],
        new_location: {
          Learner_idLearner: '',
          address: '',
          lat: 0.0,
          lng: 0.0
        },
        address: '',
        url: '',
        center: {lat: 45.508, lng: -73.587},
        marker: {
          position: this.center
        },
        places: [],
        currentPlace: null,
        mapOptions: {
          disableDefaultUI: true,
          streetViewControl: false,
          styles:
            [
              {
                "featureType": "landscape.natural",
                "elementType": "geometry",
                "stylers": [
                  {
                    "color": "#dde2e3"
                  },
                  {
                    "visibility": "on"
                  }
                ]
              },
              {
                "featureType": "poi.park",
                "elementType": "all",
                "stylers": [
                  {
                    "color": "#c6e8b3"
                  },
                  {
                    "visibility": "on"
                  }
                ]
              },
              {
                "featureType": "poi.park",
                "elementType": "geometry.fill",
                "stylers": [
                  {
                    "color": "#c6e8b3"
                  },
                  {
                    "visibility": "on"
                  }
                ]
              },
              {
                "featureType": "road",
                "elementType": "geometry.fill",
                "stylers": [
                  {
                    "visibility": "on"
                  }
                ]
              },
              {
                "featureType": "road",
                "elementType": "geometry.stroke",
                "stylers": [
                  {
                    "visibility": "off"
                  }
                ]
              },
              {
                "featureType": "road",
                "elementType": "labels",
                "stylers": [
                  {
                    "visibility": "on"
                  }
                ]
              },
              {
                "featureType": "road",
                "elementType": "labels.text.fill",
                "stylers": [
                  {
                    "visibility": "on"
                  }
                ]
              },
              {
                "featureType": "road",
                "elementType": "labels.text.stroke",
                "stylers": [
                  {
                    "visibility": "on"
                  }
                ]
              },
              {
                "featureType": "road.highway",
                "elementType": "geometry.fill",
                "stylers": [
                  {
                    "color": "#c1d1d6"
                  },
                  {
                    "visibility": "on"
                  }
                ]
              },
              {
                "featureType": "road.highway",
                "elementType": "geometry.stroke",
                "stylers": [
                  {
                    "color": "#a9b8bd"
                  },
                  {
                    "visibility": "on"
                  }
                ]
              },
              {
                "featureType": "road.local",
                "elementType": "all",
                "stylers": [
                  {
                    "color": "#f8fbfc"
                  }
                ]
              },
              {
                "featureType": "road.local",
                "elementType": "labels.text",
                "stylers": [
                  {
                    "color": "#979a9c"
                  },
                  {
                    "visibility": "on"
                  },
                  {
                    "weight": 0.5
                  }
                ]
              },
              {
                "featureType": "road.local",
                "elementType": "labels.text.fill",
                "stylers": [
                  {
                    "visibility": "on"
                  },
                  {
                    "color": "#827e7e"
                  }
                ]
              },
              {
                "featureType": "road.local",
                "elementType": "labels.text.stroke",
                "stylers": [
                  {
                    "color": "#3b3c3c"
                  },
                  {
                    "visibility": "off"
                  }
                ]
              },
              {
                "featureType": "water",
                "elementType": "geometry.fill",
                "stylers": [
                  {
                    "color": "#a6cbe3"
                  },
                  {
                    "visibility": "on"
                  }
                ]
              }
            ]

        }
      }
    },
    methods: {
      listLocations() {
        this.$http.get('learners/' + this.idLearner + '/locations')
          .then(response => {
            console.log(response.data);
            this.api_data_locations = response.data;
            console.log("ddd");
            console.log(this.api_data_locations);
          });
      },
      resetModal() {

      },
      handleOk(bvModalEvt) {
        //let town =  this.api_location_info[0].address_components[1].long_name;
        this.$http.post('learnerlocations', this.new_location)
          .then(response => {
            console.log(response);
            this.listLocations();
          }, error => {
            console.log(error);
          });
      },
      getLocationInfo(url) {
        this.$http.get(url)
          .then(response => {
            this.api_location_info = response.data;
            //console.log(this.api_location_info.results[0].formatted_address);
            console.log(url);
            this.new_location.address = this.api_location_info.results[0].formatted_address;
            this.new_location.Learner_idLearner = this.idLearner;
            this.new_location.lat = this.center.lat;
            this.new_location.lng = this.center.lng;
            console.log(this.new_location);
          });

      },
      deleteLocation(id) {
        this.$http.delete('learnerlocations/' + id)
          .then(response => {
            this.api_location_info = response.data;
            console.log(response.data);
            this.listLocations();
          });
      },
      // receives a place object via the autocomplete component
      setPlace(place) {
        if (typeof(place.geometry) != 'undefined') {
          this.currentPlace = place;
          this.addMarker();
        }
      },
      setMiddle(location) {

        const marker = {
          lat: location.latLng.lat(),
          lng: location.latLng.lng()
        };

        this.marker = {position: marker};
        this.places.push(this.currentPlace);
        this.center = marker;
        this.currentPlace = null;
        // this.url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' + this.center.lat + ',' +
        //   this.center.lng + '&key=AIzaSyCQjKoJ2wT5Crcy3oPnJN3wAbYojDSxJgM';
        this.url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' + this.center.lat + ',' +
          this.center.lng + '&key=AIzaSyBnyQVq-k9hIIXGUlAHggymb0k1Mi_q37E';
        this.getLocationInfo(this.url);

      },
      addMarker() {
        if (this.currentPlace) {
          const marker = {
            lat: this.currentPlace.geometry.location.lat(),
            lng: this.currentPlace.geometry.location.lng()
          };
          this.marker = {position: marker};
          this.places.push(this.currentPlace);
          this.center = marker;
          this.currentPlace = null;
          // this.url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' + this.center.lat + ',' +
          //   this.center.lng + '&key=AIzaSyCQjKoJ2wT5Crcy3oPnJN3wAbYojDSxJgM';  //'&result_type=locality'
          this.url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' + this.center.lat + ',' +
            this.center.lng + '&key=AIzaSyBnyQVq-k9hIIXGUlAHggymb0k1Mi_q37E';  //'&result_type=locality'
          this.getLocationInfo(this.url);
        }
      },
      geolocate: function () {
        navigator.geolocation.getCurrentPosition(position => {
          this.center = {
            lat: position.coords.latitude,
            lng: position.coords.longitude
          };
        });
      }
    },
    created() {
      this.listLocations();
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