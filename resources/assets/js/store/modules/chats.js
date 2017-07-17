import { 
    userListUrl, 
    userConversationUrl, 
    chatNotificationsUrl,
    addChatToConversationUrl 
} from './../../config';

const state = {
    userList: [],
    conversation: [],
    notifications: [],
    currentChatUser: null
};

const mutations = {

    'SET_USER_LIST' (state, userList){
        state.userList = userList;
    },

    'SET_CHAT_NOTIFICATIONS' (state, notifications){
        state.notifications = notifications;
    },

    'CLEAR_USER_LIST' (state){
        state.userList = null;
    },

    'SET_CURRENT_CHAT_USER' (state, user){
        state.currentChatUser = user;
    },

    'SET_CONVERSATION' (state, conversation){
        state.conversation = conversation;
    },

    'ADD_CHAT_TO_CONVERSATION' (state, message){
        state.conversation.push(message);
    }

};

const actions = {

    //create user list bject
    setUserList: ({commit}) => {

        return HTTP.get(userListUrl)
        .then(response =>  {

            //console.log(response);
            if (response.status === 200) {
                commit('SET_USER_LIST', response.data.data);
            }

        })
        .catch(error => {
            console.log(error)
        })

    },

    //set chat notifications
    setChatNotifications: ({commit}) => {

        return HTTP.get(chatNotificationsUrl)
        .then(response =>  {

            if (response.status === 200) {
                commit('SET_CHAT_NOTIFICATIONS', response.data.data);
            }

        })
        .catch(error => {
            console.log(error)
        })

    },

    //clear user list object
    clearUserList: ({commit}) => {
        commit('CLEAR_USER_LIST');

    },

    //set the current chat user
    setCurrentChatUser: ({commit}, user) => {
        
        let postData = { id: user.id }

        return  HTTP.post(userConversationUrl, postData)
            .then(response => {

                if (response.status === 200) {
                    commit('SET_CURRENT_CHAT_USER', user);
                    commit('SET_CONVERSATION', response.data.data);
                    return response.data.data;
                }

            })
            .catch(error => {
                console.log(error)
            })

    },

    addNewChatToConversation: ({commit}, postData) => {
                
        return  HTTP.post(addChatToConversationUrl, postData)
            .then(response => {

                //add new chat to conversation
                commit('ADD_CHAT_TO_CONVERSATION', response.data.data);
                return response.data.data;

            })
            .catch(error => {
                console.log(error)
            })

    },

    newIncomingChat: ({commit}, message) => {
        commit('ADD_CHAT_TO_CONVERSATION', message)
    }

};

const getters = {

    getUserList: state => {
        return state.userList;
    }

};

export default {
    state,
    mutations,
    actions,
    getters
};