import AppForm from '../app-components/Form/AppForm';

Vue.component('create-user-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                name: '',
                phone: '',
                email:  '' ,
                job:  '' ,
                password:  '' ,
                address:''
            }
        }
    }
});
