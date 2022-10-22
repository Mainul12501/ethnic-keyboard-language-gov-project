@extends('layouts.app')

@section('content')
    <div class="container-fluid pl-0 px-0">
        <div class="card mb-3">
            <div class="card-header">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.validator_task_assigns.index')}}">{{__('messages.টাস্ক অ্যাসাইন')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('messages.নতুন')}}</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                <form action="{{route('admin.validator_task_assigns.store')}}" method="post" >
                    @csrf
                    <input id="fcm_token" type="hidden" name="user_token" value="">
                    <div class="col-md-6 col-sm-12 row mb-3">


                    <div class="row mb-3">
                        <label class="col-md-2 col-sm-3 col-form-label" for="user_id">{{__('messages.যাচাইকারী')}} <span class="text-danger">*</span></label>
                        <div class="col-md-10 col-sm-9">
                            <select class="form-select @error('user_id') is-invalid @enderror"  id="user_id" name="user_id">
                                <option value="">{{__('messages.যাচাইকারী নির্বাচন করুন')}}</option>
                                @foreach($collectors as $key => $collector)
                                    <option value="{{$key}}">{{$collector}}</option>
                                @endforeach
                            </select>
                            @error('user_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-md-2 col-sm-3 col-form-label" for="language_id">{{__('messages.ভাষার নাম')}}<span class="text-danger">*</span></label>
                        <div class="col-md-10 col-sm-9">
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

                    {{-- <div class="row mb-3">
                        <label class="col-md-2 col-sm-3 col-form-label" for="village">{{__('messages.ঠিকানা')}}</label>
                        <div class="col-md-10 col-sm-9">
                            <textarea class="form-control @error('village') is-invalid @enderror" id="village" placeholder="{{__('messages.ঠিকানা')}}" type="text" name="village"></textarea>
                            @error('village')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-md-2 col-sm-3 col-form-label" for="district">{{__('messages.জেলা')}}</label>
                        <div class="col-md-10 col-sm-9">
                            <select class="form-select" id="district_id"  name="district">
                                <option value="">{{__('messages.জেলা নির্বাচন করুন')}}</option>
                                @foreach($districts as $key => $district)
                                    <option value="{{$key}}">{{$district}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-md-2 col-sm-3 col-form-label" for="upazila">{{__('messages.উপজেলা')}}</label>
                        <div class="col-md-10 col-sm-9">
                            <select class="form-select @error('upazila') is-invalid @enderror" id="upazila" name="upazila">
                            </select>

                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-md-2 col-sm-3 col-form-label" for="union">{{__('messages.ইউনিয়ন')}}</label>
                        <div class="col-md-10 col-sm-9">
                            <select class="form-select @error('union') is-invalid @enderror" id="union" name="union">
                            </select>
                        </div>
                    </div> --}}


                    <div class="row">
                        <div class="col-12 text-end">
                            <button class="btn btn-success text-white" type="submit">{{__('messages.জমা দিন')}}</button>
                        </div>
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

            // select upazila
            $('select[name="district"]').on('change', function() {
                var districtID = $(this).val();
                console.log(districtID);
                if(districtID) {
                    $.ajax({
                        url:"{{url('admin/getValidatorUpazila')}}?district_id="+districtID,
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

                }
            });


        });

        $('#user_id').select2({
            width: '100%',
            placeholder: "{{__('messages.যাচাইকারী নির্বাচন করুন')}}",
            allowClear: true
        });

        $('#language_id').select2({
            width: '100%',
            placeholder: "{{__('messages.ভাষা নির্বাচন করুন')}}",
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
