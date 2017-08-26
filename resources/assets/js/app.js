
import Vue from 'vue';
//import VueRouter from 'vue-router';
import axios from 'axios';


import 'jquery';

window.$ = window.jQuery = require('jquery');

require('./bootstrap');

//import App from './App.vue';



//import VueAxios from 'vue-axios'; 
//import { routes } from './routes/index.js';
//import store from './store/store';
import moment from 'moment';

import Form from './core/Form';
import { HTTP } from './common/http-common';

import { userUrl, getHeader } from './config';
import { clientId, clientSecret } from './.env'; 

//import custom components
//import

//add x-csrf-token to all axios requests
let token = document.head.querySelector('meta[name="csrf-token"]');
axios.interceptors.request.use(function(config) {
    config.headers['X-CSRF-TOKEN'] = token
    return config
})

//make axios available as $http
Vue.prototype.$http = axios

window.Vue = Vue;
//window.axios = axios; 
window.Form = Form;
window.HTTP = HTTP;


Vue.component('app', App); 

Vue.component('searchListItems', require('./components/searchListItems.vue'));


//init vue router
/*const router = new VueRouter({
    routes,
    mode: 'history',
    scrollBehavior(to, from, savedPosition){
        if (savedPosition){
            return savedPosition; 
        }
        if (to.hash){
            return { selector: to.hash };
        }
        return {x: 0, y:0};
    }
});*/


//check for auth guarded pages
/*router.beforeEach((to, from, next) => {


    //add user auth token to each route that requires authorization
    if (to.meta.requiresAuth){
          const authUser = JSON.parse(window.localStorage.getItem('authUser'));
          if ((authUser !== null) && (authUser.access_token !== null)){
                //console.log('app js main user check');
                //check if token still valid
                //get user data 
                axios.get(userUrl, { headers: getHeader() })
                    .then(successdata => {
                        //proceed as usual
                        next();                               
                    })
                    .catch(error => { 
                        //redirect to login page
                        next({ name: 'login' });
                    });

          } else {
            //user not logged in or token not present, redirect to login page
            next({ name: 'login' });
          }
    }
   
    next();

});*/


/*new Vue ({

    el: "#app"

});*/