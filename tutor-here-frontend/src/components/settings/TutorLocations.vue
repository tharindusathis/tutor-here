<template>
  <div>
    <div>
      <b-form-group id="location-in" label="Search Location:" label-for="input-1">

      			<gmap-autocomplete class="form-control" style="width: 100%" @place_changed="setPlace">
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
</template>

<script>
export default {
  name: "GoogleMap",
  data() {
    return {
      // default to Montreal to keep it simple
      // change this to whatever makes sense
      url: '',
      center: { lat: 45.508, lng: -73.587 },
      marker: {
      	position: this.center
      },
      places: [],
      currentPlace: null,
      mapOptions: {
      	disableDefaultUI : true,
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
    };
  },

  mounted() {
    this.geolocate();
  },
  computed: {

  },
  methods: {
  	getTownName (url) {
  		this.$http.get(url)
        .then(response => {
          console.log(response.data);
          let town = response.data.results[0].address_components[1].long_name;
          console.log("The town is " + town);
        });
        
  	}, 
    // receives a place object via the autocomplete component
    setPlace(place) {
      this.currentPlace = place;
      this.addMarker(); 
    },
    setMiddle (location) {
        const marker = {
          lat: location.latLng.lat(),
          lng: location.latLng.lng()
        };
        
        this.marker = { position: marker };
        this.places.push(this.currentPlace);
        this.center = marker;
        this.currentPlace = null; 
        this.url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' + this.center.lat + ',' + 
        this.center.lng + '&key=AIzaSyCQjKoJ2wT5Crcy3oPnJN3wAbYojDSxJgM';
        this.getTownName(this.url);
    },
    addMarker() {
      if (this.currentPlace) {
        const marker = {
          lat: this.currentPlace.geometry.location.lat(),
          lng: this.currentPlace.geometry.location.lng()
        };
        this.marker = { position: marker };
        this.places.push(this.currentPlace);
        this.center = marker;
        this.currentPlace = null;
        this.url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' + this.center.lat + ',' + 
        this.center.lng + '&key=AIzaSyCQjKoJ2wT5Crcy3oPnJN3wAbYojDSxJgM';
        this.getTownName(this.url);
      }
    },
    geolocate: function() {
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