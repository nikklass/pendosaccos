import { 
    apiUrl,
    addCommentUrl,
    getCommentsUrl
} from './../../config';

const state = {
    comments: []
};

const mutations = {

    'SET_COMMENTS' (state, comments){
        state.comments = comments
    },

    'CLEAR_COMMENTS' (state, comments){
        state.comments = []
    },

    'ADD_NEW_COMMENT' (state, comment){
        //add to beginning of array
        state.comments.unshift(comment)
    },

    'UPDATE_COMMENT' (state, comment){
        //replace the comment in array
        const record = state.comments.find(element => element.id == comment.id)
        //state.comments.unshift(comment)
    },

    'DELETE_COMMENT' (state, comment){
        const record = state.comments.find(element => element.id == comment.id)
        //remove element
        state.comments.splice(state.comments.indexOf(record), 1)
    }

};

const actions = {

    addNewComment: ({commit}, postData) => {
                
        return  HTTP.post(addCommentUrl, postData)
            .then(response => {

                //add new comment to array
                commit('ADD_NEW_COMMENT', response.data.data)
                return response.data.data
                
            })
            .catch(error => {
                console.log(error)
            })

    },

    getPostComments: ({commit}, post) => {

        return  HTTP.get(apiUrl + 'post/' + post.id + '/comments')
            .then(response => {

                //set comments array
                commit('SET_COMMENTS', response.data.data)
                return response.data.data
                
            })
            .catch(error => {
                console.log(error)
            })

    },

    clearComments: ({commit}) => {
        commit('CLEAR_COMMENTS')
    },

    setComments: ({commit},  post) => {

        return  HTTP.get(getCommentsUrl, { post_id: post.id })
            .then(response => {

                //set comments array
                commit('SET_COMMENTS', response.data.data)
                return response.data.data
                
            })
            .catch(error => {
                console.log(error)
            })

    },

    deleteComment: ({commit}, postData) => {

        return  HTTP.delete(apiUrl + 'comment/' + postData.id)
            .then(response => {

                //console.log(response.data.data)
                //delete comment from array
                commit('DELETE_COMMENT', post)
                return response.data.data
                
            })
            .catch(error => {
                console.log(error)
            })

    },

    updatePostComment: ({commit}, postData) => {

        return  HTTP.put(apiUrl + 'comment/' + postData.id, postData)
            .then(response => {

                //console.log(response.data.data)
                //add comments
                commit('UPDATE_COMMENT', response.data.data)
                return response.data.data
                
            })
            .catch(error => {
                console.log(error)
            })

    }

};

const getters = {
    comments: state => {
        return state.comments
    }
};

export default {
    state,
    mutations,
    actions,
    getters
};