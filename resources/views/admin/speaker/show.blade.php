@extends('layouts.app')

@section('content')
    <div class="container-fluid pl-0 px-0">
        <div class="card mb-3">
            <div class="card-header">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{--{{route('admin.speakers.index')}}--}}">স্পিকার</a></li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label class="col-md-2 col-sm-2 col-form-label" for="name"> নাম</label>
                            <div class=" col-md-10 col-sm-10">
                                <strong>{{$speaker->name}}</strong>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-2 col-form-label" for="phone">মোবাইল</label>
                            <div class="col-md-10">
                                <strong>{{$speaker->phone}}</strong>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-2 col-sm-2 col-form-label" for="email">ইমেইল</label>
                            <div class=" col-md-10 col-sm-10">
                                <strong>{{$speaker->email}}</strong>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-2 col-sm-2 col-form-label" >বয়স</label>
                            <div class=" col-md-10 col-sm-10">
                                <strong>{{$speaker->age}}</strong>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-2 col-sm-2 col-form-label" >পেশা</label>
                            <div class=" col-md-10 col-sm-10">
                                <strong>{{$speaker->occupation}}</strong>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-2 col-sm-2 col-form-label" >ঠিকানা</label>
                            <div class=" col-md-10 col-sm-10">
                                <strong>{{$speaker->address}}</strong>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label class="col-md-2 col-sm-2 col-form-label" for="image">ছবি</label>
                            <div class="col-md-2 col-sm-2">
                                <div class="avatar avatar-md">
                                    <img class="avatar-img rounded" src="{{(!empty($speaker->image))? asset($speaker->image) : asset('assets/coreui/assets/img/avatars/8.jpg')}}" alt="image">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-2 col-sm-2 col-form-label" >লিঙ্গ</label>
                            <div class=" col-md-10 col-sm-10">
                                <strong>{{($speaker->gender == 0)? 'পুরুষ': 'মহিলা'}}</strong>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-2 col-sm-2 col-form-label">সর্বোচ্চ শিক্ষা</label>
                            <div class=" col-md-10 col-sm-10">
                                <strong>{{$speaker->education}}</strong>
                            </div>
                        </div>
                        @if(isset($speaker->district))
                        <div class="row mb-3">
                            <label class="col-md-2 col-sm-2 col-form-label">জেলা</label>
                            <div class=" col-md-10 col-sm-10">
                                <strong>{{$speaker->district->name}}</strong>
                            </div>
                        </div>
                        @endif
                        @if(isset($speaker->upazila))
                        <div class="row mb-3">
                            <label class="col-md-2 col-sm-2 col-form-label" >উপজেলা</label>
                            <div class=" col-md-10 col-sm-10">
                                <strong>{{$speaker->upazila->name}}</strong>
                            </div>
                        </div>
                        @endif
                        @if(isset($speaker->union))
                        <div class="row mb-3">
                            <label class="col-md-2 col-sm-2 col-form-label" for="data_collector_type_id">ইউনিয়ন</label>
                            <div class=" col-md-10 col-sm-10">
                                <strong>{{$speaker->union->name}}</strong>
                            </div>
                        </div>
                        @endif
                        <div class="row mb-3">
                            <label class="col-md-2 col-sm-2 col-form-label" for="data_collector_type_id">গ্রাম</label>
                            <div class=" col-md-10 col-sm-10">
                                <strong>{{$speaker->area}}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
