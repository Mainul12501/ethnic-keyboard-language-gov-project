@extends('layouts.app')

@section('content')
    <div class="container-fluid pl-0 px-0">
        <div class="card mb-3">
            <div class="card-header">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.languages.index')}}">{{__('messages.ভাষার তালিকা')}}</a></li>
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
                <form action="{{route('admin.languages.update',  $language->id)}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="col-md-6 col-sm-12 row mb-2">
                        <label  for="name">{{__('messages.ভাষার নাম')}} <span class="text-danger">*</span></label>
                        <div class=" input-group">
                            <input class="form-control @error('name') is-invalid @enderror" name="name" id="name" type="text" placeholder="{{__('messages.ভাষার নাম')}}" value="{{$language->name}}">
                            @error('name')
                            <span class="invalid-feedback">
                                    <strong>{{$message}}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 row mb-2">
                        <label  for="name">{{__('messages.উপভাষার নাম')}}<span class="text-danger">*</span></label>
                        <div class=" input-group">
                            <select class="form-select" id="sub_language" name="sub_language[]" multiple>
                                @foreach($subLanguages as $key =>$subLanguage)
                                    <option value="{{$subLanguage}}" selected>{{$subLanguage}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 row mb-2">
                        <label  for="district_id">{{__('messages.অবস্থান')}} <span class="text-danger">*</span></label>
                        <div class=" input-group">
                            <select class="form-select @error('district_id') is-invalid @enderror" id="district_id" name="district_id[]" multiple="">
                                <option value="">{{__('messages.জেলা নির্বাচন করুন')}}</option>
                                @foreach($districts as $district)
                                    <option value="{{$district->id}}" {{in_array($district->id , $languageDistcricts )? 'selected': ''}}>{{$district->bn_name}}</option>
                                @endforeach
                            </select>
                            @error('district_id')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{$message}}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row col-md-6">
                        <div class="col-md-12 text-end">
                            <button class="btn btn-success text-white" type="submit">{{__('messages.জমা দিন')}}</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
@section('language-js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
    <script>
        $('#district_id').select2({
            width: '100%',
            placeholder: "{{__('messages.জেলা নির্বাচন করুন')}}",
            allowClear: true
        });
        $('#sub_language').select2({
            width: '100%',
            tags: true,
            // tokenSeparators: [',', ' ']
        });
    </script>
@endsection
