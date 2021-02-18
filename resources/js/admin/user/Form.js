import AppForm from '../app-components/Form/AppForm';

Vue.component('user-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                activated:  false ,
                address:  '' ,
                avatar:  '' ,
                email:  '' ,
                email_verified_at:  '' ,
                job:  '' ,
                name:  '' ,
                password:  '' ,
                phone:  '' ,
                uuid:  '' ,
            },
            mediaCollections: ['avatar']
        }
    }

});
