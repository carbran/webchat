import axios from 'axios'
import { createApp } from 'vue'
import Vuex from 'vuex'
import createPersistedState from 'vuex-persistedstate'

const app = createApp(/* ... */)
app.use(Vuex)

export default new Vuex.Store({
    state: {
        user: {}
    },
    mutations: {
        setUserState: (state, value) => state.user = value
    },
    actions: {
        userStateAction: ({commit}) => {
            axios.get('api/user/me').then(response => {
                commit('setUserState', response.data.user)
            })
        }
    },
    plugins: [ createPersistedState() ]
})