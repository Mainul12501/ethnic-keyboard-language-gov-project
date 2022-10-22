@extends('layouts.app')

@section('content')
    <div class="container-fluid pl-0 px-0">
        <div class="card mb-3">
            <div class="card-header">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item" data-toggle="tooltip" data-placement="top" title="Back">
                            <a class="btn btn-sm btn-success" {{-- href="{{route('admin.directed.languages.sentence.list',['task_assign_id'=>$directedAudio->dcDirected->collection->task_assign_id, 'topic_id'=>$directedAudio->dcDirected->topic->id] )}}" --}}>
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

                <form action="{{route('admin.send.data.approved', $directedAudio->id)}}" method="post" >
                    @csrf
                    @method("PUT")
                    <div class="row">
                        <div class="col-md-7 col-sm-12">
                            <input type="hidden" value="{{$directedAudio->dcDirected->collection->task_assign_id}}" name="task_assign_id">
                            <input type="hidden" value="{{$directedAudio->dcDirected->topic->id}}" name="topic_id">
                            <input type="hidden" id="collectorID" value="{{$directedAudio->dcDirected->collection->collector->id}}">
                            {{-- <input type="hidden" id="audioType" value="directed"> --}}
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
                                    <textarea class="form-control" name="bangla" id="english" cols="30" rows="3" readonly> {{($directedAudio->bangla)?$directedAudio->bangla:$directedAudio->directed->sentence}}</textarea>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-3 col-sm-3 col-form-label" >{{__('messages.ইংরেজী')}} </label>
                                <div class=" col-md-9 col-sm-9 col-form-label">
                                    <textarea class="form-control" name="english" id="english" cols="30" rows="3" readonly> {{($directedAudio->english)? $directedAudio->english :$directedAudio->directed->english}}</textarea>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-3 col-sm-3 col-form-label" >{{__('messages.উচ্চারণ')}} </label>
                                <div class=" col-md-9 col-sm-9 col-form-label">
                                    <textarea class="form-control" name="transcription" id="transcription" cols="30" rows="3" readonly>{{$directedAudio->transcription}}</textarea>
                                </div>
                            </div>

                            <div class="text-end" id="trim-button" >
                                <form action="{{route('admin.send.data.approved', $directedAudio->id)}}" method="post" >
                                    <button class="btn btn-success text-white" type="submit">
                                        <svg class="icon  text-white">
                                            <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-check')}}"></use>
                                        </svg>
                                            {{__('messages.অনুমোদন')}}
                                    </button>
                                </form>
                                <button class="btn btn-danger edit-btn text-white" type="button" value="{{ $directedAudio->id }}">
                                    {{__('messages.রিভার্ট')}}
                                </button>
                            </div>

                            <div class="row col-md-6 col-sm-12" id="form-comment" style="display: none;">
                                <form action="" method="post">
                                    <div class="row mb-3">
                                        <label for="">{{__('messages.মেসেজ')}} <span class="text-danger">*</span></label>
                                        <div class="input-group ">
                                            <textarea name="message" class="form-control" id="comment" cols="30" rows="3" required></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 text-end mb-3">
                                            <button class="btn btn-success text-white" type="submit">
                                                <svg class="icon  text-white">
                                                    <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-send')}}"></use>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('admin.data_approval.revert')
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
//revert data
$(document).ready(function (){
            $(document).on('click', '.edit-btn', function (){
                var trimID = $(this).val();
                var collectorID = $('#collectorID').val();
                // var Type = $('#audioType').val();
                $('#trimEditForm').modal('show');

                $.ajax({
                    type: "GET",
                    url: "/admin/directed/revert/"+trimID,
                    dataType: 'json',
                    data: {trimID:trimID,collectorID:collectorID},
                    success:function (response){
                        console.log(response)
                        $('#trimID').val(trimID);
                        $('#collector_id').val(collectorID);
                        console.log(trimID);
                        // $('#audio_type').val(Type);
                        // console.log(audio_type);

                    }
                })
            })
        })


        $("#revert-message").on('click', function (event){
            event.preventDefault();
            var x = document.getElementById("form-comment");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        })

    </script>
@endsection
