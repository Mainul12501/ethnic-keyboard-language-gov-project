@extends('layouts.app')

@section('content')
    <div class="container-fluid pl-0 px-0">
        <div class="card mb-3">
            <div class="card-header">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.language_details.index')}}">ভাষার তালিকা</a></li>
                        <li class="breadcrumb-item active" aria-current="page">নতুন</li>
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
                @if(Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                @endif
                <form action="{{route('admin.language_details.store')}}" method="post">
                    @csrf
                    <div class="mb-3 row row-cols-2" >
                        <div class="col-6 row">
                            <label class="col-md-2 col-sm-2 col-form-label" for="language_id">ভাষার নাম</label>
                            <div class=" col-md-10 col-sm-10">
                                <select class="form-select" name="language_id" id="language_id" required>
                                    <option value="">ভাষার নাম</option>
                                    @foreach($languages as $language)
                                        <option value="{{$language->id}}">{{$language->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6 row">
                            <label class="col-md-2 col-form-label" for="language_id">অবস্থান</label>
                            <div class="col-md-10">
                                <select class="form-select" name="language_id" id="language_id" required>
                                    <option value=""> অবস্থান </option>
                                    @foreach($languages as $language)
                                    <option value="{{$language->id}}">{{$language->location}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 second_field_wrapper">
                            <div class="row mb-2">
                                <div class="card">
                                    <div class="card-header">নির্দেশিত</div>
                                    <div class="card-body">
                                        <div class="mb-3 row">
                                            <label class="col-md-2 col-sm-2 col-form-label" for="name">বিষয়</label>
                                            <div class=" col-md-8 col-sm-10">
                                                <input class="form-control" id="subject" name="subject" type="text" value="{{old('subject')}}" required>
                                            </div>
                                        </div>
                                        <div class="mb-3 row ">
                                            <div class="row mb-2">
                                                <label class="col-md-2 col-sm-2 col-form-label" for="mySentence"></label>
                                                <div class="col-md-8">
                                                    <input class="form-control remove-lan-value" id="mySentence" name="MySentence" value="" type="text" placeholder="বাক্য">
                                                </div>
                                                <div class="col-md-2 pt-1 px-0 add_button_first">
                                                    <a href="javascript:void(0);" class="btn btn-success btn-sm rounded-circle">
                                                        <svg class="icon text-white">
                                                            <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-plus')}}"></use>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row add-sentence-field">


                                        </div>
                                    </div>
                                    <div class="card-footer text-sm-center add_button_second">
                                        <a href="javascript:void(0);" class="btn btn-success btn-sm rounded-circle">
                                            <svg class="icon text-white">
                                                <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-plus')}}"></use>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card" style="">
                                <div class="card-header">স্বতঃস্ফূর্ত</div>
                                <div class="card-body">
                                    <div class="row field_wrapper mb-3">
                                        <div class="row mb-2">
                                            <div class="col-md-10">
                                                <input class="form-control remove-value" id="myWord" name="myWord" value="" type="text" placeholder="গৃহ ">
                                            </div>
                                            <div class="col-md-2 p-0 add_button">
                                                <a href="javascript:void(0);" class="btn btn-success btn-sm rounded-circle">
                                                    <svg class="icon text-white">
                                                        <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-plus')}}"></use>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row add-word-field">


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

@section('language-add-button-js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>

        /*add sentence */
        $(document).ready(function(){
            var maxField = 10; //Input fields increment limitation
            var addButton = $('.add_button_second'); //Add button selector
            var wrapper = $('.second_field_wrapper'); //Input field wrapper
            var fieldHTML = `<div class="card mb-2">
                                    <div class="card-header">নির্দেশিত</div>
                                    <div class="card-body">
                                        <div class="mb-3 row">
                                            <label class="col-md-2 col-sm-2 col-form-label" for="name">বিষয়</label>
                                            <div class=" col-md-8 col-sm-10">
                                                <input class="form-control" id="subject[]" name="subject[]" type="text">

                                            </div>
                                        </div>
                                        <div class="mb-3 row ">
                                            <div class="row mb-2">
                                                <label class="col-md-2 col-sm-2 col-form-label" for="mySentenceTwo"></label>
                                                <div class="col-md-8">
                                                    <input class="form-control remove-lan-value" id="mySentenceTwo" name="mySentenceTwo" value="" type="text" placeholder="বাক্য">
                                                </div>
                                                <div class="col-md-2 pt-1 px-0 add_button_third">
                                                    <a href="javascript:void(0);" class="btn btn-success btn-sm rounded-circle">
                                                        <svg class="icon text-white">
                                                            <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-plus')}}"></use>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row add-sentence-field-2">


                                        </div>
                                    </div>
                                    <div class="card-footer text-sm-center remove_button_second">
                                        <a href="javascript:void(0);" class="btn btn-success btn-sm rounded-circle">
                                            <svg class="icon text-white">
                                                <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-minus')}}"></use>
                                            </svg>
                                        </a>
                                    </div>
                                </div>`; //New input field html
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
            $(wrapper).on('click', '.remove_button_second', function(e){
                e.preventDefault();
                $(this).parent('div').remove(); //Remove field html
                x--; //Decrement field counter
            });
        });



// add language_directed add field
      /*  $(document).ready(function(){
            $(".add_button_third").click(function(){
                var sentence_second_v = $("#mySentenceTwo").val();
                $('.remove-lan-value').val('');
                $(".add-sentence-field-2").append(`<div class="col-md-6 ">
            <div class="alert alert-secondary alert-dismissible fade show rounded-2 p-1" role="alert">
                <input type="text" id="sentence[]" name="sentence[]" class="form-control" readonly value="${sentence_second_v}">
                    <button class="btn-close btn-sm p-0" type="button" data-coreui-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>`)

            });
        });*/
// add language_directed second add field
        $(document).ready(function(){
            $(".add_button_first").click(function(){
                var sentence_v = $("#mySentence").val();
                if (sentence_v === ""){
                    alert("Must be filled out");
                    return false;
                    // $("#mySentence").addClass('warning');
                }
                $('.remove-lan-value').val('');
                console.log(sentence_v);
                $(".add-sentence-field").append(`<div class="col-md-6 ">
            <div class="alert alert-secondary alert-dismissible fade show rounded-2 p-1" role="alert">
                <input type="text" id="sentence[]" name="sentence[]" class="form-control" readonly value="${sentence_v}">
                    <button class="btn-close btn-sm p-0" type="button" data-coreui-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>`)

            });
        });

// add language_spontaneous add field
        $(document).ready(function(){
            $(".add_button").click(function(){
                var word_v = $("#myWord").val();
                if (word_v === ""){
                    alert("Must be filled out");
                    return false;
                    // $("#mySentence").addClass('warning');
                }
                $('.remove-value').val('');
                $(".add-word-field").append(`<div class="col-md-3">
                                            <div class="alert alert-secondary alert-dismissible fade show rounded-2 p-1 mx-0" role="alert">
                                                <input type="text" id="word[]" name="word[]" class="form-control" readonly value="${word_v}">
                                                <button class="btn-close btn-sm p-0" type="button" data-coreui-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        </div>`)

            });
        });
    </script>
@endsection
