import AppForm from '../app-components/Form/AppForm';

Vue.component('auth-user-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                email:  '' ,
                password:  '' ,
            }
        }
    },
    methods: {
        onSuccess(data){
            if(data.success){
                this.$swal.fire({
                    icon: 'success',
                    text: data.message
                });
                window.location.replace('/qr/show')
            }
            else {
                this.submiting = false;
                this.$swal.fire({
                    icon: 'error',
                    text: data.message
                });
            }

        },
        onFail(data){
            this.submiting = false;
            this.$swal.fire({
                icon: 'error',
                text: data.message
            });
        }
    }
});
