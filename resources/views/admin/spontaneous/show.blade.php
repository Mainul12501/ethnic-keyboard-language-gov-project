@extends('layouts.app')

@section('content')
    <div class="container-fluid pl-0 px-0">
        <div class="card mb-3">
            <div class="card-header">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">{{__('messages.স্বতঃস্ফূর্ত')}}  </a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.spontaneouses.index')}}">{{__('messages.স্বতঃস্ফূর্ত তালিকা')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Show</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label class="col-md-2 col-sm-2 col-form-label">{{__('messages.কীওয়ার্ড')}}</label>
                            <div class=" col-md-10 col-sm-10 col-form-label">
                                <span>{{$spontaneous->word}}</span>
                            </div>
                        </div>
                        {{--<div class="row mb-3">
                            <label class="col-md-2 col-sm-2 col-form-label"> বাক্য</label>
                            <div class=" col-md-10 col-sm-10 col-form-label">
                                <span>{{$directed->sentence}}</span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-2 col-form-label">ইংরেজী</label>
                            <div class="col-md-10 col-form-label">
                                <span>{{$directed->english}}</span>
                            </div>
                        </div>--}}

                    </div>
                    <div class="col-md-6">

                       {{-- <div class="row mb-3">
                            <label class="col-md-2 col-sm-2 col-form-label" for="education">সর্বোচ্চ শিক্ষা</label>
                            <div class=" col-md-10 col-sm-10">
                                <strong>{{$dataCollector->education}}</strong>
                            </div>
                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
