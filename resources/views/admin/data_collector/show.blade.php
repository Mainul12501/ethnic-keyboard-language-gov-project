@extends('layouts.app')

@section('content')
    <div class="container-fluid pl-0 px-0">
        <div class="card mb-3">
            <div class="card-header">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        @if(!Auth::user()->hasRole(['Final Linguist','Linguist']))
                        <li class="breadcrumb-item"><a href="#">{{__('messages.কর্মিদল')}}</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.data_collectors.index')}}">{{__('messages.ডাটা কালেক্টর তালিকা')}}</a></li>
                        @endif
                        <li class="breadcrumb-item active" aria-current="page">{{__('messages.প্রদর্শন')}}</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label class="col-md-2 col-sm-2 col-form-label" for="name">{{__('messages.নাম')}} </label>
                            <div class=" col-md-10 col-sm-10">
                                <strong>{{$dataCollector->name}}</strong>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-2 col-form-label" for="phone">{{__('messages.মোবাইল')}}</label>
                            <div class="col-md-10">
                                <strong>{{$dataCollector->phone}}</strong>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-2 col-sm-2 col-form-label" for="email">{{__('messages.ইমেইল')}}</label>
                            <div class=" col-md-10 col-sm-10">
                                <strong>{{$dataCollector->email}}</strong>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-2 col-sm-2 col-form-label" for="short_bio">{{__('messages.বায়োগ্রাফি')}}</label>
                            <div class=" col-md-10 col-sm-10">
                                <strong>{{$dataCollector->short_bio}}</strong>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-2 col-sm-2 col-form-label" for="address">{{__('messages.ঠিকানা')}}</label>
                            <div class=" col-md-10 col-sm-10">
                                <strong>{{$dataCollector->address}}</strong>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label class="col-md-2 col-sm-2 col-form-label" for="image">{{__('messages.ছবি')}}</label>
                            <div class="col-md-2 col-sm-2">
                                <div class="avatar avatar-md">
                                    <img class="avatar-img rounded" src="{{(!empty($dataCollector->avatar))? asset($dataCollector->avatar) : asset('assets/coreui/assets/img/avatars/8.jpg')}}" alt="image">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-2 col-sm-2 col-form-label" for="join_date">{{__('messages.যোগদান তারিখ')}}</label>
                            <div class=" col-md-10 col-sm-10">
                                <strong>{{\Carbon\Carbon::parse($dataCollector->join_date)->format('d/m/Y')}}</strong>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-2 col-sm-2 col-form-label" for="nid">{{__('messages.এনআইডি')}}</label>
                            <div class=" col-md-10 col-sm-10">
                                <strong>{{$dataCollector->nid}}</strong>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-2 col-sm-2 col-form-label" for="education">{{__('messages.সর্বোচ্চ শিক্ষা')}}</label>
                            <div class=" col-md-10 col-sm-10">
                                <strong>{{$dataCollector->education}}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
