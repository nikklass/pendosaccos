
const state = {
    authUser: []
};

const mutations = {

    'SET_AUTH_USER' (state, user){
        state.authUser = user;
    },

    'CLEAR_AUTH_USER' (state){
        state.authUser = null;
    }

};

const actions = {

    //create user object
    setAuthUser: ({commit}, user) => {
        commit('SET_AUTH_USER', user);

    },

    //clear user object
    clearAuthUser: ({commit}) => {
        commit('CLEAR_AUTH_USER');

    }

};

const getters = {

    getAuthUser: state => {
        return state.authUser;
    }

};

export default {
    state,
    mutations,
    actions,
    getters
};