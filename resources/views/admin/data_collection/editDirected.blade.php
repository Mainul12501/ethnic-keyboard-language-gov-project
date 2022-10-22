@extends('layouts.app')

@section('content')
    <div class="container-fluid pl-0 px-0">
        <div class="card mb-3">
            <div class="card-header">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item" data-toggle="tooltip" data-placement="top" title="Back">
                            <a class="btn btn-sm btn-success" href="{{route('admin.directed.languages.sentence.list',['task_assign_id'=>$directedAudio->dcDirected->collection->task_assign_id, 'topic_id'=>$directedAudio->dcDirected->topic->id] )}}">
                                <i class="fas fa-arrow-left text-white"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">{{__('messages.নির্দেশিত')}}</li>
                        <li class="breadcrumb-item" data-toggle="tooltip" data-placement="top" title="Language">
                            {{$directedAudio->dcDirected->collection->language->name}}
                        </li>
                        <li class="breadcrumb-item" data-toggle="tooltip" data-placement="top" title="District">
                            {{$directedAudio->dcDirected->collection->district->name}}
                        </li>
                         <li class="breadcrumb-item" data-toggle="tooltip" data-placement="top" title="Group">
                             {{isset($directedAudio->dcDirected->collection->taskAssign->group)? $directedAudio->dcDirected->collection->taskAssign->group->name: ''}}
                         </li>
                        <li class="breadcrumb-item" data-toggle="tooltip" data-placement="top" title="Collector">
                            <a href="{{route('admin.data_collectors.show', $directedAudio->dcDirected->collection->collector->id )}}" class="text-decoration-none" target="_blank">
                                {{$directedAudio->dcDirected->collection->collector->name}}
                            </a>
                        </li>
                        <li class="breadcrumb-item" data-toggle="tooltip" data-placement="top" title="Speaker">
                            <a href="{{route('admin.speakers.edit',$directedAudio->dcDirected->collection->speaker->id)}}" class="text-decoration-none" target="_blank">
                                {{$directedAudio->dcDirected->collection->speaker->name}}
                            </a>

                        </li>
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
                <form action="{{route('admin.data_collections.directed.update', $directedAudio->id)}}" method="post" >
                    @csrf
                    @method("PUT")
                    <div class="row">
                        <div class="col-md-7 col-sm-12">
                            <div class="row">
                                <label class="col-md-3 col-sm-3 col-form-label" >{{__('messages.বিষয়')}} </label>
                                <div class=" col-md-9 col-sm-9 col-form-label">
                                    {{$directedAudio->dcDirected->topic->name}}
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-sm-3 col-form-label" >{{__('messages.সংগৃহীত')}} </label>
                                <div class=" col-md-9 col-sm-9 col-form-label">

                                    <input type="hidden" id="audio" value="{{$directedAudio->audio}}">
                                    <div id="waveform"></div>
                                    <div id="waveform-time-indicator">
                                        <span class="time">00:00:00</span>
                                    </div>
                                    <input type="button" id="btn-play" value="Play" disabled="disabled"/>
                                    <input type="button" id="btn-pause" value="Pause" disabled="disabled"/>
                                    <input type="button" id="btn-stop" value="Stop" disabled="disabled" />


                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-3 col-sm-3 col-form-label" > {{__('messages.বাংলা')}}</label>
                                <div class=" col-md-9 col-sm-9 col-form-label">
                                    <textarea class="form-control" name="bangla" id="english" cols="30" rows="3"> {{($directedAudio->bangla)?$directedAudio->bangla:$directedAudio->directed->sentence}}</textarea>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-3 col-sm-3 col-form-label" >{{__('messages.ইংরেজী')}} </label>
                                <div class=" col-md-9 col-sm-9 col-form-label">
                                    <textarea class="form-control" name="english" id="english" cols="30" rows="3"> {{($directedAudio->english)? $directedAudio->english :$directedAudio->directed->english}}</textarea>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-3 col-sm-3 col-form-label" >{{__('messages.উচ্চারণ')}} </label>
                                <div class=" col-md-9 col-sm-9 col-form-label">
                                    <textarea class="form-control" name="transcription" id="transcription" cols="30" rows="3">{{$directedAudio->transcription}}</textarea>
                                </div>
                            </div>

                            <div class="text-end">
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
    <script type="text/javascript">

        var baseUrl = {!! json_encode(url('/')) !!}+ '/';
        var filePath = $('#audio').val();
        let audioPath = baseUrl+filePath;
        var buttons = {
            play: document.getElementById("btn-play"),
            pause: document.getElementById("btn-pause"),
            stop: document.getElementById("btn-stop")
        };

        var Spectrum = WaveSurfer.create({
            container: '#waveform',
            waveColor: '#8eea8e',
            progressColor: "#CACACA",
            /*plugins: [
                WaveSurfer.timeline.create({
                    container: "#waveform"
                })
            ]*/
        });

        buttons.play.addEventListener("click", function(){
            Spectrum.play();
            buttons.stop.disabled = false;
            buttons.pause.disabled = false;
            buttons.play.disabled = true;
        }, false);

        buttons.pause.addEventListener("click", function(){
            Spectrum.pause();
            buttons.pause.disabled = true;
            buttons.play.disabled = false;
        }, false);


        buttons.stop.addEventListener("click", function(){
            Spectrum.stop();
            buttons.pause.disabled = true;
            buttons.play.disabled = false;
            buttons.stop.disabled = true;
        }, false);


        Spectrum.on('ready', function () {
            buttons.play.disabled = false;
        });

        window.addEventListener("resize", function(){
            var currentProgress = Spectrum.getCurrentTime() / Spectrum.getDuration();

            Spectrum.empty();
            Spectrum.drawBuffer();
            Spectrum.seekTo(currentProgress);
            buttons.pause.disabled = true;
            buttons.play.disabled = false;
            buttons.stop.disabled = false;
        }, false);

        Spectrum.load(audioPath);

        Spectrum.on('ready', updateTimer)
        Spectrum.on('audioprocess', updateTimer)

        Spectrum.on('seek', updateTimer)

        function updateTimer() {
            var formattedTime = secondsToTimestamp(Spectrum.getCurrentTime());
            $('#waveform-time-indicator .time').text(formattedTime);
        }

        function secondsToTimestamp(seconds) {
            seconds = Math.floor(seconds);
            var h = Math.floor(seconds / 3600);
            var m = Math.floor((seconds - (h * 3600)) / 60);
            var s = seconds - (h * 3600) - (m * 60);

            h = h < 10 ? '0' + h : h;
            m = m < 10 ? '0' + m : m;
            s = s < 10 ? '0' + s : s;
            return h + ':' + m + ':' + s;
        }


    </script>
@endsection
{{--@section('language-js')

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

    --}}{{-- Custom Scripts --}}{{--
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

@endsection--}}
