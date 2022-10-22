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
                        <li class="breadcrumb-item">{{__('messages.নির্দেশিত')}}</li>
                        <li class="breadcrumb-item" data-toggle="tooltip" data-placement="top" title="Language">
                            {{$directedLanguages->taskAssign->language->name}}
                        </li>
                        <li class="breadcrumb-item" data-toggle="tooltip" data-placement="top" title="District">
                            {{$directedLanguages->taskAssign->district->name}}
                        </li>
                        <li class="breadcrumb-item" data-toggle="tooltip" data-placement="top" title="Sentence">
                            {{ $directedLanguages->topic->name }}
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">

                @foreach ($sentence as $sentences)

                    <div class="row">
                        <div class="col-md-5 col-sm-12">
                            <form action="" id="sentence_form" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <label class="" >{{__('messages.স্পিকার')}} </label>
                                    <div class="input-group">
                                    <div class=" col-md-10 col-sm-9 col-form-label">
                                        <input type="hidden" value="directeds" name="type_id">
                                        <input type="hidden" value="{{ $data['language_id']}}" name="language_id" id="language_id">
                                        <input type="hidden" value="{{ $data['district_id'] }}" name="district_id" id="district_id">
                                        <input type="hidden" value="{{ $data['task_assign_id'] }}" name="task_assign_id">
                                        <input type="hidden" value="{{ $sentences->topics->id }}" name="topic_id">
                                        <input type="hidden" value="{{ $sentences->id }}" name="directed_id">
                                        @forelse($directedAudios as $directedSentenceID)
                                            <input type="hidden" value="{{ $directedSentenceID->dcDirected->dcSentence->id ?? null }}" name="sentence_id">
                                        @empty
                                            <input type="hidden" value="" name="sentence_id">
                                        @endforelse
                                        <div class="input-group">
                                            <div class="col-md-7">
                                                @if (!$directedAudios->isEmpty())
                                                <ul class="list-group list-group-horizontal">
                                                    <li class="list-group-item">
                                                        <div class="row">
                                                            <div class="col">
                                                                @foreach ($directedAudios as $directedAudio)
                                                                <a href="{{route('admin.speakers.edit', $directedAudio->speaker->id)}}" class="text-decoration-none" target="_blank">{{$directedAudio->speaker->name}}</a>
                                                            @endforeach
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>


                                                @else
                                                    {{-- @if (!$directedLanguages->taskAssign->speakers->isEmpty()) --}}
                                                        {{-- @if(!$languageBySpeakers->speaker_id->isEmpty()) --}}
                                                        <div class="input-group">
                                                            {{-- <select class="form-select @error('speaker_id') is-invalid @enderror" id="speaker_id" name="speaker_id[]"> --}}
                                                            <select  class="form-select " id="speaker_id" name="speaker_id">
                                                                <option value="">{{__('messages.স্পিকার নির্বাচন করুন')}}</option>

                                                                @foreach($languageBySpeakers as $languageBySpeaker)
                                                                    <option value="{{$languageBySpeaker->speaker_id}}"  @if($languageBySpeaker->speaker_id==old('speaker_id')) selected @endif >{{$languageBySpeaker->speaker_name}}({{$languageBySpeaker->district_name}})</option>
                                                                @endforeach

                                                            </select>
                                                            @error('speaker_id')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            {{-- @endif --}}
                                                            {{-- <select class="form-select " id="speaker_id" name="speaker_id">
                                                                @foreach($directedLanguages->taskAssign->speakers as $key => $speaker)
                                                                    <option value="{{$speaker->id}}">{{$speaker->name}}</option>
                                                                @endforeach
                                                            </select> --}}
                                                        </div>
                                                    @endif
                                                {{-- @endif --}}
                                            </div>
                                            <div class="col-md-5 text-end">
                                                <button class="btn btn-sm btn-success text-white speaker-create" type="button" value="{{$directedLanguages->task_assign_id}}" > {{__('messages.নতুন স্পিকার')}}</button>
                                                @if ($languageBySpeakers->isEmpty())
                                                    <p><small class="text-danger">Please Add Speaker </small></p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                {{-- <div class="row">
                                    <label class="col-md-2 col-sm-3 col-form-label" >{{__('messages.বিষয়')}} </label>
                                    <div class=" col-md-10 col-sm-9 col-form-label">
                                        {{ $sentences->topics->name }}
                                    </div>
                                </div> --}}
                                <div class="row">
                                    <label class="" >{{__('messages.অডিও')}} </label>
                                    <div class="input-group">
                                    <div class=" col-md-10 col-sm-9">
                                        <input type="hidden"  id="audio" value="">
                                        <div class="input-group">
                                            <div id="audio-upload-field" class="col-md-8 mt-2">
                                                <input class="form-control" id="audio-upload" type="file" name="audio[]" onchange="document.getElementById('audio-file').src = window.URL.createObjectURL(this.files[0])" @if($languageBySpeakers->isEmpty()) disabled @endif/>
                                                <img src="" alt="">
                                            </div>
                                            <div class="recorder col-md-4 ps-4"  >
                                                <div class="d-flex">
                                                    <div class="holder">
                                                        <div data-role="controls"  @if($languageBySpeakers->isEmpty()) disabled style="pointer-events: none" @endif>
                                                            <div  class="record" data-toggle="tooltip" data-placement="top" title="Start Recording">
                                                                <i id="direct-record" class="fa-solid fa-microphone"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="audio_player mt-3" style="display: none">
                                            <div class="input-group">
                                                <audio id="audio-file" controls="true" ></audio>
                                                <a onclick="closeFile()" class="btn mt-1">╳</a>
                                            </div>
                                        </div>
                                        <div class="mt-3" data-role="recordings"></div>

                                        @if (!$directedAudios->isEmpty())
                                            @foreach ($directedAudios as $directedItem )
                                                <input type="hidden" id="audio-exist" value="{{$directedItem->dcDirected->dcSentence->audio}}">
                                                <div id="wavetrim"></div>
                                                <div id="waveform-time-indicator" class="justify-content-between">
                                                    <input type="button" id="btn-play" value="Play"/>
                                                    <span class="time">00:00:00</span>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="" > {{__('messages.বাংলা')}}</label>
                                        <div class="input-group">
                                            <div class=" col-md-10 col-sm-9">
                                                <ul class="list-group list-group-horizontal">
                                                    <li class="list-group-item">
                                                        <div class="row">
                                                            <div class="col">
                                                                {{ $sentences->sentence }}
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>

                                            </div>
                                        </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="" >{{__('messages.অনুবাদ')}} </label>
                                        <div class="input-group">
                                            <div class=" col-md-10 col-sm-9">
                                                <ul class="list-group list-group-horizontal">
                                                    <li class="list-group-item">
                                                        <div class="row">
                                                            <div class="col">
                                                                {{ $sentences->english}}
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                </div>
                                <div class="row mb-2">

                                    <label class="" >{{__('messages.উচ্চারণ')}} </label>
                                    <div class="input-group">
                                    <div class=" col-md-10 col-sm-9">
                                                @forelse ($directedAudios as $directedItem )
                                                    <textarea name="transcription" id="spelling" cols="20" rows="2" class="form-control">{{ $directedItem->dcDirected->dcSentence->transcription}}</textarea>
                                                 @empty
                                                    <textarea name="transcription" id="spelling" cols="20" rows="2" class="form-control" @if($languageBySpeakers->isEmpty()) disabled @endif></textarea>
                                                @endforelse

                                    </div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="text-end col-md-10 m-1" @if($directedLanguages->taskAssign->speakers->isEmpty()) data-toggle="tooltip" data-placement="top" title="you can not procceed without speaker" @endif>
                                        <a href="{{ $sentence->nextPageUrl() != null ? $sentence->nextPageUrl() : ''  }}" style="display: none" id="next_page"></a>
                                        @if($sentence->previousPageUrl() != null)
                                            <a href="{{ $sentence->previousPageUrl() }}" class="btn btn-success text-white float-start">Previous</a>
                                        @endif
                                        <button type="submit" class="btn btn-success text-white" id="save_form" @if($languageBySpeakers->isEmpty()) disabled  style="cursor:not-allowed; pointer-events: all;" @endif>{{ $sentence->nextPageUrl() != null ? 'Submit & Next' : 'Submit' }}</button>
                                    </div>
                                </div>

                                <br>
                            </form>
                            {{-- <div class="text-center">
                                {{ $sentence->links('vendor.pagination.custom') }}
                            </div> --}}
                        </div>
                        {{-- table start --}}

                        {{-- table end --}}
                    </div>
                @endforeach


            </div>
        </div>

    </div>
    <!-- Speaker create modal-->
    @include('admin.speaker.create')

