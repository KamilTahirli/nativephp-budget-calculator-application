import $ from 'jquery';

window.$ = window.jQuery = $;

import axios from 'axios';

window.axios = axios;

import moment from 'moment';
window.moment = moment;

import '@fortawesome/fontawesome-free/css/all.min.css';
import '@fortawesome/fontawesome-free/js/all.js';
import AirDatepicker from 'air-datepicker';
window.AirDatepicker = AirDatepicker;
import 'air-datepicker/air-datepicker.css';

document.addEventListener("DOMContentLoaded", function () {
    import("../assets/frontend/js/scripts.js");
    import ('../assets/frontend/vendor/bootstrap/js/bootstrap.bundle.min.js');
    import ('../assets/frontend/vendor/jquery/jquery.min.js');
});
