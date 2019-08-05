<template>
  <div>
    <div>
      <h2>Search and add a pin</h2>
      <label>
        <gmap-autocomplete
            @place_changed="setPlace">
        </gmap-autocomplete>
        <button @click="addMarker">Add</button>
      </label>
      <br/>

    </div>
    <br>
    <gmap-map
        :center="center"
        :zoom="12"
        style="width:100%;  height: 400px;"
    >
      <gmap-marker
          :key="index"
          v-for="(m, index) in markers"
          :position="m.position"
          @click="center=m.position"
      ></gmap-marker>
    </gmap-map>

    <br><br>

    <div>
      <div>
        <div>
          <b-form-group id="location-in" description="new_location.city">
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
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: "GoogleMap",
    data() {
      return {
        // default to Montreal to keep it simple
        // change this to whatever makes sense
        center: {lat: 45.508, lng: -73.587},
        markers: [],
        places: [],
        currentPlace: null,
        api_data_locations: [],
        api_location_info: [],
        new_location: {
          Tutor_idTutor: '',
          city: '',
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

    mounted() {
      this.geolocate();
    },

    methods: {
      // receives a place object via the autocomplete component
      setPlace(place) {
        this.currentPlace = place;
      },
      addMarker() {
        if (this.currentPlace) {
          const marker = {
            lat: this.currentPlace.geometry.location.lat(),
            lng: this.currentPlace.geometry.location.lng()
          };
          this.markers.push({position: marker});
          this.places.push(this.currentPlace);
          this.center = marker;
          this.currentPlace = null;
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
    }
  };
</script>