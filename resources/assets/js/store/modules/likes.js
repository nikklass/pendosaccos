import { 
    apiUrl,
    addLikeUrl,
    getLikessUrl
} from './../../config';

const state = {
    likes: []
};

const mutations = {

    'SET_LIKES' (state, likes){
        state.likes = likes;
    },

    'CLEAR_LIKES' (state, likes){
        state.likes = [];
    },

    'ADD_NEW_LIKE' (state, like){
        //add to beginning of array
        state.likes.unshift(like);
    },

    'DELETE_LIKE' (state, like){
        const record = state.likes.find(element => element.id == like.id);
        //remove element
        state.likes.splice(state.likes.indexOf(record), 1);
    }

};

const actions = {

    addNewLike: ({commit}, post) => {
                
        return  HTTP.post(addLikeUrl, post)
            .then(response => {

                //add new like
                commit('ADD_NEW_LIKE', response.data.data);
                return response.data.data;
                
            })
            .catch(error => {
                console.log(error)
            })

    },

    deleteLike: ({commit}, post) => {

        return  HTTP.delete(apiUrl + 'like/' + post.id)
            .then(response => {
                
                //delete like
                commit('DELETE_LIKE', post);
                return response.data.data;
                
            })
            .catch(error => {
                console.log(error)
            })

    },

    

    getPostLikes: ({commit}, post) => {

        return  HTTP.get(apiUrl + 'post/' + post.id + '/likes')
            .then(response => {

                //console.log(post.id)
                //add likes array
                commit('SET_LIKES', response.data.data);
                return response.data.data;
                
            })
            .catch(error => {
                console.log(error)
            })

    },

    clearLikes: ({commit}) => {
        commit('CLEAR_LIKES');
    },

    setLikes: ({commit},  post) => {

        axios.get('getLikes?id=' + post.id )

            .then(response => {
                //add likes array
                 commit('SET_LIKES', response.data.data);
                 //console.log("state.comments after set new  == " + state.comments);
            })
            .catch(e => {
                //this.errors.push(e)
                console.log(e);
            });

    },

    initLikes: ({commit}) => {

        HTTP.get('getLikes', likeObject)
            .then(response => {
                commit('SET_LIKES', response.data.data);
            })
            .catch(e => {
                //this.errors.push(e)
                //console.log(response);
            });

    }

};

const getters = {

    likes: state => {
        return state.likes;
    }

};

export default {
    state,
    mutations,
    actions,
    getters
};