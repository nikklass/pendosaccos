import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

import authUser from './modules/authUser';
import currentUser from './modules/currentUser';
import posts from './modules/posts';
import chats from './modules/chats';
import comments from './modules/comments';
import likes from './modules/likes';
import notifications from './modules/notifications';

export default new Vuex.Store({
    modules: {
        authUser,
        currentUser,
        chats,
        posts,
        comments,
        likes
        //notifications
    }
});