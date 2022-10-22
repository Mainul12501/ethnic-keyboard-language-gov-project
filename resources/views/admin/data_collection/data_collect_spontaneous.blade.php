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
                        <li class="breadcrumb-item" data-toggle="tooltip" data-placement="top" title="Back">
                            <a class="btn btn-sm btn-success" href="{{route('admin.dashboard' )}}">
                                <i class="fas fa-arrow-left text-white"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">{{__('messages.স্বতঃস্ফূর্ত')}}</li>
                        <li class="breadcrumb-item" data-toggle="tooltip" data-placement="top" title="Language">
                            {{$spontaneous->taskAssign->language->name}}
                        </li>
                        <li class="breadcrumb-item" data-toggle="tooltip" data-placement="top" title="District">
                            {{$spontaneous->taskAssign->district->name}}
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <form action="" id="sentence_form" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <label class="col-md-3 col-sm-3 col-form-label" >{{__('messages.স্পিকার')}} </label>
                                <div class=" col-md-9 col-sm-9 col-form-label">
                                    <input type="hidden" value="spontaneouses" name="type">
                                    <input type="hidden" value="{{ $data['language_id'] }}" name="language_id" id="language_id">
                                    <input type="hidden" value="{{ $data['district_id'] }}" name="district_id" id="district_id">
                                    <input type="hidden" value="{{ $data['task_assign_id'] }}" name="task_assign_id">
                                    <input type="hidden" id="spontaneous_id" value="{{ $data['spontaneous_id'] }}" name="spontaneous_id">
                                    <input type="hidden" id="dc_spontaneous_id" value="{{  $spontaneousAudio->dcSpontaneous->id ?? null}}" name="dc_spontaneous_id">
                                    <div class="input-group">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-7">
                                                    @if($spontaneousAudio == !null)
                                                        <a href="{{route('admin.speakers.edit',$spontaneousAudio->speaker->id)}}" class="text-decoration-none" target="_blank">{{$spontaneousAudio->speaker->name}}</a>
                                                    @else
                                                        {{-- @if (!$spontaneous->taskAssign->speakers->isEmpty()) --}}
                                                            <div class="input-group">
                                                                <select class="form-select " id="speaker_id" name="speaker_id">
                                                                    @foreach($languageBySpeakers as $languageBySpeaker)
                                                                    <option value="{{$languageBySpeaker->speaker_id}}"  @if($languageBySpeaker->speaker_id==old('speaker_id')) selected @endif >{{$languageBySpeaker->speaker_name}}({{$languageBySpeaker->district_name}})</option>
                                                                @endforeach
                                                                </select>

                                                            </div>
                                                        {{-- @endif --}}
                                                    @endif
                                                </div>
                                                <div class="col-md-5 text-end">
                                                    <button class="btn btn-sm btn-success text-white speaker-create" type="button" value="{{$spontaneous->task_assign_id}}" > {{__('messages.নতুন স্পিকার')}}</button>
                                                    @if ($languageBySpeakers->isEmpty())
                                                    <p><small class="text-danger">Please Add Speaker </small></p>
                                                @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-md-3 col-sm-3 col-form-label" >{{__('messages.বিষয়')}} </label>
                                <div class=" col-md-9 col-sm-9 col-form-label">
                                    <div class="input-group">
                                        {{ $spontaneous->spontaneous->word }}
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-md-3 col-sm-3 col-form-label" >{{__('messages.অডিও')}} </label>
                                <div class=" col-md-9 col-sm-9 col-form-label">
                                    <input type="hidden" id="audio" value="">
                                    <div class="input-group">
                                        <div class="recorder col-md-4"  >
                                            <div class="d-flex">
                                                <div class="holder">
                                                    <div data-role="controls"  @if($languageBySpeakers->isEmpty()) style="pointer-events: none" @endif>
                                                        <div  class="record" data-toggle="tooltip" data-placement="top" title="Start Recording" @if($spontaneous->taskAssign->speakers == null) style="pointer-events: none;" @endif>
                                                            <i id="spont-record" class="fa-solid fa-microphone"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="audio-upload-field" class="col-md-8 mt-2">
                                            <input class="form-control" id="audio-upload" type="file" name="audio[]" onchange="document.getElementById('audio-file').src = window.URL.createObjectURL(this.files[0])"   @if($languageBySpeakers->isEmpty())  disabled @endif/>
                                            <img src="" alt="">
                                        </div>
                                    </div>
                                    <div class="audio_player mt-3" style="display: none">
                                        <div class="input-group">
                                            <audio id="audio-file" controls="true" ></audio>
                                            <a onclick="closeFile()" class="btn mt-1">╳</a>
                                        </div>
                                    </div>
                                    <div class="mt-3" data-role="recordings"></div>

                                    @if ($spontaneousAudio == !null)
                                        <input type="hidden" id="audio-exist" value="{{$spontaneousAudio->dcSpontaneous->audio}}">
                                        <div id="wavetrim"></div>
                                        <div id="waveform-time-indicator" class="justify-content-between">
                                            <input type="button" id="btn-play" value="Play"/>
                                            <span class="time">00:00:00</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-3 col-sm-3 col-form-label" > {{__('messages.বাংলা')}}</label>
                                <div class=" col-md-9 col-sm-9 col-form-label">
                                    <textarea name="bangla" id="bangla" cols="20" rows="2" class="form-control"  @if($languageBySpeakers->isEmpty()) disabled @endif>{{ ($spontaneousAudio == !null)? $spontaneousAudio->dcSpontaneous->bangla :'' }}</textarea>

                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-3 col-sm-3 col-form-label" >{{__('messages.অনুবাদ')}} </label>
                                <div class=" col-md-9 col-sm-9 col-form-label">
                                    <textarea name="english" id="emglish" cols="20" rows="2" class="form-control"   @if($languageBySpeakers->isEmpty()) disabled @endif>{{ ($spontaneousAudio == !null)? $spontaneousAudio->dcSpontaneous->english :'' }} </textarea>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-3 col-sm-3 col-form-label" >{{__('messages.উচ্চারণ')}} </label>
                                <div class=" col-md-9 col-sm-9 col-form-label">
                                    <textarea name="transcription" id="spelling" cols="20" rows="2" class="form-control"   @if($languageBySpeakers->isEmpty()) disabled @endif>{{ ($spontaneousAudio == !null)? $spontaneousAudio->dcSpontaneous->transcription :'' }}</textarea>
                                </div>
                            </div>
                            <div class="text-end" @if($spontaneous->taskAssign->speakers->isEmpty()) data-toggle="tooltip" data-placement="top" title="you can not procceed without speaker" @endif>
                                <button type="submit" class="btn btn-success  text-white" id="next_page"   @if($languageBySpeakers->isEmpty()) disabled  style="cursor:not-allowed; pointer-events: all;" @endif>Save</button>
                            </div>
                        </form>
                    </div>
                    @if(auth()->user()->user_type== 4)
                    <div class="col-md-6 col-sm-12">
                        @if(isset($spontaneousAudio->dcSpontaneous->audio))
                            <div class="mx-auto d-grid"> 
                                <a href="{{ route('trim-page', ['type'=>'spontaneous', 'id' =>$spontaneousAudio->dcSpontaneous->id ]) }}" class="col-sm-4 mx-auto text-white btn btn-success">Trim Page</a>
                            </div>
                        @endif
                    </div>
                    @endif
                </div>

            </div>
        </div>

    </div>

    <!-- Speaker create modal-->
    @include('admin.speaker.create')
