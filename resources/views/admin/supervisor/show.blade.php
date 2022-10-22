@extends('layouts.app')

@section('content')
    <div class="container-fluid pl-0 px-0">
        <div class="card mb-3">
            <div class="card-header">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">{{__('messages.কর্মিদল')}}</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.supervisors.index')}}">{{__('messages.সুপারভাইজর তালিকা')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Show</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label class="col-md-2 col-sm-2 col-form-label" for="name">{{__('messages.নাম')}} </label>
                            <div class=" col-md-10 col-sm-10">
                                <strong>{{$supervisor->name}}</strong>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-2 col-form-label" for="phone">{{__('messages.মোবাইল')}}</label>
                            <div class="col-md-10">
                                <strong>{{$supervisor->phone}}</strong>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-2 col-sm-2 col-form-label" for="email">{{__('messages.ইমেইল')}}</label>
                            <div class=" col-md-10 col-sm-10">
                                <strong>{{$supervisor->email}}</strong>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-2 col-sm-2 col-form-label" for="short_bio">{{__('messages.বায়োগ্রাফি')}}</label>
                            <div class=" col-md-10 col-sm-10">
                                <strong>{{$supervisor->short_bio}}</strong>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-2 col-sm-2 col-form-label" for="address">{{__('messages.ঠিকানা')}}</label>
                            <div class=" col-md-10 col-sm-10">
                                <strong>{{$supervisor->address}}</strong>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label class="col-md-2 col-sm-2 col-form-label" for="image">{{__('messages.ছবি')}}</label>
                            <div class="col-md-2 col-sm-2">
                                <div class="avatar avatar-md">
                                    <img class="avatar-img rounded" src="{{(!empty($supervisor->avatar))? asset($supervisor->avatar) : asset('assets/coreui/assets/img/avatars/8.jpg')}}" alt="image">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-2 col-sm-2 col-form-label" for="join_date">{{__('messages.যোগদান তারিখ')}}</label>
                            <div class=" col-md-10 col-sm-10">
                                <strong>{{\Carbon\Carbon::parse($supervisor->join_date)->format('d/m/Y')}}</strong>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-2 col-sm-2 col-form-label" for="nid">{{__('messages.এনআইডি')}}</label>
                            <div class=" col-md-10 col-sm-10">
                                <strong>{{$supervisor->nid}}</strong>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-2 col-sm-2 col-form-label" for="education">{{__('messages.সর্বোচ্চ শিক্ষা')}}</label>
                            <div class=" col-md-10 col-sm-10">
                                <strong>{{$supervisor->education}}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
