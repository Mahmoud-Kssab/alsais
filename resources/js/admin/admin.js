import './bootstrap';

import 'vue-multiselect/dist/vue-multiselect.min.css';
import flatPickr from 'vue-flatpickr-component';
import VueQuillEditor from 'vue-quill-editor';
import Notifications from 'vue-notification';
import Multiselect from 'vue-multiselect';
import VeeValidate from 'vee-validate';
import 'flatpickr/dist/flatpickr.css';
import VueCookie from 'vue-cookie';
import { Admin } from 'craftable';
import VModal from 'vue-js-modal'
import Vue from 'vue';

import './app-components/bootstrap';
import './index';

import 'craftable/dist/ui';

Vue.component('multiselect', Multiselect);
Vue.use(VeeValidate, {strict: true});
Vue.component('datetime', flatPickr);
Vue.use(VModal, { dialog: true, dynamic: true, injectModalsContainer: true });
Vue.use(VueQuillEditor);
Vue.use(Notifications);
Vue.use(VueCookie);

import VueQrcode from 'vue-qrcode'
Vue.component('qr', VueQrcode);

import VueHtmlToPaper from 'vue-html-to-paper';
const options = {
    name: '_blank',
    specs: [
        'fullscreen=yes',
        'titlebar=yes',
        'scrollbars=yes'
    ],
    styles: [
        'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css',
        'https://unpkg.com/kidlat-css/css/kidlat.css'
    ]
}
Vue.use(VueHtmlToPaper, options);

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
Vue.use(VueSweetalert2);

new Vue({
    mixins: [Admin],
    methods: {
        printThis(id){
            this.$htmlToPaper(id);
        }
    }
});
