@extends('layouts.app')

@section('content')
    <div class="container-fluid pl-0 px-0">
        <div class="card mb-3">
            <div class="card-header">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.directed_sentence.index', $directedSentence->topic_id)}}">{{__('নির্দেশিত বাক্য তালিকা')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('edit')}}</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                {{--@if($errors->count() > 0)
                    <ul class="list-group notification-object">
                        @foreach($errors->all() as $error)
                            <li class="list-group-item text-danger">
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                @endif--}}
                <form action="{{route('admin.directed_sentence.update', $directedSentence->id)}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="col-md-8 col-sm-12  mb-2">
                        <label  for="topic_id">{{__('messages.বিষয়')}} <span class="text-danger">*</span></label>
                        <div class=" input-group">
                            <input id="topic_id" type="hidden" name="topic_id" value="{{$directedSentence->topic_id}}">
                            <input class="form-control @error('topic_id') is-invalid @enderror" type="text"  value="{{$directedSentence->topics->name}}" readonly>
                            @error('topic_id')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{$message}}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-12 mb-2">
                        <div class="card">
                            <div class="card-body">
                                <div class="field_wrapper">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3 row">
                                                <label class="col-sm-3 col-form-label" for="sentence">{{__('messages.বাক্য')}}</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control @error('sentence') is-invalid @enderror" id="sentence" name="sentence" type="text" value="{{$directedSentence->sentence}}" placeholder="{{__('messages.বাংলা বাক্য')}}" required>
                                                    @error('sentence')
                                                    <span class="invalid-feedback">
                                                    <strong>{{$message}}</strong>
                                                </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label class="col-sm-3 col-form-label" for="english">{{__('messages.ইংরেজী')}}</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control @error('english') is-invalid @enderror" id="english" name="english" type="text" value="{{$directedSentence->english}}" placeholder="{{__('messages.ইংরেজী বাক্য')}}" required>
                                                    @error('english')
                                                    <span class="invalid-feedback">
                                                    <strong>{{$message}}</strong>
                                                </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8 col-sm-12">
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
    <script>
    </script>
@endsection
