const state = {
    notifications: []
};

const mutations = {

    'SET_NOTIFICATIONS' (state, notifications){
        state.notifications = [];
        state.notifications = notifications;
    },

    'CLEAR_NOTIFICATIONS' (state, notifications){
        state.notifications = [];
    },

    'ADD_NOTIFICATION' (state, notification){
        //add to beginning of array
        state.notifications.splice(0, 0, notification);
    },

    'DELETE_NOTIFICATION' (state, notification){
        const record = state.notifications.find(element => element.id == notification.id);
        //remove element
        state.notifications.splice(state.notifications.indexOf(record), 1);
    }

};

const actions = {

    addComment: ({commit}, notification) => {
        commit('ADD_NOTIFICATION', notification);
    },

    clearNotifications: ({commit}) => {
        commit('CLEAR_NOTIFICATIONS');
    },

    setNotifications: ({commit},  post) => {

        axios.get('getNotifications?post_id=' + post.id )

            .then(response => {
                 commit('SET_NOTIFICATIONS', response.data.rows);
            })
            .catch(e => {
                //this.errors.push(e)
                console.log(e);
            });

    },

    initNotifications: ({commit}) => {

        axios.get('getNotifications', notificationObject)
            .then(response => {
                commit('SET_NOTIFICATIONS', response.data.rows);
            })
            .catch(e => {
                //this.errors.push(e)
                //console.log(response);
            });

    },

    deleteNotification: ({commit}, notification) => {
        commit('DELETE_NOTIFICATION', notification);
    }

};


const getters = {

    notifications: state => {
        return state.notifications;
    }

};

export default {
    state,
    mutations,
    actions,
    getters
};