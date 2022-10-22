@extends('layouts.app')

@section('content')
    <div class="container-fluid pl-0 px-0">
        <div class="card mb-3">
            <div class="card-header">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.directed_sentence.index',$topic->id)}}">{{__('নির্দেশিত বাক্য তালিকা')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('messages.নতুন')}}</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                @if($errors->count() > 0)
                    <ul class="list-group notification-object">
                        @foreach($errors->all() as $error)
                            <li class="list-group-item text-danger">
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                @endif
                <form action="{{route('admin.directed_sentence.store')}}" method="post">
                    @csrf
                    <div class="col-md-8 col-sm-12  mb-2">
                        <label  for="topic_id">{{__('messages.বিষয়')}} <span class="text-danger">*</span></label>
                        <div class=" input-group">
                            <input id="topic_id" type="hidden" name="topic_id" value="{{$topic->id}}">
                            <input class="form-control @error('topic_id') is-invalid @enderror" type="text"  value="{{$topic->name}}" readonly>
                            @error('topic_id')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{$message}}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 mb-2">
                        <div class="card">
                            <div class="card-body">
                                <div class="field_wrapper">
                                    <div class="row mb-4">
                                        {{-- <div class="col-md-12 col-sm-12  mb-2"> --}}

                                            <div class="col-5">
                                                <label  for="sentence">{{__('messages.বাক্য')}} <span class="text-danger">*</span></label>
                                                    <div class=" input-group">
                                                        <input class="form-control @error('sentence') is-invalid @enderror" id="sentence" name="sentence[]" type="text" value="{{old('sentence')}}" placeholder="{{__('messages.বাংলা বাক্য')}}" required>
                                                            @error('sentence')
                                                            <span class="invalid-feedback">
                                                            <strong>{{$message}}</strong>
                                                        </span>
                                                            @enderror
                                                    </div>
                                            </div>

                                            <div class="col-5">
                                                <label for="english">{{__('messages.ইংরেজী')}}<span class="text-danger"></span></label>
                                                <div class=" input-group">
                                                    <input class="form-control @error('english') is-invalid @enderror" id="english" name="english[]" type="text" value="{{old('english')}}" placeholder="{{__('messages.ইংরেজী বাক্য')}}" >
                                                    @error('english')
                                                    <span class="invalid-feedback">
                                                    <strong>{{$message}}</strong>
                                                </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- <div class="mb-3 row">
                                                <label class="col-sm-3 col-form-label" for="sentence">{{__('messages.বাক্য')}}</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control @error('sentence') is-invalid @enderror" id="sentence" name="sentence[]" type="text" value="{{old('sentence')}}" placeholder="{{__('messages.বাংলা বাক্য')}}" required>
                                                    @error('sentence')
                                                    <span class="invalid-feedback">
                                                    <strong>{{$message}}</strong>
                                                </span>
                                                    @enderror
                                                </div>
                                            </div> --}}
                                            {{-- <div class="mb-3 row">
                                                <label class="col-sm-3 col-form-label" for="english">{{__('messages.ইংরেজী')}}</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control @error('english') is-invalid @enderror" id="english" name="english[]" type="text" value="{{old('english')}}" placeholder="{{__('messages.ইংরেজী বাক্য')}}" required>
                                                    @error('english')
                                                    <span class="invalid-feedback">
                                                    <strong>{{$message}}</strong>
                                                </span>
                                                    @enderror
                                                </div>
                                            </div> --}}
                                        {{-- </div> --}}
                                        <div class="col-md-1 mt-4">
                                            <a href="javascript:void(0);" class="btn btn-success btn-sm rounded-circle add_button text-white" >
                                                <i class="fa-solid fa-plus"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12">
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
        @if (count($errors) > 0)
        setTimeout(function() {
            $('.notification-object').css('display', 'none');
        }, 5000);
        @endif
        // add more input field
        $(document).ready(function () {
            var maxField = 10; // Total 5 product fields we add
            var addButton = $('.add_button');
            // Add more button selector
            var addButtonSent = $('.add_button_sentence');
            var wrapper = $('.field_wrapper'); // Input fields wrapper
            var fieldHTML = `<div class="row mb-4">

                            <div class="col-5">
                                <label for="sentence">{{__('messages.বাক্য')}}</label>
                                <div class="col-sm-12">
                                    <input class="form-control" id="sentence" name="sentence[]" type="text" placeholder="{{__('messages.বাংলা বাক্য')}}"  required>
                                </div>
                            </div>
                            <div class="col-5">
                                <label for="english">{{__('messages.ইংরেজী')}}</label>
                                <div class="col-sm-12">
                                    <input class="form-control" id="english" name="english[]" type="text"  placeholder="{{__('messages.ইংরেজী')}}">
                                </div>
                            </div>

                        <div class="col-md-1 mt-4" style="width: 4.333333%;">
                            <a href="javascript:void(0);" class="btn btn-outline-success active btn-sm rounded-circle add_button_sentence text-white">
                                <i class="fa-solid fa-plus"></i>
                            </a>
                        </div>
                        <div class="col-md-1 mt-4 remove_button">
                            <a href="javascript:void(0);" class="btn btn-danger btn-sm rounded-circle text-white ">
                                <i class="fa-solid fa-minus"></i>
                            </a>
                        </div>

                    </div>`; //New input field html

            var x = 1; //Initial field counter is 1

            $(addButton).click(function () {
                // console.log("yes");
                //Check maximum number of input fields
                if (x < maxField) {
                    x++; //Increment field counter
                    $(wrapper).append(fieldHTML);
                }
            });
            $(addButtonSent).click(function () {
                // console.log("yes");
                //Check maximum number of input fields
                if (x < maxField) {
                    x++; //Increment field counter
                    $(wrapper).append(fieldHTML);
                }
            });
            //Once remove button is clicked
            $(wrapper).on('click', '.remove_button', function (e) {
                e.preventDefault();
                $(this).parent('div').remove();
                x--; //Decrement field counter
            });
            $(wrapper).on('click', '.add_button_sentence', function (e) {
                console.log("yes");
                e.preventDefault();
                $(wrapper).append(fieldHTML);
            });
        });
    </script>
@endsection
