@extends('layouts.app')

@section('content')
    <div class="container-fluid pl-0 px-0">
        <div class="card mb-3">
            <div class="card-header">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.unions.index')}}">{{__('messages.ইউনিয়ন তালিকা')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('messages.নতুন')}}</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                <form action="{{route('admin.unions.store')}}" method="post">
                    @csrf
                    <div class="col-md-6 col-sm-12 row mb-2">
                        <div class="row mb-3">
                            <label  for="name">{{__('messages.ইউনিয়ন নাম(ইংরেজি)')}}<span class="text-danger">*</span></label>
                            <div class=" input-group">
                                <input class="form-control @error('name') is-invalid @enderror" name="name" id="name" type="text" placeholder="{{__('messages.ইংরেজিতে')}}" value="{{old('name')}}">
                                @error('name')
                                <span class="invalid-feedback">
                                    <strong>{{$message}}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label  for="bn_name">{{__('messages.ইউনিয়ন নাম(বাংলা)')}} <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input class="form-control @error('bn_name') is-invalid @enderror" name="bn_name" id="bn_name" type="text" placeholder="{{__('messages.বাংলায়')}}" value="{{old('bn_name')}}">
                                @error('bn_name')
                                <span class="invalid-feedback">
                                    <strong>{{$message}}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label  for="upazila_id">{{__('messages.উপজেলা')}}<span class="text-danger">*</span></label>
                            <div class=" input-group">
                                <select class="form-select @error('upazila_id') is-invalid @enderror" id="upazila_id" name="upazila_id">
                                    <option value="">{{__('messages.উপজেলা নির্বাচন করুন')}}</option>
                                    @foreach($upazilas as $upazila)
                                    <option value="{{$upazila->id}}">{{$upazila->name}}</option>
                                    @endforeach
                                </select>
                                @error('upazila_id')
                                <span class="invalid-feedback">
                                    <strong>{{$message}}</strong>
                                </span>
                                @enderror
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
        $('#upazila_id').select2({
            width: '100%',
            placeholder: "{{__('messages.উপজেলা নির্বাচন করুন')}}",
            allowClear: true
        });

    </script>
@endsection
