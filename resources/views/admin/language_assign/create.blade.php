@extends('layouts.app')

@section('content')
    <div class="container-fluid pl-0 px-0">
        <div class="card mb-3">
            <div class="card-header">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.language_assigns.index')}}">{{__('messages.অ্যাসাইন ভাষার তালিকা')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('messages.নতুন')}}</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                <form action="{{route('admin.language_assigns.store')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="row mb-3">
                                <label class="col-md-2 col-sm-3 col-form-label" for="language_id">{{__('messages.ভাষার নাম')}}</label>
                                <div class=" col-md-10 col-sm-9">
                                    <select class="form-select @error('language_id') is-invalid @enderror" id="language_id" name="language_id">
                                        <option value="">{{__('messages.ভাষা নির্বাচন করুন')}}</option>
                                        @if(!empty($languages))
                                        @foreach($languages as $key =>$language)
                                            <option value="{{$key}}">{{$language}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @error('language_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-md-2 col-sm-3 col-form-label" for="topic">{{__('messages.নির্দেশিত')}}</label>
                                <div class=" col-md-10 col-sm-9">
                                    <label><input class="form-check-input" id="directed-all-select" type="checkbox" value="{{isset($key)? $key:''}}"> All Select</label>
                                    <br/>
                                    @foreach($directedTopics as $key => $directedTopic)
                                        <div class="form-check form-check-inline" style="width: 6rem;">
                                            <input class="form-check-input @error('topic') is-invalid @enderror" id="topic" name="topic[]" type="checkbox" value="{{$key}}">
                                            <label class="form-check-label" for="topic">{{ $directedTopic }}</label>
                                        </div>
                                    @endforeach
                                    @error('topic')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-md-2 col-sm-3 col-form-label" for="spontaneous">{{__('messages.স্বতঃস্ফূর্ত')}}</label>
                                <div class=" col-md-10 col-sm-9">
                                    <label><input class="form-check-input" id="spontaneous-all-select" type="checkbox" value="{{isset($key)? $key : ''}}"> All Select</label>
                                    <br/>
                                    @foreach($spontaneouses as $key =>$spontaneous)
                                        <div class="form-check form-check-inline" style="width: 6rem;">
                                            <input class="form-check-input @error('spontaneous') is-invalid @enderror" name="spontaneous[]" id="spontaneous" type="checkbox" value="{{$key}}">
                                            <label class="form-check-label" for="spontaneous">{{ $spontaneous }}</label>
                                        </div>
                                    @endforeach
                                    @error('spontaneous')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-12 text-end">
                                    <button class="btn btn-success text-white" type="submit">{{__('messages.জমা দিন')}}</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
@section('language-assign-js')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>

        $('#directed-all-select').click(function () {
            $('input[id=topic]').not(this).prop('checked', this.checked);
        });
        $("#spontaneous-all-select").click(function(){
            $('input[id=spontaneous]').prop('checked', this.checked);

        });

    </script>
@endsection
