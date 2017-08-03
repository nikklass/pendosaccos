import jquery from 'jquery';

window.$ = jquery;
window.jQuery = jquery;
window.jquery = jquery;

import axios from 'axios';

window.axios = axios; 

/*css*/

import '../sass/app.scss';

import './../css/mycss/bootstrap.min.css';
import './../css/mycss/bootstrap-colorpicker.min.css';
import './../css/mycss/jasny-bootstrap.min.css';

import './../css/mycss/jquery.toast.min.css';
import './../css/mycss/morris.css';
import './../css/mycss/jquery.dataTables.min.css';
import './../css/icon/themify-icons/themify-icons.css';
import './../css/mycss/animate.css';
import './../css/icon/simple-line-icons/simple-line-icons.css';
import './../css/icon/linea-icons/linea-icon.css';
import './../css/icon/pe-icon-7-stroke/pe-icon-7-stroke.css';
import './../css/icon/Material-Design-Iconic-Font/material-design-iconic-font.min.css';
import './../css/icon/lightgallery/lightgallery.css';
import './../css/mycss/pe-icon-7-styles.css';
import './../css/mycss/filter.css';
import './../css/mycss/owl.theme.default.min.css';
import './../css/mycss/awesome-bootstrap-checkbox.css';
import './../css/mycss/fancy-buttons.css';
import './../css/mycss/style.css'; 

/*alert js*/
/*import './../css/mycss/alertify.min.css'; 
import './../css/mycss/themes/default.min.css'; 
import './../css/mycss/themes/bootstrap.min.css'; */
/*alert js*/ 

/*require('./assets/myjs/bootstrap.min.js');
require('jquery-toast-plugin');
require('owl.carousel');
require('jquery-slimscroll');*/

/*require('waypoints/lib/jquery.waypoints.js');
require('./assets/myjs/jasny-bootstrap.js');*/

/*require('simpleweather');
require('jquery-sparkline'); 
require('jquery.counterup');  
require('gasparesganga-jquery-loading-overlay/src/loadingoverlay.js');

require('./assets/myjs/jquery.easypiechart.js');
require('./assets/myjs/Chart.min.js');  
require('./assets/myjs/raphael.min.js');

require('./assets/myjs/jquery.dataTables.min.js');

require('./assets/myjs/morris.min.js');


require('./assets/myjs/simpleweather-data.js');
require('./assets/myjs/dropdown-bootstrap-extended.js');
require('./assets/myjs/dashboard-data.js');
require('./assets/myjs/init.js');*/


/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

/*try {
    window.$ = window.jQuery = require('jquery');

    require('bootstrap-sass');
} catch (e) {}*/


window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

/*let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}*/

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

/*import Echo from 'laravel-echo'

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '3b731e398e444a456164'
});*/
