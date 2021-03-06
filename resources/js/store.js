// import * as Vue from 'vue'
import axios from 'axios';
import {createStore} from 'vuex';
import createPersistedState from 'vuex-persistedstate';

// Vue.use(Vuex)


const state = {
    user: {}
}

const mutations = {
    setUserState: (state, value) => state.user = value
}

const actions = {
    userStateAction: ({commit}) => {
        axios.get('api/user/me').then(response => {
            const userResponse = response.data.user
            commit('setUserState', userResponse)
        })
    }
}

export default new createStore({
    state,
    mutations,
    actions,
    plugins: [createPersistedState()]
})
