@extends('brackets/admin-ui::admin.layout.master')

@section('title', __('Alsaiss | Profile'))

@section('content')
    <div class="container pt-5 pb-5" id="app">
        <div class="row align-items-center justify-content-center auth">
            <div class="col-md-6 col-lg-5">
                <div class="card p-3">
                    <div class="card-block text-center">
                        <div id="qr">
                            <qr style="margin-left: auto; margin-right: auto; display: block; width: 30%;" value="{{url('qr/' . auth('users')->user()->uuid)}}"></qr>
                            <h3 class="text-center" contenteditable="true">{{__('Scan To Contact Me')}}</h3>
                            <p class="text-center"><b>{{ucfirst('alsaiss.com')}}</b></p>
                        </div>
                        <h3>{{__('Welcome To Alsaiss ') }} <b>{{auth('users')->user()->name}}</b></h3>
                        <p>{{__('Print This QR Code And Use It In Your Car')}}</p>
                        <button @click="printThis('qr')" class="btn btn-primary"><i class="fa fa-print"></i> {{__('Print')}}</button>
                        <form class="d-inline" method="POST" action="{{url('qr/public')}}">
                            @csrf
                            @if(auth('users')->user()->public)
                                <button type="submit" class="btn btn-warning text-white"><i class="fa fa-lock"></i> {{__('Private')}}</button>
                             @else
                                <button type="submit" class="btn btn-success text-white"><i class="fa fa-globe"></i> {{__('Public')}}</button>
                            @endif

                        </form>
                        <a href="{{url('/logout')}}"  class="btn btn-danger"><i class="fa fa-lock"></i> {{__('Logout')}}</a>
                        <br><br>
                        <a href="{{url('qr/my-requests')}}"  class="btn btn-primary"><i class="fa fa-send"></i> {{__('My Requests')}}</a>
                        <a href="{{url('qr/others-requests')}}"  class="btn btn-primary"><i class="fa fa-reply"></i> {{__('Others Requests')}}</a>
                    </div>
                </div>
                @if(isset($data))
                    <request-listing
                    :data="{{ $data->toJson() }}"
                    :url="'{{ url('qr/my-requests') }}'"
                    inline-template
                >
                    <div class="card p-3">
                        <div class="card-header">
                            <h3 class="text-center">{{__('My Requests')}}</h3>
                        </div>
                        <table class="table table-hover table-bordered">
                            <thead>
                            <tr>

                                <th is='sortable' :column="'user_id'">{{ __('To') }}</th>
                                <th is='sortable' :column="'created_at'">{{ __('Time') }}</th>
                                <th :column="'message'">{{ __('Message') }}</th>
                                <th>{{__('Action')}}</th>

                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(item, index) in collection" :key="item.id">
                                <td>@{{ item.user_id.name }}</td>
                                <td>@{{ item.created_at | date }}</td>
                                <td>@{{ item.message }}</td>
                                <td>
                                    <span v-if="!item.activated" class="badge badge-danger p-3"><i class="fa fa-spin"></i> {{__('Pending')}}</span>
                                    <a v-else  :href="'tel:'+item.user_id.phone" class="badge badge-primary p-3"><i class="fa fa-phone"></i> {{__('Call')}}</a>
                                </td>

                            </tr>
                            </tbody>
                        </table>
                        <div class="row" v-if="pagination.state.total > 0">
                            <div class="col-sm">
                                <span class="pagination-caption">{{ trans('brackets/admin-ui::admin.pagination.overview') }}</span>
                            </div>
                            <div class="col-sm-auto">
                                <pagination></pagination>
                            </div>
                        </div>

                        <div class="no-items-found" v-if="!collection.length > 0">
                            <i class="icon-magnifier"></i>
                            <h3>{{ trans('brackets/admin-ui::admin.index.no_items') }}</h3>
                            <p>{{ trans('brackets/admin-ui::admin.index.try_changing_items') }}</p>
                        </div>
                    </div>
                </request-listing>
                @elseif(isset($other))
                    <request-listing
                    :data="{{ $other->toJson() }}"
                    :url="'{{ url('qr/others-requests') }}'"
                    inline-template
                >
                    <div class="card p-3">
                        <div class="card-header">
                            <h3 class="text-center">{{__('Others Requests')}}</h3>
                        </div>
                        <table class="table table-hover table-bordered">
                            <thead>
                            <tr>

                                <th is='sortable' :column="'sender_id'">{{ __('Sender') }}</th>
                                <th is='sortable' :column="'created_at'">{{ __('Time') }}</th>
                                <th :column="'message'">{{ __('Message') }}</th>
                                <th is='sortable' :column="'activated'">{{ __('Approved?') }}</th>

                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(item, index) in collection" :key="item.id" :class="bulkItems[item.id] ? 'bg-bulk' : ''">
                                <td>@{{ item.sender_id.name }}</td>
                                <td>@{{ item.created_at | date }}</td>
                                <td>@{{ item.message }}</td>
                                <td>
                                    <label class="switch switch-3d switch-success">
                                        <input type="checkbox" class="switch-input" v-model="collection[index].activated" @change="toggleSwitch('{{url('qr/update')}}/'+item.id, 'activated', collection[index])">
                                        <span class="switch-slider"></span>
                                    </label>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="row" v-if="pagination.state.total > 0">
                            <div class="col-sm">
                                <span class="pagination-caption">{{ trans('brackets/admin-ui::admin.pagination.overview') }}</span>
                            </div>
                            <div class="col-sm-auto">
                                <pagination></pagination>
                            </div>
                        </div>

                        <div class="no-items-found" v-if="!collection.length > 0">
                            <i class="icon-magnifier"></i>
                            <h3>{{ trans('brackets/admin-ui::admin.index.no_items') }}</h3>
                            <p>{{ trans('brackets/admin-ui::admin.index.try_changing_items') }}</p>
                        </div>
                    </div>
                </request-listing>
                @endif

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
