@extends('brackets/admin-ui::admin.layout.master')

@section('title', __('Alsaiss | QR'))

@section('content')
    <div class="container pt-5 pb-5" id="app">
        <div class="row align-items-center justify-content-center auth">
            <div class="col-md-6 col-lg-5">
                <div class="card p-3">
                    <div class="card-block text-center">
                        @if($user->public)
                            <i class="fa fa-globe fa-5x text-success"></i>
                            <h1>{{__('Public Account')}}</h1>
                            <h3>{{__('Welcome To Alsaiss ') }} <b>{{auth('users')->user()->name}}</b></h3>
                            <p>{{__('This QR Data Is')}}</p>
                            <div class="list-group text-left">
                                <a href="#" class="list-group-item list-group-item-action"><i class="fa fa-user"></i> <b>{{$user->name}}</b></a>
                                <a href="tel: {{$user->phone}}" class="list-group-item list-group-item-action"><i class="fa fa-phone"></i> <b>{{$user->phone}}</b></a>
                                <a href="mailto: {{$user->email}}" target="_blank" class="list-group-item list-group-item-action"><i class="fa fa-envelope"></i> <b>{{$user->email}}</b></a>
                                <a href="https://www.google.com/maps/search/{{$user->address}}" target="_blank" class="list-group-item list-group-item-action"><i class="fa fa-map"></i> <b>{{$user->address}}</b></a>
                            </div>
                        @else
                            <form method="POST" action="{{url('qr/send')}}">
                                @csrf
                                <i class="fa fa-lock fa-5x text-danger"></i>
                                <h1>{{__('Private Account!')}}</h1>
                                <h3>{{__('Welcome To Alsaiss ') }} <b>{{auth('users')->user()->name}}</b></h3>
                                <p>{{__('Send Request To User To Get Data')}}</p>
                                <div class="form-group mb-3">
                                    <label for="message">{{__('Your Message')}}</label>
                                    <textarea rows="5" style="height: 200px;" class="form-control" id="message" name="message" required></textarea>
                                </div>
                                <input type="hidden" value="{{$user->id}}" name="user">
                                <button class="btn btn-primary btn-block"><i class="fa fa-send"></i> {{__('Send')}}</button>
                            </form>
                        @endif

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
