@extends('layouts.app')

@section('content')
    <div class="container-fluid pl-0 px-0">
        <div class="card mb-3">
            <div class="card-header">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">ভাষার তালিকা</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('এডিট')}}</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{route('admin.language_details.update',  $language->id)}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="mb-3 row row-cols-2" >
                        <div class="col-6 row">
                            <label class="col-md-2 col-sm-2 col-form-label" for="name">ভাষার নাম</label>
                            <div class=" col-md-10 col-sm-10">
                                <input class="form-control" name="name" id="name" type="text" value="{{$language->name}}">
                            </div>
                        </div>
                        <div class="col-6 row">
                            <label class="col-md-2 col-form-label" for="location">অবস্থান</label>
                            <div class="col-md-10">
                                <input class="form-control" name="location" id="location" type="text" value="{{$language->location}}">
                            </div>
                        </div>
                    </div>
                    <div class="row second_field_wrapper">
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-header">নির্দেশিত</div>
                                <div class="card-body">

                                    <div class="mb-3 row">
                                        <label class="col-md-2 col-sm-2 col-form-label" for="name">বিষয়</label>
                                        <div class=" col-md-8 col-sm-10">
                                            <input class="form-control" id="subject_name" name="subject_name" type="text" value="">

                                        </div>
                                    </div>
                                    <div class="mb-3 row first_field_wrapper">
                                        @foreach( $directedLanguages  as $directedLanguage)
                                        <div class="row mb-2">
                                            <label class="col-md-2 col-sm-2 col-form-label" for="sentence"></label>
                                            <div class="col-md-8">
                                                <input type="hidden" name="language_directed_id[]" value="{{$directedLanguage->id}}">
                                                <input class="form-control" id="sentence[]" name="sentence[]" type="text" placeholder="বাক্য" value="{{$directedLanguage->sentence}}">
                                            </div>
                                            <div class="col-md-2 pt-1 px-0 add_button_first">
                                                <a href="javascript:void(0);" class="btn btn-success btn-sm rounded-circle">
                                                    <svg class="icon text-white">
                                                        <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-plus')}}"></use>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card" style="">
                                <div class="card-header">স্বতঃস্ফূর্ত</div>
                                <div class="card-body">
                                    <div class="row field_wrapper mb-3">
                                        @foreach($spontaneousLanguages as $spontaneousLanguage)
                                        <div class="row mb-2">
                                            <div class="col-md-10">
                                                <input type="hidden" name="language_spontaneous_id[]" value="{{$spontaneousLanguage->id}}">
                                                <input class="form-control" id="word[]" name="word[]" type="text" placeholder="গৃহ " value="{{$spontaneousLanguage->word}}">
                                            </div>
                                            <div class="col-md-2 p-0 add_button">
                                                <a href="javascript:void(0);" class="btn btn-success btn-sm rounded-circle">
                                                    <svg class="icon text-white">
                                                        <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-plus')}}"></use>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-end">
                            <button class="btn btn-primary" type="submit">জমা দিন</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('language_old-add-button-js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        /*add sentence */
        $(document).ready(function(){
            var maxField = 10; //Input fields increment limitation
            var addButton = $('.add_button_first'); //Add button selector
            var wrapper = $('.first_field_wrapper'); //Input field wrapper
            var fieldHTML = '<div class="row mb-2">\n' +
                '                      <label class="col-md-2 col-sm-2 col-form-label" for="sentence"></label>\n' +
                '                      <div class="col-md-8">\n' +
                '                        <input class="form-control" id="sentence" name="sentence[]" type="text" placeholder="বাক্য">\n' +
                '                      </div>\n' +
                '                      <div class="col-md-2 pt-1 px-0 remove_button_first">\n' +
                '                        <a href="javascript:void(0);" class="btn btn-success btn-sm rounded-circle">\n' +
                '                          <svg class="icon text-white">\n' +
                '                            <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-minus')}}"></use>\n' +
                '                          </svg>\n' +
                '                        </a>\n' +
                '                      </div>\n' +
                '                    </div>'; //New input field html
            var x = 1; //Initial field counter is 1

            //Once add button is clicked
            $(addButton).click(function(){
                //Check maximum number of input fields
                if(x < maxField){
                    x++; //Increment field counter
                    $(wrapper).append(fieldHTML); //Add field html
                }
            });

            //Once remove button is clicked
            $(wrapper).on('click', '.remove_button_first', function(e){
                e.preventDefault();
                $(this).parent('div').remove(); //Remove field html
                x--; //Decrement field counter
            });
        });

        $(document).ready(function(){
            var maxField = 10; //Input fields increment limitation
            var addButton = $('.add_button'); //Add button selector
            var wrapper = $('.field_wrapper'); //Input field wrapper
            var fieldHTML = '<div class="row mb-2"><div class="col-md-10">\n' +
                '                      <input class="form-control" id="word" name="word[]" type="text" placeholder=" ">\n' +
                '                    </div>\n' +
                '                    <div class="col-md-2 p-0 remove_button">\n' +
                '                      <a href="javascript:void(0);" class="btn btn-success btn-sm rounded-circle">\n' +
                '                        <svg class="icon text-white">\n' +
                '                          <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-minus')}}"></use>\n' +
                '                        </svg>\n' +
                '                      </a>\n' +
                '                    </div></div>'; //New input field html
            var x = 1; //Initial field counter is 1

            //Once add button is clicked
            $(addButton).click(function(){
                //Check maximum number of input fields
                if(x < maxField){
                    x++; //Increment field counter
                    $(wrapper).append(fieldHTML); //Add field html
                }
            });

            //Once remove button is clicked
            $(wrapper).on('click', '.remove_button', function(e){
                e.preventDefault();
                $(this).parent('div').remove(); //Remove field html
                x--; //Decrement field counter
            });
        });

    </script>
@endsection
