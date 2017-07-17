import { 
    apiUrl,
    addPostUrl,
    getPostsUrl,
    getUserPostsUrl
} from './../../config';

const state = {
    posts: [],
    currentStatus: null
};

const mutations = {

    'SET_POSTS' (state, posts){
        state.posts = posts;
    },

    'SET_CURRENT_STATUS' (state, post){
        state.currentStatus = post;
    },

    'ADD_NEW_POST' (state, post){
        state.posts.unshift(post);
    }

};

const actions = {

    addNewPost: ({commit}, postData) => {
                
        return  HTTP.post(addPostUrl, postData)
            .then(response => {

                //console.log(response)
                //add new post
                commit('ADD_NEW_POST', response.data.data);
                return response.data.data;
                
            })
            .catch(error => {
                console.log(error)
            })

    },

    setCurrentStatus: ({commit}, postData) => {
                
        return  HTTP.get(getCurrentStatusUrl, postData)
            .then(response => {

                //get postS
                //console.log(response.data.data);
                commit('SET_CURRENT_STATUS', response.data.data);
                return response.data.data;
                
            })
            .catch(error => {
                console.log(error)
            })

    },

    initPosts: ({commit}, postData) => {

        return  HTTP.get(apiUrl + 'wall/' + postData.wall_id + '/posts')
            .then(response => {

                console.log(response.data.data.data);
                commit('SET_POSTS', response.data.data.data);
                return response.data.data.data;
                
            })
            .catch(error => {
                console.log(error)
            })

    },

    initStatus: ({commit}) => {

        return  HTTP.get(getCurrentStatusUrl)
            .then(response => {

                //get current status
                //console.log(response.data.data);
                commit('SET_CURRENT_STATUS', response.data.data);
                return response.data.data;
                
            })
            .catch(error => {
                console.log(error)
            })

    }

};

const getters = {

    posts: state => {
        return state.posts;
    }

};

export default {
    state,
    mutations,
    actions,
    getters
};