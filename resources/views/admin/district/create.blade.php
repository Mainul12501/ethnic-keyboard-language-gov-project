@extends('layouts.app')

@section('content')
    <div class="container-fluid pl-0 px-0">
        <div class="card mb-3">
            <div class="card-header">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.districts.index')}}">{{__('messages.জেলার তালিকা')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('messages.নতুন')}}</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                <form action="{{route('admin.districts.store')}}" method="post">
                    @csrf
                    <div class="col-md-6 col-sm-12 row mb-2">
                        <label  for="name">{{__('messages.জেলার নাম(ইংরেজি)')}} <span class="text-danger">*</span></label>
                        <div class=" input-group">
                            <input class="form-control @error('name') is-invalid @enderror" name="name" id="name" type="text" placeholder="{{__('messages.ইংরেজিতে')}}" value="{{old('name')}}">
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
                            <input class="form-control @error('bn_name') is-invalid @enderror" name="bn_name" id="bn_name" type="text" placeholder="{{__('messages.বাংলায়')}}" value="{{old('bn_name')}}">
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