@endsection
@section('language-js')

    <script>
        $(document).ready(function () {
            // directed sentence active
            $(function($) {
                let url = window.location.href;
                const queryString = window.location.search;
                const urlParams = new URLSearchParams(queryString);
                const pageNo = urlParams.get('page')
                if (pageNo === null){
                    $("#data-collection tbody").children(":first").addClass('collection-active');
                }
                $('#data-collection tbody tr td a').each(function() {
                    if (this.href === url) {
                        $(this).closest('tr').addClass('collection-active');
                    }
                });
            });
        });

       /* $("#speaker_id option:first").attr("selected", "selected");
        $('#mylist').val(1).trigger('change.select2');*/
        // upload changed
        $(document).ready(function () {
            $('#audio-upload').change(function (e) {
                $('.recorder').hide();
                $('.audio_player').show();
                $('#audio-upload-field').addClass('col-md-11');
                $('#audio-upload-field').removeClass('col-md-8');
            });
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

        //speaker end
        /*var formClick = document.getElementById('save_form')
        formClick.addEventListener('', function (){
            alert('ys')
        })*/

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
                    $('#direct-record').addClass('fa fa-stop text-white');
                    $('#direct-record').removeClass('fa-solid fa-microphone')
                    $('#audio-upload').hide();
                    myRecorder.start();
                } else {
                    $(this).attr('data-recording', '');
                    $(this).attr('title', 'Start Recording');
                    $('#direct-record').addClass('fa-solid fa-microphone');
                    $('#direct-record').removeClass('fa fa-stop text-white');
                    myRecorder.stop(listObject);
                }
            });
        });
    </script>

    {{-- Custom Scripts --}}
    <script>
        //     function initRecorder(){

        // $('.audio-input-div').hide();
        // $('.holder').show();
        // $('#audio-upload').hide();
        // }
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
        $(document).ready(function () {

            var page  = $('#next_page').attr('href');

            if (page == undefined) {

                $('#save_form').html('Submit');
            }
        });
    </script>

    <script>
        function submitData() {

            var form     = document.getElementById("sentence_form")
            var formData = new FormData(form);
            page = $('#next_page').attr('href');
            submit = document.getElementById("save_form").innerHTML;
            $.ajax({

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                type:'post',
                url: "{{ route('submit.sentence') }}",
                data: formData,
                processData: false,
                contentType: false,
                dataType:'json',
                async :true,

                beforeSend: function () {
                    $("body").css("cursor", "progress");
                },

                success: function (data) {
// console.log(data);

                    toastr.success(data.msg);

                    if (page == undefined) {

                        window.location.href = document.location.origin;
                    }else if(submit == 'Submit'){
                        window.location.href =  baseUrl;
                    }else{

                        window.location.href = $('#next_page').attr('href');
                    }
                    // if(submit == 'Submit'){
                    //     window.location.href =   window.location.href;
                    // }

                },


                complete: function (data) {
                    $("body").css("cursor", "default");
                },
                //    error: function (data) {
                //     toastr.success(data.msg);
                // }

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
                var topicID = $("#topic_id").val();
                var directedID = $("#directed_id").val();
                var languageID = $("#language_id").val();
                var districtID = $("#district_id").val();
// colsole.log(languageID)
                $('#speakerForm').modal('show');
                $.ajax({
                    type: "GET",
                    url: "{{ route('admin.speakers.task.create')}}" + '/' + taskAssignID,
                    dataType: 'json',
                    // data: {taskAssignID:taskAssignID},
                    success:function (response){
                        console.log(response)
                        $('#task_assign_id').val(taskAssignID);
                        $('#topicID').val(topicID);
                        $('#directedID').val(directedID);
                        $('#languageID').val(languageID);
                        $('#districtID').val(districtID);
                    }
                })
            })
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
