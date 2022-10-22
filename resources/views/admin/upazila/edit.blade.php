@extends('layouts.app')

@section('content')
    <div class="container-fluid pl-0 px-0">
        <div class="card mb-3">
            <div class="card-header">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.upazilas.index')}}">{{__('messages.উপজেলার তালিকা')}}</a></li>
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
                <form action="{{route('admin.upazilas.update',  $upazila->id)}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="col-md-6 col-sm-12 row mb-2">
                        <div class="row mb-3">
                            <label  for="name">{{__('messages.উপজেলার নাম(ইংরেজি)')}}<span class="text-danger">*</span></label>
                            <div class=" input-group">
                                <input class="form-control @error('name') is-invalid @enderror" name="name" id="name" type="text" value="{{$upazila->name}}" placeholder="{{__('messages.ইংরেজিতে')}}">
                                @error('name')
                                <span class="invalid-feedback">
                                    <strong>{{$message}}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label  for="bn_name">{{__('messages.উপজেলার নাম(বাংলা)')}} <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input class="form-control @error('bn_name') is-invalid @enderror" name="bn_name" id="bn_name" type="text" value="{{$upazila->bn_name}}" placeholder="{{__('messages.বাংলায়')}}" value="{{old('bn_name')}}">
                                @error('bn_name')
                                <span class="invalid-feedback">
                                    <strong>{{$message}}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label  for="district_id">{{__('messages.জেলা')}} <span class="text-danger">*</span></label>
                            <div class=" input-group">
                                <select class="form-select" id="district_id" name="district_id">
                                    <option value="">{{__('messages.জেলা নির্বাচন করুন')}}</option>
                                    @foreach($districts as $key =>$district)
                                        <option value="{{$district->id}}" {{($district->id === $upazila->district_id)? 'selected': ''}}>{{$district->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-end">
                                <button class="btn btn-success text-white" type="submit">{{__('messages.জমা দিন')}}</button>
                            </div>
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
@endsection
@section('language-filter-js')
    <script>
        $('#district_id').select2({
            width: '100%',
            placeholder: "{{__('messages.জেলা নির্বাচন করুন')}}",
            allowClear: true
        });

    </script>
@endsection
