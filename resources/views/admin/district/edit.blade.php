@extends('layouts.app')

@section('content')
    <div class="container-fluid pl-0 px-0">
        <div class="card mb-3">
            <div class="card-header">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.districts.index')}}">{{__('messages.জেলার তালিকা')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('messages.এডিট')}}</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                {{--@if(Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ Session::get('success') }}
                        <button class="btn-close" type="button" data-coreui-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif--}}
                <form action="{{route('admin.districts.update',  $district->id)}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="col-md-6 col-sm-12 row mb-2">
                        <label for="name">{{__('messages.জেলার নাম(ইংরেজি)')}} <span class="text-danger">*</span></label>
                        <div class=" input-group">
                            <input class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="{{__('messages.ইংরেজিতে')}}" type="text" value="{{$district->name}}">
                            @error('name')
                            <span class="invalid-feedback">
                                    <strong>{{$message}}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 row mb-2">
                        <label  for="bn_name">{{__('messages.জেলার নাম(বাংলা)')}} <span class="text-danger">*</span></label>
                        <div class=" input-group">
                            <input class="form-control @error('bn_name') is-invalid @enderror" name="bn_name" id="bn_name" type="text" placeholder="{{__('messages.বাংলায়')}}" value="{{$district->bn_name}}">
                            @error('bn_name')
                            <span class="invalid-feedback">
                                    <strong>{{$message}}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row col-md-6 col-sm-12">
                        <div class="col-md-12 text-end">
                            <button class="btn btn-success text-white" type="submit">{{__('messages.জমা দিন')}}</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
