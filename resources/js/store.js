import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    currentLocation: {
        lat: 0,
        lng: 0
    }
  },
  mutations: {
    updateLocation (state, coords) {
        state.currentLocation.lat = coords.lat;
        state.currentLocation.lng = coords.lng;
    }
  }
})

export default store;