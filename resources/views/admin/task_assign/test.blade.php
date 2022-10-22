@extends('layouts.app')

@section('content')
    <div class="container-fluid pl-0 px-0">
        <div class="card mb-3">
            <div class="card-header">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.task_assigns.index')}}">{{__('messages.টাস্ক অ্যাসাইন')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('messages.নতুন')}}</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                <form action="{{route('admin.single_task_assigns.store')}}" method="post" >
                    @csrf
                <div class="row">
                    <input id="fcm_token" type="hidden" name="user_token" value="">
                    <div class="col-md-6 col-sm-12">
                        <div class="row mb-3">
                            <label for="group_id">{{__('messages.গ্রুপ নির্বাচন করুন')}}<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <select class="form-select @error('group_id') is-invalid @enderror"  id="group_id" name="group_id">
                                    <option value="">{{__('messages.গ্রুপ নির্বাচন করুন')}}</option>
                                    @foreach($groups as $key => $group)
                                        <option value="{{$key}}" {{ (old("group_id") == $key ? "selected":"") }}>{{$group}}</option>
                                    @endforeach
                                </select>
                                @error('group_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label  for="district">{{__('messages.জেলা')}} <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <select class="form-select @error('district') is-invalid @enderror" id="district"  name="district">
                                    {{--<option value="">জেলা নির্বাচন করুন</option>
                                    @foreach($districts as $key => $district)
                                        <option value="{{$key}}">{{$district}}</option>
                                    @endforeach--}}
                                </select>
                                @error('district')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label  for="upazila">{{__('messages.উপজেলা')}}<span class="text-danger"></span></label>
                            <div class="input-group">
                                <select class="form-select @error('upazila') is-invalid @enderror" id="upazila" name="upazila">

                                </select>
                                @error('upazila')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label  for="union">{{__('messages.ইউনিয়ন')}} <span class="text-danger"></span></label>
                            <div class="input-group">
                                <select class="form-select @error('union') is-invalid @enderror" id="union" name="union">
                                </select>
                                @error('union')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label  for="village">{{__('messages.গ্রাম')}} <span class="text-danger"></span></label>
                            <div class="input-group">
                                <input class="form-control @error('village') is-invalid @enderror" id="village" placeholder="{{__('messages.গ্রাম')}}" type="text" name="village">
                                @error('village')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label  for="total_sample">{{__('messages.মোট নমুনা')}} <span class="text-danger"></span></label>
                            <div class="input-group">
                                <input class="form-control @error('village') is-invalid @enderror" id="village" placeholder="{{__('messages.মোট নমুনা')}}" type="text" name="village">
                                @error('village')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="row mb-3">
                            <label  for="language_id">{{__('messages.ভাষার নাম')}}  <span class="text-danger">*</span></label>
                            <div class=" input-group">
                                <select class="form-select  @error('language_id') is-invalid @enderror"  id="language_id" name="language_id">
                                    <option value="">{{__('messages.ভাষা নির্বাচন করুন')}}</option>
                                    @foreach($languages as $key => $value)
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select>
                                @error('language_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label  for="sub_language_id">{{__('messages.উপভাষা')}} <span class="text-danger"></span></label>
                            <div class="input-group">
                                <select class="form-select @error('sub_language_id') is-invalid @enderror" id="sub_language_id"  name="sub_language_id">

                                </select>
                                @error('sub_language_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label  for="total_time">{{__('মোট সময় (মিনিট)')}} <span class="text-danger">*</span></label>
                            <div class=" input-group">
                                <input class="form-control @error('total_time') is-invalid @enderror" name="total_time" id="total_time" type="number" placeholder="{{__('মোট সময় (মিনিট)')}}" value="{{old('total_time')}}">
                                @error('total_time')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label  for="start_date">{{__('messages.শুরুর তারিখ')}}<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input class="form-control @error('start_date') is-invalid @enderror" id="start_date" type="date" name="start_date">
                                @error('start_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label  for="end_date">{{__('messages.শেষ তারিখ')}} <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input class="form-control @error('end_date') is-invalid @enderror" id="end_date" type="date"  name="end_date">
                                @error('end_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="field_wrapper">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-end">
                            <button class="btn btn-success text-white" type="submit">{{__('messages.জমা দিন')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('group-task-assgin-js')
    <script src="https://www.gstatic.com/firebasejs/7.23.0/firebase.js"></script>
    <script type="text/javascript">


        $(document).ready(function() {

            $(function () {
                groupCollector(); //this calls it on load
                $('select[name="group_id"]').change(groupCollector);
            });

            function groupCollector() {
                var groupID = $('select[name="group_id"]').val();
                // console.log(groupID);
                if(groupID) {
                    $.ajax({
                        url:"{{url('admin/getGroupByCollector')}}?group_id="+groupID,
                        type: "GET",
                        dataType: "json",
                        success:function(data) {
                            $('.field_wrapper').empty()
                            $.each(data, function(key, value) {
                                $('.field_wrapper').append('<div class="row mb-3"  id="topicSelect'+key+'">'+
                                    '<div class="col-md-2 col-sm-2">'+
                                    '<input type="hidden" name="user_id[]" id="user_id" value="'+key+'">'+
                                    '<label class=" col-form-label" for="user_id">'+value+'</label>'+
                                    '</div>'+
                                    '<div class="col-md-5 col-sm-5">'+
                                    '<div class=" input-group" >'+
                                    '<div class="form-check form-check-inline" style="width: 14rem;">'+
                                    '<input class="form-check-input" name="directed'+key+'" id="directed'+key+'" type="checkbox" onclick="checkAll(document.getElementsByClassName(\'directed'+key+'\'),this)">'+
                                    '<label class="form-check-label" for="directed">{{__('messages.নির্দেশিত')}}</label>'+
                                    '</div>'+
                                    '</div>'+
                                    '<div class=" input-group directed directed'+key+'" id="topic_id'+key+'" data-id="topic_id'+key+'">'+
                                    '</div>'+
                                    '</div>'+
                                    '<div class="col-md-5 col-sm-5">'+
                                    '<div class=" input-group" >'+
                                    '<div class="form-check form-check-inline" style="width: 14rem;">'+
                                    '<input class="form-check-input" name="spontaneous'+key+'" id="spontaneous'+key+'" type="checkbox" onclick="checkAll(document.getElementsByClassName(\'spontaneous'+key+'\'),this)">'+
                                    '<label class="form-check-label" for="spontaneous">{{__('messages.স্বতঃস্ফূর্ত')}}</label>'+
                                    '</div>'+
                                    '</div>'+
                                    '<div class=" input-group spontaneous spontaneous'+key+'" id="spontaneous_id'+key+'"'+
                                    '</div>'+
                                    '</div>'+
                                    '</div>');
                            });
                        }
                    });
                }else{
                    $('.field_wrapper').empty()
                }
            }

            // select directed
            $('select[name="language_id"]').on('change', function() {
                var languageID = $(this).val();
                var groupID = $('select[name="group_id"]').val();
                console.log(groupID);
                if(languageID) {
                    $.ajax({
                        url:"{{url('admin/getDirectedTopic')}}?language_id="+languageID+"&group_id="+groupID,
                        type: "GET",
                        dataType: "json",
                        success:function(data) {
                            $('.directed').empty()
                            $.each(data, function(key , value) {
                                $('.directed').append('<div class="form-check form-check-inline" style="width: 7rem;">'+
                                    '<input class="form-check-input" name="topic_id[]" type="checkbox" value="'+key+'">'+
                                    '<label class="form-check-label" for="topic_id"><small>'+ value +'</small></label>'+
                                    '</div>');
                            });
                        }
                    });
                }else{
                    $('.directed').empty()
                }
            });

            // select spontaneous
            $('select[name="language_id"]').on('change', function() {
                var languageID = $(this).val();
                // console.log(languageID);
                if(languageID) {
                    $.ajax({
                        url:"{{url('admin/getSpontaneous')}}?language_id="+languageID,
                        type: "GET",
                        dataType: "json",
                        success:function(data) {
                            $('.spontaneous').empty()
                            $.each(data, function(key, value) {
                                $('.spontaneous').append('<div class="form-check form-check-inline" style="width: 7rem;">'+
                                    '<input class="form-check-input" name="spontaneous_id[]" type="checkbox" value="'+key+'">'+
                                    '<label class="form-check-label" for="spontaneous_id"><small>'+value+'</small></label>'+
                                    '</div>');
                            });
                        }
                    });
                }else{
                    $('.spontaneous').empty()

                }
            });


            // select SubLanguage
            $('select[name="language_id"]').on('change', function() {
                var languageID = $(this).val();
                // console.log(languageID);
                if(languageID) {
                    $.ajax({
                        url:"{{url('admin/getSubLanguage')}}?language_id="+languageID,
                        type: "GET",
                        dataType: "json",
                        success:function(data) {
                            // console.log(data);
                            $('select[name="sub_language_id"]').empty();
                            $('#sub_language_id').append('<option value="">{{__('messages.উপভাষা নির্বাচন করুন')}}</option>');
                            $.each(data, function(key, value) {
                                $('select[name="sub_language_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                            });
                        }
                    });
                }else{
                    $('select[name="sub_language_id"]').empty()

                }
            });

           /* $(document).on('click', '.form-check-input', function(){
                var userID =$('.directed').closest().prop('id');
                console.log(userID);
            });
*/

            // select directed
            $('select[name="language_id"]').on('change', function() {
                var languageID = $(this).val();
                var groupID = $('select[name="group_id"]').val();
                if(languageID) {
                    $.ajax({
                        url:"{{url('admin/getTaskUser')}}?group_id="+groupID,
                        type: "GET",
                        dataType: "json",
                        success:function(data) {
                            $.each(data, function(key , value) {
                                $("#topic_id"+key+" input").each(function() {
                                    if($(this).prop("name") == "topic_id[]") $(this).prop("name", "topic_id"+key+"[]");
                                });
                                $("#spontaneous_id"+key+" input").each(function() {
                                    if($(this).prop("name") == "spontaneous_id[]") $(this).prop("name", "spontaneous_id"+key+"[]");
                                });
                            });
                        }
                    });
                }
            });

            // select Districts
            $('select[name="language_id"]').on('change', function() {
                var languageID = $(this).val();
                // console.log(languageID);
                if(languageID) {
                    $.ajax({
                        url:"{{url('admin/getDistrict')}}?language_id="+languageID,
                        type: "GET",
                        dataType: "json",
                        success:function(data) {
                            $('select[name="district"]').empty();
                            $('select[name="upazila"]').empty()
                            $('select[name="union"]').empty();
                            $('select[name="village"]').empty();
                            $('#district').append('<option value="">{{__('messages.জেলা নির্বাচন করুন')}}</option>');
                            $.each(data, function(key, value) {
                                $('select[name="district"]').append('<option value="'+ key +'">'+ value +'</option>');
                            });
                        }
                    });
                }else{
                    $('select[name="district"]').empty()
                    $('select[name="upazila"]').empty()
                    $('select[name="union"]').empty();
                    $('select[name="village"]').empty();
                }
            });
            // select upazila
            $('select[name="district"]').on('change', function() {
                var districtID = $(this).val();
                console.log(districtID);
                if(districtID) {
                    $.ajax({
                        url:"{{url('admin/getUpazila')}}?district_id="+districtID,
                        type: "GET",
                        dataType: "json",
                        success:function(data) {
                            $('select[name="upazila"]').empty();
                            $('#upazila').append('<option value="">{{__('messages.উপজেলা নির্বাচন করুন')}}</option>');
                            $.each(data, function(key, value) {
                                $('select[name="upazila"]').append('<option value="'+ key +'">'+ value +'</option>');
                            });
                        }
                    });
                }else{
                    $('select[name="upazila"]').empty()
                    $('select[name="union"]').empty();
                    $('select[name="village"]').empty();
                }
            });

            // select Union
            $('select[name="upazila"]').on('change', function() {
                var upazilaID = $(this).val();
                console.log(upazilaID);
                if(upazilaID) {
                    $.ajax({
                        url: "{{url('admin/getUnion')}}?upazila_id="+upazilaID,
                        type: "GET",
                        dataType: "json",
                        success:function(data) {
                            $('select[name="union"]').empty();
                            $('#union').append('<option value="">{{__('messages.ইউনিয়ন নির্বাচন করুন')}}</option>');
                            $.each(data, function(key, value) {
                                $('select[name="union"]').append('<option value="'+ key +'">'+ value +'</option>');
                            });
                        }
                    });
                }else{
                    $('select[name="union"]').empty();
                    $('select[name="village"]').empty();
                }
            });

        });



        // checkbox
        function checkAll(cname, bx) {
            console.log(cname)
            for (var tbls = cname,i=tbls.length; i--; )
                for (var bxs=tbls[i].getElementsByTagName("input"),j=bxs.length; j--; )
                    if (bxs[j].type=="checkbox")
                        bxs[j].checked = bx.checked;
        }


        $('#group_id').select2({
            // width: '100%',
            placeholder: "{{__('messages.গ্রুপ নির্বাচন করুন')}}",
            // allowClear: true
        });

        $('#language_id').select2({
            width: '100%',
            placeholder: "{{__('messages.ভাষা নির্বাচন করুন')}}",
            allowClear: true
        });

        $('#sub_language_id').select2({
            width: '100%',
            placeholder: "{{__('messages.উপভাষা নির্বাচন করুন')}}",
            allowClear: true
        });

        $('#district').select2({
            width: '100%',
            placeholder: "{{__('messages.জেলা নির্বাচন করুন')}}",
            allowClear: true
        });
        $('#upazila').select2({
            width: '100%',
            placeholder: "{{__('messages.উপজেলা নির্বাচন করুন')}}",
            allowClear: true
        });
        $('#union').select2({
            width: '100%',
            placeholder: "{{__('messages.ইউনিয়ন নির্বাচন করুন')}}",
            allowClear: true
        });


    </script>
    <script>
        // Firebase Config

        window.onload = function() {
            initFirebaseMessagingRegistration();
        };

        var firebaseConfig = {
            apiKey: "AIzaSyAf8VbB9KukpAFQc-PS1djtgnibSqjvtQ4",
            authDomain: "push-notification-1cd0f.firebaseapp.com",
            projectId: "push-notification-1cd0f",
            storageBucket: "push-notification-1cd0f.appspot.com",
            messagingSenderId: "1027263277408",
            appId: "1:1027263277408:web:d92c18d701a17a4505d605",
            measurementId: "G-9Q38M0HCYE"
        };

        firebase.initializeApp(firebaseConfig);
        const messaging = firebase.messaging();

        function initFirebaseMessagingRegistration() {
            messaging
                .requestPermission()
                .then(function () {
                    return messaging.getToken()

                })
                .then(function(token) {

                    console.log(token);
                    $('#fcm_token').val(token);
                })
                .catch(function (err) {
                    console.log('User Chat Token Error'+ err);
                });
        }

        messaging.onMessage(function(payload) {
            const noteTitle = payload.notification.title;
            const noteOptions = {
                body: payload.notification.body,
                icon: payload.notification.icon,
            };
            new Notification(noteTitle, noteOptions);
        });

    </script>
@endsection
