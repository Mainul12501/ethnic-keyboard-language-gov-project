@extends('layouts.app')

@section('front-css')
<link rel="stylesheet" href="{{ asset('assets/recorder/recorder.css') }}">


@endsection


@section('content')
    <div class="container-fluid pl-0 px-0">
        <div class="card mb-3">
            <div class="card-header">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">{{__('messages.তথ্য সংগ্রহ')}}</a></li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                <form action="{{route('admin.data_collections.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-5 col-sm-12">
                            <div class="row mb-3">
                                <label  for="language_id">{{__('messages.ভাষার নাম')}} <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <select class="form-select  @error('language_id') is-invalid @enderror"  id="language_id" name="language_id" required>
                                        <option value="">{{__('messages.ভাষা নির্বাচন করুন')}}</option>
                                        @if($languages != 'blank')
                                            @foreach($languages as $key => $language)
                                                <option value="{{ $language->language_id }}" data-district-id="{{ $language->district->id }}">{{ $language->language->name }} ({{ $language->district->name }})</option>
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
                                <label  for="type_id">{{__('messages.টাইপ')}} <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <select class="form-select  @error('type_id') is-invalid @enderror"  id="type_id" name="type_id" required>
                                        <option value="">{{__('messages.টাইপ নির্বাচন করুন')}}</option>
                                        <option value="directeds" >{{__('messages.নির্দেশিত')}} </option>
                                        <option value="spontaneouses">{{__('messages.স্বতঃস্ফূর্ত')}}   </option>
                                    </select>
                                    @error('type_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3 xx">
                                <ul class="list-group " id="printTypeContents">

                                </ul>
                            </div>
                        </div>
                        <div class="col-md-7 col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row mb-3">
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="exist-speaker-tab" data-coreui-toggle="tab" data-coreui-target="#exists-speaker" type="button" role="tab" aria-controls="exists-speaker" aria-selected="true">{{__('messages.স্পিকার তালিকা')}}</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="new-speaker-tab" data-coreui-toggle="tab" data-coreui-target="#new-speaker" type="button" role="tab" aria-controls="new-speaker" aria-selected="false">{{__('messages.নতুন স্পিকার')}}</button>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="myTabContent">
                                            <div class="tab-pane fade show active " id="exists-speaker" role="tabpanel" aria-labelledby="exist-speaker-tab">
                                                <div class="row mb-3 mt-3">
                                                    <label  for="speaker_id">{{__('messages.স্পিকার')}} <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <select class="form-select  @error('speaker_id') is-invalid @enderror"  id="speaker_id" name="speaker_id" >
                                                            <option value="">{{__('messages.স্পিকার নির্বাচন করুন')}}</option>
                                                            @foreach($speakers as $speaker)
                                                                <option value="{{ $speaker->id }}">{{ $speaker->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('speaker_id')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="new-speaker" role="tabpanel" aria-labelledby="new-speaker-tab">
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-12 mt-3">
                                                        <div class="row mb-3">
                                                            <div class=" col-md-12 col-sm-12">
                                                                <input class="form-control @error('name') is-invalid @enderror" name="name" id="name" type="text" value="{{old('name')}}" placeholder="{{__('messages.নাম')}} *" >
                                                                @error('name')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class=" col-md-12 col-sm-12">
                                                                <input class="form-control @error('age') is-invalid @enderror" name="age" id="age" type="number" value="{{old('age')}}" placeholder="{{__('messages.বয়স')}} *" >
                                                                @error('age')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class=" col-md-12 col-sm-12">
                                                                <input class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{old('email')}}" type="email" placeholder="{{__('messages.ইমেইল')}}" >
                                                                @error('email')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class=" col-md-12 col-sm-12">
                                                                <select class="form-select @error('district') is-invalid @enderror" id="district"  name="district">
                                                                    <option value="">{{__('messages.জেলা নির্বাচন করুন')}} *</option>
                                                                    @foreach($districts as $key => $district)
                                                                        <option value="{{$key}}">{{$district}}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('district')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class=" col-md-12 col-sm-12">
                                                                <select class="form-select @error('upazila_id') is-invalid @enderror" id="upazila_id" name="upazila_id">

                                                                </select>
                                                                @error('upazila_id')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class=" col-md-12 col-sm-12">
                                                                <select class="form-select @error('union_id') is-invalid @enderror" id="union_id" name="union_id">

                                                                </select>
                                                                @error('union_id')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        {{--<div class="row mb-3">
                                                            <div class=" col-md-12 col-sm-12">
                                                                <select class="form-select @error('village_id') is-invalid @enderror" id="village_id" name="village_id">

                                                                </select>
                                                                @error('village_id')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                        </div>--}}
                                                        <div class="row mb-3">
                                                            <div class=" col-md-12 col-sm-12">
                                                                <input class="form-control @error('area') is-invalid @enderror" name="area" id="area" type="text" value="{{old('area')}}" placeholder="{{__('messages.গ্রাম/পাড়া/মহল্লা')}}" >
                                                                @error('area')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                        </div>


                                                    </div>
                                                    <div class="col-md-6 col-sm-12 mt-3">
                                                        <div class="row mb-3">
                                                            <div class=" col-md-12 col-sm-12">
                                                                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" id="image" accept="image/*" >
                                                                @error('image')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <div class=" col-md-12 col-sm-12">
                                                                <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
                                                                    <option value="">{{__('messages.লিঙ্গ নির্বাচন করুন')}} *</option>
                                                                    <option value="0">{{__('messages.পুরুষ')}}</option>
                                                                    <option value="1">{{__('messages.মহিলা')}}</option>
                                                                    <option value="2">{{__('messages.অন্যান্য')}}</option>
                                                                </select>
                                                                @error('gender')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class=" col-md-12 col-sm-12">
                                                                <input class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" type="number" value="{{old('phone')}}" placeholder="{{__('messages.মোবাইল')}} *">
                                                                @error('phone')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class=" col-md-12 col-sm-12">
                                                                <input class="form-control @error('occupation') is-invalid @enderror" name="occupation" id="occupation" type="text" value="{{old('occupation')}}" placeholder="{{__('messages.পেশা')}} *" >
                                                                @error('occupation')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class=" col-md-12 col-sm-12">
                                                                <input class="form-control @error('education') is-invalid @enderror" name="education" id="education" type="text" value="{{old('education')}}" placeholder="{{__('messages.সর্বোচ্চ শিক্ষা')}}" >
                                                                @error('education')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class=" col-md-12 col-sm-12">
                                                                <textarea class="form-control @error('address') is-invalid @enderror" name="address" id="address" cols="30" rows="3" placeholder="{{__('messages.ঠিকানা')}}"></textarea>
                                                                @error('address')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
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
                                <div class="card-body right-card-div">
                                    <div class="row show-me rrr">
                                        <div class="col-md-12 col-lg-6">
                                            <div class="row mb-3 xx">
                                                <ul class="list-group" id="printTypeSubContents">

                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-lg-6 d-none" id="spoColDiv">
                                            <div class="audio-box" >
                                                <div class="">
                                                    <input type="hidden" name="type" id="languageType">
                                                    <input type="hidden" name="target_id" id="targetId">
                                                    <input type="hidden" name="task_assign_id" id="taskAssignId">
                                                    <input type="hidden" name="district_id" id="districtId">
                                                    <div class="d-none dirUpDiv">
                                                        <div id="dirAudioStatus" class="vvv text-center">

                                                        </div>
                                                        <div class="mt-2 audio-div">
                                                            <div id="player1"></div>

                                                        </div>
                                                    </div>
                                                    <div class="d-none">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row hide-me d-none xyz">
                                        <div class="col-md-8 offset-2">
                                            <div class ="text-center">
                                                <div id="spoAudioStatus">

                                                </div>

                                                <div class="mt-3 audio-div">
                                                    <div id="player"></div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="text-center">
                                                <div class="record-box">
                                                    <div id="upload-audio">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                     <!-- Recording Ui -->
                                     <div class="recorder">
                                        <div class="d-flex">
                                            <div class="holder">
                                                <div data-role="controls">
                                                    <div class="record">Record</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div data-role="recordings"></div>
                                    </div>
                                    <!-- End Recording Ui -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mt-3 text-end">
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
        var baseUrl = {!! json_encode(url('/')) !!}+ '/';
        $(document).on('change','#type_id', function () {
            var typeValue = $(this).val();
            var languageId = $('#language_id').val();
            var district_id = $('#language_id option:selected').attr('data-district-id');
            $('.right-card-div').addClass('d-none');
            $('input[class="cc"]').val('');
            $.ajax({
                url: baseUrl+'get-type-content',
                // url: 'http://127.0.0.1:8000/get-type-content',
                dataType: "JSON",
                method: "POST",
                data: {type_value: typeValue,language_id:languageId,district_id:district_id},
                success: function (data)
                {
                    console.log(data);
                    if (data.type == 'directeds')
                    {
                        if (data.typeContent != 'blank')
                        {
                            var li = '';
                            $.each(data.typeContent, function (key, value){
                                li += '<li class="list-group-item get-type-sub" data-type="'+data.type+'" data-id="'+value.topic.id+'" district-id="'+data.districtID+'" task-assign-id="'+value.task_assign_id +'">'+value.topic.name+'</li>';
                            })
                            $('#printTypeContents').empty().append(li);
                        }
                    } else if (data.type == 'spontaneouses')
                    {
                        if (data.typeContent != 'blank')
                        {
                            checkSponInDC(data);
                        }

                    }
                }
            })
        })
        function checkSponInDC(data)
        {
            var ul = '';
            $.each(data.typeContent, function (key, value) {
                ul += '<li class="list-group-item spon" data-type="'+data.type+'" data-id="'+value.spontaneous_id +'" district-id="'+data.districtID+'" task-assign-id="'+value.task_assign_id +'">'+value.spontaneous.word+'<span style="float: right; font-size: 12px!important; color: #04672d"><i class="fa-regular fa-check"></i></span></li>';
                $.ajax({
                    url: baseUrl+'check-spon-in-dc',
                    dataType: "JSON",
                    method: "POST",
                    data: {id: value.spontaneous_id},
                    success: function (res)
                    {
                        // ul += '<li class="list-group-item spon" data-type="'+data.type+'" data-id="'+value.spontaneous_id +'">'+value.spontaneous.word+'<span style="float: right; font-size: 12px!important; color: greenyellow"><i class="fa-regular fa-check"></i></span></li>';
                        if (res == 1)
                        {
                            ul += '<li class="list-group-item spon" data-type="'+data.type+'" data-id="'+value.spontaneous_id +'" district-id="'+data.districtID+'" task-assign-id="'+value.task_assign_id +'">'+value.spontaneous.word+'<span style="float: right; font-size: 12px!important; /*color: #04672d*/"><i class="fa-solid fa-check-double"></i></span></li>';
                        }else if(res == 0) {
                            ul += '<li class="list-group-item spon" data-type="'+data.type+'" data-id="'+value.spontaneous_id +'" district-id="'+data.districtID+'" task-assign-id="'+value.task_assign_id +'">'+value.spontaneous.word+'<span style="float: right; font-size: 12px!important; /*color: #adff2f*/"><i class="fas fa-upload"></i></span></li>';
                        }
                    }
                });

            })
            $('#printTypeContents').empty().append(ul);
        }
        $(document).on('click','.get-type-sub', function (){
            var type = $(this).attr('data-type');
            var topic_id = $(this).attr('data-id');
            var task_assign_id = $(this).attr('task-assign-id');
            var district_id = $(this).attr('district-id');
            $('.right-card-div').removeClass('d-none');
            $('.rrr').removeClass('d-none');
            $('.xyz').addClass('d-none');
            $('.get-type-sub').each(function () {
                $(this).removeClass('active');
            })
            $(this).addClass('active');
            $.ajax({
                url: baseUrl+'get-type-sub-content',
                // url: 'http://127.0.0.1:8000/get-type-content',
                dataType: "JSON",
                method: "POST",
                data: {type: type,topic_id:topic_id, task_assign_id:task_assign_id, district_id:district_id},
                success: function (data)
                {
                    console.log(data);
                    if (data.type == 'directeds')
                    {
                        var li = '';
                        $.each(data.contents, function (key, value){
                            if (value.dc_sentence != null)
                            {
                                li += '<li class="list-group-item dirSea" data-id="'+value.id+'" data-type="'+data.type+'" topic-id ="'+data.topicId+'" district-id="'+data.districtID+'" task-assign-id="'+data.taskAssignId+'">'+value.sentence+'<span style="float: right; font-size: 12px!important; /*color: #04672d*/"><i class="fa-regular fa-check-double"></i></span></li>';
                            } else {
                                li += '<li class="list-group-item dirSea" data-id="'+value.id+'" data-type="'+data.type+'" topic-id ="'+data.topicId+'" district-id="'+data.districtID+'" task-assign-id="'+data.taskAssignId+'">'+value.sentence+'<span style="float: right; font-size: 12px!important; /*color: #04672d*/"><i class="fas fa-upload"></i></span></li>';
                            }
                        })
                        $('#printTypeSubContents').empty().html(li);
                    }

                }
            })
            $('#spoColDiv').removeClass('d-none');
        })

        $(document).on('click','.dirSea', function (){
            $(".dirUpDiv").removeClass('d-none');
            var type = $(this).attr('data-type');
            var dir_id = $(this).attr('data-id');
            var topic_id = $(this).attr('topic-id');
            var task_assign_id = $(this).attr('task-assign-id');
            var district_id = $(this).attr('district-id');
            var languageId = $('#language_id').val();
            $('.dirSea').each(function () {
                $(this).removeClass('active');
            })
            $(this).addClass('active');
            // write ajax code here to get audio file
            $("#languageType").val(type);
            $("input[name='target_id']").val(dir_id);
            $("input[name='task_assign_id']").val(task_assign_id);
            $("input[name='district_id']").val(district_id);
            $.ajax({
                url: baseUrl+'check-spo-audio-status',
                method: "POST",
                dataType: "JSON",
                data: {type:type,dir_id:dir_id, topic_id:topic_id, task_assign_id:task_assign_id, district_id:district_id, language_id:languageId},
                success: function (data) {
                    console.log(data);
                    if(data.status == 1)
                    {
                        $('#dirAudioStatus').addClass('d-none');
                        // child chck

                        $('.audio-div').removeClass('d-none');

                        $('#player1').jsRapAudio({
                            src: baseUrl+data.audio.audio,
                            autoplay:false,
                            controls:true,
                            capHeight:4,
                            capSpeed:0.6,
                            frequency:0.7,
                        });

                    } else {
                        $('.audio-div').addClass('d-none');
                        $('#dirAudioStatus').removeClass('d-none');

                        if (!$('#dirAudioStatus').children().length > 0)
                        {
                            var label = '';
                            label += '<div class="audio-input-div" id="lol'+dir_id+'" data-dir-id="'+dir_id+'">';
                            label += '<label for="audio-upload'+dir_id+'">';
                            label += '<span class="btn btn-success btn-lg text-white d-inline-flex" data-toggle="tooltip" data-placement="top" title="Only audio">';
                            label += '<i class="fa fa-upload"></i>';
                            label += '</span></label>';
                            // label += '<br>({{__('messages.Please upload only .mp3 file')}})';
                            label += '<input type="file" class="cc" name="audio['+dir_id+']" accept="audio/*" id="audio-upload'+dir_id+'" style="display:none" />';
                            label += '</div>';
                            $('#dirAudioStatus').append(label);
                             // Record Start Button
                             var upload = '';
                            upload += '<div class="upload-record">'
                            upload += '<div class="recorder-show btn btn-lg btn-success text-white" onclick="initRecorder()"><i class="fa-solid fa-microphone"></i></div>'
                            upload += '</div>'
                            $('#dirAudioStatus').append(upload);
                            // console.log('sdf');
                        } else {
                            if(!$('#lol'+dir_id).children().length > 0)
                            {
                                var div = '';
                                div += '<div class="audio-input-div" id="lol'+dir_id+'" data-dir-id="'+dir_id+'">';
                                div += '<label for="audio-upload'+dir_id+'">';
                                div += '<span class="btn btn-success btn-lg text-white d-inline-flex" data-toggle="tooltip" data-placement="top" title="Only audio">';
                                div += '<i class="fa fa-upload"></i>';
                                div += '</span></label>';
                                // div += '<br>({{__('messages.Please upload only .mp3 file')}})';
                                div += '<input type="file" class="cc" name="audio['+dir_id+']" accept="audio/*" id="audio-upload'+dir_id+'" style="display:none" />';
                                div += '</div>';
                                $('#dirAudioStatus').append(div);
                               // Record Start Button
                               var upload = '';
                                upload += '<div class="upload-record">'
                                upload += '<div class="recorder-show btn btn-lg btn-success text-white" onclick="initRecorder()"><i class="fa-solid fa-microphone"></i></div>'
                                upload += '</div>'
                                $('#dirAudioStatus').append(upload);
                            }
                            $('.audio-input-div').css('display','none');
                            $('#lol'+dir_id).css('display', 'block');
                        }

                    }
                }
            })
        })

        // <======= let it check ======>
        $(document).on('click', '.spon', function (){
            var type = $(this).attr('data-type');
            var dir_id = $(this).attr('data-id');
            var task_assign_id = $(this).attr('task-assign-id');
            var district_id = $(this).attr('district-id');
            var languageId = $('#language_id').val();
            $('.right-card-div').removeClass('d-none');
            $('.show-me').addClass('d-none');
            $('.hide-me').removeClass('d-none');
            $("#languageType").val(type);
            $("input[name='target_id']").val(dir_id);
            $("input[name='task_assign_id']").val(task_assign_id);
            $("input[name='district_id']").val(district_id);
            $('.spon').each(function () {
                $(this).removeClass('active');
            })
            $(this).addClass('active');
            $.ajax({
                url: baseUrl+'check-spo-audio-status',
                method: "POST",
                dataType: "JSON",
                data: {type:type,dir_id:dir_id, task_assign_id:task_assign_id, district_id:district_id, language_id:languageId },
                success: function (data) {
                    console.log(data);
                    // console.log(data.audio);
                    if(data.status == 1)
                    {
                        $('#spoAudioStatus').addClass('d-none');
                        $('.audio-div').removeClass('d-none');
                        $('#player').jsRapAudio({
                            src: baseUrl+data.audio.audio,
                            autoplay:false,
                            controls:true,
                            capHeight:4,
                            capSpeed:0.6,
                            frequency:0.7,
                        })
                    }else {
                        $('.audio-div').addClass('d-none');
                        $('#spoAudioStatus').removeClass('d-none');


                        if (!$('#spoAudioStatus').children().length > 0)
                        {
                            var label = '';
                            label += '<div class="audio-input-div" id="spon'+dir_id+'" data-dir-id="'+dir_id+'">';
                            label += '<label for="audio-upload'+dir_id+'">';
                            label += '<span class="btn btn-success btn-lg text-white d-inline-flex" data-toggle="tooltip" data-placement="top" title="Only audio">';
                            label += '<i class="fa fa-upload"></i>';
                            label += '</span></label>';
                            // label += '<br>({{__('messages.Please upload only .mp3 file')}})';
                            label += '<input type="file" class="cc" name="audio['+dir_id+']" accept="audio/*" id="audio-upload'+dir_id+'" style="display:none" />';
                            label += '</div>';
                            $('#spoAudioStatus').append(label);
                            // console.log('sdf');
                             // Record Start Button
                             var upload = '';
                            upload += '<div class="upload-record">'
                            upload += '<div class="recorder-show btn btn-lg btn-success text-white" onclick="initRecorder()"><i class="fa-solid fa-microphone"></i></div>'
                            upload += '</div>'
                            $('#upload-audio').append(upload);
                        } else {
                            if(!$('#spon'+dir_id).children().length > 0)
                            {
                                var div = '';
                                div += '<div class="audio-input-div" id="spon'+dir_id+'" data-dir-id="'+dir_id+'">';
                                div += '<label for="audio-upload'+dir_id+'">';
                                div += '<span class="btn btn-success btn-lg text-white d-inline-flex" data-toggle="tooltip" data-placement="top" title="Only audio">';
                                div += '<i class="fa fa-upload"></i>';
                                div += '</span></label>';
                                // div += '<br>({{__('messages.Please upload only .mp3 file')}})';
                                div += '<input type="file" class="cc" name="audio['+dir_id+']" accept="audio/*" id="audio-upload'+dir_id+'" style="display:none"/>';
                                div += '</div>';
                                $('#spoAudioStatus').append(div);
                                //  Record Start Button
                                 var upload = '';
                                upload += '<div class="upload-record">'
                                upload += '<button class="recorder-show btn btn-lg btn-success  text-white"><i class="fa-solid fa-microphone"></i></button>'
                                upload += '</div>'
                                $('#upload-audio').append(upload);
                            }
                            $('.audio-input-div').css('display','none');
                            $('#spon'+dir_id).css('display', 'block');
                        }

                    }
                }
            })
        })

        $(document).on('click','#dirAc', function (){
            event.preventDefault();
            $('#spoFileInput').click();
        })

        $(document).on('click','#sponSea', function (){
            event.preventDefault();
            $('#spoFileInput').click();
        })


        $('select[name="district"]').on('change', function() {
            var disID = $(this).val();
            console.log(disID);
            if(disID) {
                $.ajax({
                    url:"{{url('admin/getUpazila')}}?district_id="+disID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $('select[name="upazila_id"]').empty();
                        $('#upazila_id').append('<option value="">উপজেলা নির্বাচন করুন</option>');
                        $.each(data, function(key, value) {
                            $('select[name="upazila_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                    }
                });
            }else{
                $('select[name="upazila_id"]').empty();
                $('select[name="union_id"]').empty();
                $('select[name="village_id"]').empty();
            }
        });

        // select Union
        $('select[name="upazila_id"]').on('change', function() {
            var upazilaID = $(this).val();
            console.log(upazilaID);
            if(upazilaID) {
                $.ajax({
                    url: "{{url('admin/getUnion')}}?upazila_id="+upazilaID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $('select[name="union_id"]').empty();
                        $('#union_id').append('<option value="">ইউনিয়ন নির্বাচন করুন</option>');
                        $.each(data, function(key, value) {
                            $('select[name="union_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                    }
                });
            }else{
                $('select[name="union_id"]').empty();
                $('select[name="village_id"]').empty();
            }
        });

       /* // select Village
        $('select[name="union_id"]').on('change', function() {
            var unionID = $(this).val();
            console.log(unionID);
            if(unionID) {
                $.ajax({
                    url: "{{url('admin/getVillage')}}?union_id="+unionID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $('select[name="village_id"]').empty();
                        $('#village_id').append('<option value="">গ্রাম নির্বাচন করুন</option>');
                        $.each(data, function(key, value) {
                            $('select[name="village_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                    }
                });
            }else{
                $('select[name="village_id"]').empty();
            }
        });*/


        $('#speaker_id').select2({
            width: '100%',
            placeholder: "{{__('messages.স্পিকার নির্বাচন করুন')}}",
            allowClear: true
        });
        $('#language_id').select2({
            width: '100%',
            placeholder: "{{__('messages.ভাষা নির্বাচন করুন')}}",
            allowClear: true,
        });
        $('#district_id').select2({
            width: '100%',
            placeholder: "{{__('messages.জেলা নির্বাচন করুন')}} *",
            allowClear: true
        });
        $('#upazila_id').select2({
            width: '100%',
            placeholder: "{{__('messages.উপজেলা নির্বাচন করুন')}} *",
            allowClear: true
        });
        $('#union_id').select2({
            width: '100%',
            placeholder: "{{__('messages.ইউনিয়ন নির্বাচন করুন')}} *",
            allowClear: true
        });
        $('#village_id').select2({
            width: '100%',
            placeholder: "{{__('messages.গ্রাম নির্বাচন করুন')}} *",
            allowClear: true
        });


        //loader
        $(function() {
            $( "form" ).submit(function() {
                $('#loader').show();
            });
        });


    </script>

    <!-- Recorder Function Script -->

    <script src= "{{ asset('/') }}assets/recorder/recorder.js"></script>
    <script>
        jQuery(document).ready(function () {
            var $ = jQuery;
            var myRecorder = {
                objects: {
                    context: null,
                    stream: null,
                    recorder: null
                },
                init: function () {
                    if (null === myRecorder.objects.context) {
                        myRecorder.objects.context = new (
                                window.AudioContext || window.webkitAudioContext
                                );
                    }

                },
                start: function () {
                    var options = {audio: true, video: false};
                    navigator.mediaDevices.getUserMedia(options).then(function (stream) {
                        myRecorder.objects.stream = stream;
                        myRecorder.objects.recorder = new Recorder(
                                myRecorder.objects.context.createMediaStreamSource(stream),
                                {numChannels: 2}
                        );
                        myRecorder.objects.recorder.record();
                    }).catch(function (err) {});

                },
                stop: function (listObject) {
                    if (null !== myRecorder.objects.stream) {
                        myRecorder.objects.stream.getAudioTracks()[0].stop();
                    }
                    if (null !== myRecorder.objects.recorder) {
                        myRecorder.objects.recorder.stop();

                        // Validate object
                        if (null !== listObject
                                && 'object' === typeof listObject
                                && listObject.length > 0) {
                            // Export the WAV file
                            myRecorder.objects.recorder.exportWAV(function (blob) {
                                var url = (window.URL || window.webkitURL)
                                        .createObjectURL(blob);

                                        console.log(url);
                                var reader = new FileReader();

                                reader.readAsDataURL(blob);

                                reader.onloadend = function() {

                                    file_data = reader.result;

                                        // Prepare the playback
                                    var audioObject = $('<audio controls></audio>')
                                            .attr('src', url);

                                    // Prepare the download link
                                    var downloadObject = $('<a>&#9587;</a>')
                                            .attr('onClick', 'closeRecord()')
                                            .attr('class','close-record');


                                    var audioFile = $('<input type="hidden" name="audio_file" value='+file_data+'>');
                                    var audioBlob = $('<input type="hidden" name="audio_blob" value='+file_data+'>');

                                    // Wrap everything in a row
                                    var holderObject = $('<div class="record-files"></div>')
                                            .append(audioObject)
                                            .append(downloadObject)
                                            .append(audioFile)
                                            .append(audioBlob);

                                    // Append to the list
                                    listObject.append(holderObject);

                                }

                            });
                        }
                    }

                }
            };

            // Prepare the recordings list
            var listObject = $('[data-role="recordings"]');

            // Prepare the record button
            $('[data-role="controls"] > .record').click(function () {

                // Initialize the recorder
                myRecorder.init();
                // Get the button state
                var buttonState = !!$(this).attr('data-recording');

                // Toggle
                if (!buttonState) {
                    $(this).attr('data-recording', 'true');
                    myRecorder.start();
                } else {
                    $(this).attr('data-recording', '');
                    myRecorder.stop(listObject);
                }
            });
        });
    </script>

    {{-- Custom Scripts --}}
    <script>
        function initRecorder(){

            $('.audio-input-div').hide();
            $('.holder').show();
        }

        function closeRecord(){

            $('.record-files').remove();

        }
    </script>

    @if(Session::has('justSavedAudio'))

    @endif

@endsection
