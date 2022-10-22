@extends('layouts.app')

@section('content')
    <div class="container-fluid pl-0 px-0">
        <div class="card mb-3">
            <div class="card-header">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item" data-toggle="tooltip" data-placement="top" title="Back">
                            <a class="btn btn-sm btn-success" href="{{route('admin.spontaneous.language.tasks.list', $dcSpontaneous->collection->task_assign_id)}}">
                                <i class="fas fa-arrow-left text-white"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">{{__('messages.স্বতঃস্ফূর্ত')}}</li>
                        <li class="breadcrumb-item" data-toggle="tooltip" data-placement="top" title="Language" >
                            {{$dcSpontaneous->collection->language->name}}
                        </li>
                        <li class="breadcrumb-item" data-toggle="tooltip" data-placement="top" title="District">
                            {{$dcSpontaneous->collection->district->name}}
                        </li>
                        <li class="breadcrumb-item" data-toggle="tooltip" data-placement="top" title="Group">
                            {{isset($dcSpontaneous->collection->taskAssign->group)? $dcSpontaneous->collection->taskAssign->group->name: ''}}
                        </li>
                        <li class="breadcrumb-item" data-toggle="tooltip" data-placement="top" title="Collector">
                            <a href="{{route('admin.data_collectors.show', $dcSpontaneous->collection->collector->id )}}" class="text-decoration-none" target="_blank">
                                {{$dcSpontaneous->collection->collector->name}}
                            </a>

                        </li>
                        <li class="breadcrumb-item" data-toggle="tooltip" data-placement="top" title="Speaker">
                            <a href="{{route('admin.speakers.edit',$dcSpontaneous->collection->speaker->id)}}" class="text-decoration-none" target="_blank">
                                {{$dcSpontaneous->collection->speaker->name}}
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
                <form action="{{route('admin.data_collections.spontaneous.update', $dcSpontaneous->id)}}" method="post" >
                    @csrf
                    @method("PUT")
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="row mb-3">
                                <label for="word">{{__('messages.কীওয়ার্ড')}} </label>
                                <div class="input-group ">
                                    <input readonly class="form-control" name="word" id="word" type="text" value="{{$dcSpontaneous->spontaneous->word}}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="nid">{{__('messages.সংগৃহীত')}} <span class="text-danger">*</span></label>
                                <div>
                                    <input type="hidden" id="audio" value="{{$dcSpontaneous->audio}}">
                                    <div id="waveform"></div>
                                    <div id="waveform-time-indicator">
                                        <span class="time">00:00:00</span>
                                    </div>
                                    <input type="button" id="btn-play" value="Play" disabled="disabled"/>
                                    <input type="button" id="btn-pause" value="Pause" disabled="disabled"/>
                                    <input type="button" id="btn-stop" value="Stop" disabled="disabled" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label  for="bangla">{{__('messages.বাংলা')}}</label>
                                <div class="input-group ">
                                    <textarea class="form-control @error('bangla') is-invalid @enderror" name="bangla" id="bangla" cols="30" rows="3">{{$dcSpontaneous->bangla}}</textarea>
                                    @error('bangla')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label  for="english">{{__('messages.অনুবাদ')}}</label>
                                <div class="input-group ">
                                    <textarea class="form-control @error('english') is-invalid @enderror" name="english" id="english" cols="30" rows="3">{{$dcSpontaneous->english}}</textarea>
                                    @error('english')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label  for="transcription">{{__('messages.উচ্চারণ')}}</label>
                                <div class="input-group ">
                                    <textarea class="form-control @error('transcription') is-invalid @enderror" name="transcription" id="transcription" cols="30" rows="3">{{$dcSpontaneous->transcription}}</textarea>
                                    @error('transcription')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
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
@section('group-task-assgin-js')
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
