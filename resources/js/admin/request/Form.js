import AppForm from '../app-components/Form/AppForm';

Vue.component('request-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                activated:  false ,
                message:  '' ,
                sender_id:  '' ,
                user_id:  '' ,
                
            }
        }
    }

});