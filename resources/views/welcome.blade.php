@extends('brackets/admin-ui::admin.layout.master')

@section('title', __('Alsaiss | Home'))

@section('content')
    <div class="container pt-5 pb-5" id="app">
        <div class="row align-items-center justify-content-center auth">
            <div class="col-md-6 col-lg-5">
                <div class="card">
                    <div class="card-block">
                        <create-user-form
                            :action="'{{ url('/create') }}'"
                            :data="{}"
                            inline-template>
                            <form class="form-horizontal" role="form"  @submit.prevent="onSubmit" method="POST" action="{{ url('create') }}" novalidate>
                                {{ csrf_field() }}
                                <div class="auth-header">
                                    <h1 class="auth-title">{{ __('Create Account') }}</h1>
                                    <p class="auth-subtitle">{{ __('Create account to get your QR code') }}</p>
                                </div>
                                <div class="auth-body">
                                    @include('brackets/admin-auth::admin.auth.includes.messages')
                                    <div class="form-group" :class="{'has-danger': errors.has('name'), 'has-success': fields.name && fields.name.valid }">
                                        <label for="name">{{ __('Name') }}</label>
                                        <input type="text" v-model="form.name" v-validate="'required'" class="form-control" :class="{'form-control-danger': errors.has('name'), 'form-control-success': fields.name && fields.name.valid}" id="name" name="name" placeholder="{{ __('Name') }}">
                                        <div v-if="errors.has('name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('name') }}</div>
                                    </div>

                                    <div class="form-group" :class="{'has-danger': errors.has('job'), 'has-success': fields.job && fields.job.valid }">
                                        <label for="job">{{ __('Job') }}</label>
                                        <input type="text" v-model="form.job" v-validate="'required'" class="form-control" :class="{'form-control-danger': errors.has('job'), 'form-control-success': fields.job && fields.job.valid}" id="job" name="job" placeholder="{{ __('Your Job') }}">

                                        <div v-if="errors.has('job')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('job') }}</div>
                                    </div>

                                    <div class="form-group" :class="{'has-danger': errors.has('phone'), 'has-success': fields.phone && fields.phone.valid }">
                                        <label for="phone">{{ __('Phone') }}</label>
                                        <input type="tel" v-model="form.phone" v-validate="'required'" class="form-control" :class="{'form-control-danger': errors.has('phone'), 'form-control-success': fields.phone && fields.phone.valid}" id="phone" name="phone" placeholder="{{ __('Phone') }}">

                                        <div v-if="errors.has('phone')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('phone') }}</div>
                                    </div>

                                    <div class="form-group" :class="{'has-danger': errors.has('email'), 'has-success': fields.email && fields.email.valid }">
                                        <label for="email">{{ trans('brackets/admin-auth::admin.auth_global.email') }}</label>
                                        <input type="email" v-model="form.email" v-validate="'required|email'" class="form-control" :class="{'form-control-danger': errors.has('email'), 'form-control-success': fields.email && fields.email.valid}" id="email" name="email" placeholder="{{ trans('brackets/admin-auth::admin.auth_global.email') }}">

                                        <div v-if="errors.has('email')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('email') }}</div>
                                    </div>

                                    <div class="form-group" :class="{'has-danger': errors.has('address'), 'has-success': fields.address && fields.address.valid }">
                                        <label for="address">{{ __('Address') }}</label>
                                        <textarea type="text" v-model="form.address" v-validate="'required'" class="form-control" :class="{'form-control-danger': errors.has('address'), 'form-control-success': fields.address && fields.address.valid}" id="address" name="address" placeholder="{{ __('Address') }}"></textarea>
                                        <div v-if="errors.has('address')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('address') }}</div>
                                    </div>

                                    <div class="form-group" :class="{'has-danger': errors.has('password'), 'has-success': fields.password && fields.password.valid }">
                                        <label for="password">{{ trans('brackets/admin-auth::admin.auth_global.password') }}</label>
                                        <input type="password" v-model="form.password"  v-validate="'min:7'" class="form-control" :class="{'form-control-danger': errors.has('password'), 'form-control-success': fields.password && fields.password.valid}" id="password" name="password" placeholder="{{ trans('brackets/admin-auth::admin.auth_global.password') }}">
                                        <div v-if="errors.has('password')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('password') }}</div>
                                    </div>

                                    <div class="form-group" :class="{'has-danger': errors.has('password_confirmation'), 'has-success': fields.password_confirmation && fields.password_confirmation.valid }">
                                        <label for="password_confirmation">{{ __('Password Confirmation') }}</label>
                                        <input type="password" v-model="form.password_confirmation" v-validate="'min:7'"  class="form-control" :class="{'form-control-danger': errors.has('password_confirmation'), 'form-control-success': fields.password_confirmation && fields.password_confirmation.valid}" id="password_confirmation" name="password_confirmation" placeholder="{{ trans('Password Confirmation') }}">
                                        <div v-if="errors.has('password_confirmation')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('password_confirmation') }}</div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-block"><i class="fa"></i> {{ __('Register') }}</button>
                                        <a href="{{url('/login')}}" class="btn btn-warning btn-block"><i class="fa"></i> {{ __('Login') }}</a>
                                    </div>
                                </div>
                            </form>
                        </create-user-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('bottom-scripts')
    <script type="text/javascript">
        // fix chrome password autofill
        // https://github.com/vuejs/vue/issues/1331
        document.getElementById('password').dispatchEvent(new Event('input'));
    </script>
@endsection
