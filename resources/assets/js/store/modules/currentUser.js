
import { 
    getUserUrl
} from './../../config';

const state = {
    currentUser: []
};

const mutations = {

    'SET_CURRENT_USER' (state, user){
        state.currentUser = user;
    },

    'CLEAR_CURRENT_USER' (state){
        state.currentUser = null;
    }

};

const actions = {

    //create user object
    setCurrentUser: ({commit}, postData) => {
        //console.log(postData);
        return  HTTP.get(getUserUrl + "/" + postData.id)
        .then(response =>  {

            //console.log(response.data.data);
            //console.log(getUserUrl + "/" + postData.id);
            commit('SET_CURRENT_USER', response.data.data);

        })
        .catch(error => {
            console.log(error)
        })

    },

    //clear user object
    clearcurrentUser: ({commit}) => {
        commit('CLEAR_CURRENT_USER');

    }

};

const getters = {

    getcurrentUser: state => {
        return state.currentUser;
    }

};

export default {
    state,
    mutations,
    actions,
    getters
};