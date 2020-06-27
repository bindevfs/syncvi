<template>
  <div>
    <gmap-map
      :center="center"
      :zoom="15"
      style="width:100%;  height: 400px;"
    >
      <gmap-marker
        :key="index"
        v-for="(m, index) in markers"
        :position="m.position"
        @click="center=m.position"
      ></gmap-marker>
    </gmap-map>
  </div>
</template>

<script>
export default {
  name: 'GoogleMap',
  data () {
    return {
      center: {lat: 16.041964, lng: 108.223179},
      markers: [{
        position: {lat: 16.041964, lng: 108.223179}
      }]
    }
  },

  mounted () {
    this.geoLocate()
  },

  methods: {
    geoLocate: function () {
      navigator.geolocation.getCurrentPosition(position => {
        this.center = {
          lat: position.coords.latitude,
          lng: position.coords.longitude,
          places: ['NeoLab Việt Nam, 2 Tháng 9, Hải Châu, Đà Nẵng, Vietnam']
        }
      })
    }
  }
}
</script>