@endsection
@section('language-js')
    <script>

        $("#speaker_id option:first").attr("selected", "selected");
        // upload changed
        $(document).ready(function () {
            $('#audio-upload').change(function (e) {
                console.log('yes')
                $('.recorder').hide();
                $('.audio_player').show();
                $('#audio-upload-field').addClass('col-md-11');
                $('#audio-upload-field').removeClass('col-md-8');
            });
        });


        // player added
        var baseUrl = {!! json_encode(url('/')) !!}+ '/';
        var filePath = $('#audio-exist').val();
        console.log(filePath)
        let audioPath = baseUrl+filePath;
        console.log(audioPath)
        var buttons = {
            play: document.getElementById("btn-play"),
        };

        var Spectrum = WaveSurfer.create({
            container: '#wavetrim',
            waveColor: '#8eea8e',
            progressColor: "#CACACA",
        });

        Spectrum.on('ready', function() {
            buttons.play.addEventListener("click", function(){
                if(buttons.play.value === "Play"){
                    buttons.play.value = "Pause";
                    Spectrum.play();
                }else{
                    buttons.play.value= "Play";
                    Spectrum.pause();
                }
            }, false);
        });
        window.addEventListener("resize", function(){
            var currentProgress = Spectrum.getCurrentTime() / Spectrum.getDuration();

            Spectrum.empty();
            Spectrum.drawBuffer();
            Spectrum.seekTo(currentProgress);
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

        $('#waveform-time-indicator').show()

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


                                    var audioFile = $('<input type="hidden" name="audio_file" id="record_file" value='+file_data+'>');
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
                    $(this).attr('title', 'Stop Recording');
                    $('#spont-record').addClass('fa fa-stop text-white');
                    $('#spont-record').removeClass('fa-solid fa-microphone');
                    $('#audio-upload').hide();
                    myRecorder.start();
                } else {
                    $(this).attr('data-recording', '');
                    $(this).attr('title', 'Start Recording');
                    $('#spont-record').addClass('fa-solid fa-microphone');
                    $('#spont-record').removeClass('fa fa-stop text-white');
                    myRecorder.stop(listObject);
                }
            });
        });

    </script>

    {{-- Custom Scripts --}}
    <script>
        function closeRecord(){
            $('.record-files').remove();
            $('#audio-upload').show();
        }

        function closeFile(){
            $('.audio_player').hide();
            $('.recorder').show();
            $('#audio-upload-field').removeClass('col-md-11');
            $('#audio-upload-field').addClass('col-md-8');
            const audioInputFile = document.getElementById('audio-upload');
            audioInputFile.value = '';
        }

    </script>

    <script>
        $('#sentence_form').on('submit',function(e){
            e.preventDefault();

            submitData();
        });
    </script>

    <script>
        function submitData() {

            var form     = document.getElementById("sentence_form")
            var formData = new FormData(form);
            $.ajax({

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                type:'post',
                url: "{{ route('submit.sentence') }}",
                data: formData,
                processData: false,
                contentType: false,
                async :true,

                beforeSend: function () {
                    $("body").css("cursor", "progress");
                },

                success: function (data) {
                    toastr.success(data.msg);
                    window.location.href = document.location.origin;

                },

                complete: function (data) {
                    $("body").css("cursor", "default");
                }

            });

        }
    </script>
    <script>
        @if (count($errors) > 0)
         $( document ).ready(function() {
             $('#speakerForm').modal('show');
         });
        @endif
        $(document).ready(function (){
            $(document).on('click', '.speaker-create', function (){
                var taskAssignID = $(this).val();
                var spontaneousID = $("#spontaneous_id").val();
                var languageID = $("#language_id").val();
                var districtID = $("#district_id").val();
                $('#speakerForm').modal('show');
                $.ajax({
                    type: "GET",
                    url: "{{ route('admin.speakers.task.create')}}" + '/' + taskAssignID,
                    dataType: 'json',
                    data: {spontaneousID:spontaneousID},
                    success:function (response){
                        console.log(response)
                        $('#task_assign_id').val(taskAssignID);
                        $('#spontaneousID').val(spontaneousID);
                        $('#languageID').val(languageID);
                        $('#districtID').val(districtID);
                    }
                })
            })
        })

        $('select[name="district_id"]').on('change', function() {
            var disID = $(this).val();
            console.log(disID);
            if(disID) {
                $.ajax({
                    url:"{{url('admin/getUpazila')}}?district_id="+disID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $('select[name="upazila_id"]').empty();
                        $('#upazila_id').append('<option value="">{{__('messages.উপজেলা নির্বাচন করুন')}}</option>');
                        $.each(data, function(key, value) {
                            $('select[name="upazila_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                    }
                });
            }else{
                $('select[name="upazila_id"]').empty();
                $('select[name="union_id"]').empty();
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
                        $('#union_id').append('<option value="">{{__('messages.ইউনিয়ন নির্বাচন করুন')}}</option>');
                        $.each(data, function(key, value) {
                            $('select[name="union_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                    }
                });
            }else{
                $('select[name="union_id"]').empty();
            }
        });
        //speaker start
        $(document).ready(function() {
            var speaker = $('#speaker_id option:selected').val();
            if(speaker){
                x.style.display = "block";
            }
            $('select').on('change', function() {
                var value =this.value;
                var x = document.getElementById("remove");
                if(value){
                    x.style.display = "block";
                }
            });
        });
        $('#speaker_id').select2({
            width: '100%',
            placeholder: "{{__('messages.স্পিকার নির্বাচন করুন')}}",
            allowClear: true
        });

        $('#district_id').select2({
            dropdownParent: $("#speakerForm"),
            width: '100%',
            placeholder: "{{__('messages.জেলা নির্বাচন করুন')}}",
            allowClear: true
        });
        $('#upazila_id').select2({
            dropdownParent: $("#speakerForm"),
            width: '100%',
            placeholder: "{{__('messages.উপজেলা নির্বাচন করুন')}}",
            allowClear: true
        });
        $('#union_id').select2({
            dropdownParent: $("#speakerForm"),
            width: '100%',
            placeholder: "{{__('messages.ইউনিয়ন নির্বাচন করুন')}}",
            allowClear: true
        });

    </script>
@endsection
