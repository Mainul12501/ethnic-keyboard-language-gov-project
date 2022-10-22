@extends('layouts.app')

@section('content')
    <div class="container-fluid pl-0 px-0">
        <div class="card mb-3">
            <div class="card-header">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.data_collections.index')}}">{{__('messages.তথ্য সংগ্রহ')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('messages.স্বতঃস্ফূর্ত')}}</li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('messages.কীওয়ার্ড')}}</li>
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
                <form action="{{route('admin.data_collections.update', $spontaneousAudio->id)}}" method="post" >
                    @csrf
                    @method("PUT")
                    <div class="row">
                        <div class="col-md-7 col-sm-12">
                            <div class="row">
                                <label class="col-md-3 col-sm-3 col-form-label" >{{__('messages.কীওয়ার্ড')}} </label>
                                <div class=" col-md-9 col-sm-9 col-form-label">
                                    {{$spontaneousAudio->spontaneous->word}}
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3 col-sm-3 col-form-label" >{{__('messages.সংগৃহীত')}} </label>
                                <div class=" col-md-9 col-sm-9 col-form-label">
                                    <input type="hidden" name="approved_by" id="approved_by" value="{{auth()->id()}}">
                                    {{--<audio src="{{asset($spontaneousAudio->audio)}}" controls>
                                        <source src="" type="audio/*">
                                    </audio>--}}
                                    <input type="hidden" id="audio" value="{{$spontaneousAudio->audio}}">
                                    <div id="waveform"></div>
                                    <div id="waveform-time-indicator">
                                        <span class="time">00:00:00</span>
                                    </div>
                                    <input type="button" id="btn-play" value="Play" disabled="disabled"/>
                                    <input type="button" id="btn-pause" value="Pause" disabled="disabled"/>
                                    <input type="button" id="btn-stop" value="Stop" disabled="disabled" />
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 text-center">
                                    <button class="btn btn-success btn-sm text-white" type="submit">
                                        <svg class="icon  text-white">
                                            <use xlink:href="http://localhost:8000/assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-check"></use>
                                        </svg>
                                        {{__('messages.অনুমোদন')}}</button>
                                    {{--<button class="btn btn-danger btn-sm text-white" type="submit">বাদ দিন</button>--}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <div>{{__('messages.Meta data')}}</div>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <label class="col-md-3 col-sm-3 col-form-label" >{{__('messages.গ্রুপের নামঃ')}} </label>
                                        <div class=" col-md-9 col-sm-9 col-form-label">
                                            {{isset($spontaneousAudio->collection->taskAssign->group)? $spontaneousAudio->collection->taskAssign->group->name: ''}}
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row ">
                                        <label class="col-md-3 col-sm-3 col-form-label" >{{__('messages.কালেক্টর নামঃ')}} </label>
                                        <div class=" col-md-9 col-sm-9 col-form-label">
                                            {{$spontaneousAudio->collection->collector->name}}
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <label class="col-md-3 col-sm-3 col-form-label" >{{__('messages.ইমেইলঃ')}} </label>
                                        <div class=" col-md-9 col-sm-9 col-form-label">
                                            <a href="mail:{{$spontaneousAudio->collection->collector->email}}">{{$spontaneousAudio->collection->collector->email}}</a>
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <label class="col-md-3 col-sm-3 col-form-label" >{{__('messages.ফোনঃ')}} </label>
                                        <div class=" col-md-9 col-sm-9 col-form-label">
                                            <a href="tel:{{$spontaneousAudio->collection->collector->phone}}">{{$spontaneousAudio->collection->collector->phone}}</a>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row ">
                                        <label class="col-md-3 col-sm-3 col-form-label" >{{__('messages.স্পিকার নামঃ')}} </label>
                                        <div class=" col-md-9 col-sm-9 col-form-label">
                                            {{$spontaneousAudio->collection->speaker->name}}
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <label class="col-md-3 col-sm-3 col-form-label" >{{__('messages.বয়সঃ')}} </label>
                                        <div class=" col-md-9 col-sm-9 col-form-label">
                                            {{$spontaneousAudio->collection->speaker->age}}
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <label class="col-md-3 col-sm-3 col-form-label" >{{__('messages.লিঙ্গঃ')}}</label>
                                        <div class=" col-md-9 col-sm-9 col-form-label">
                                            @if($spontaneousAudio->collection->speaker->gender == 0)
                                            {{__('messages.পুরুষ')}}
                                            @elseif($spontaneousAudio->collection->speaker->gender== 1)
                                            {{__('messages.মহিলা')}}
                                            @else
                                            {{__('messages.অন্যান্য')}}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('language-filter-js')
    <script src="https://unpkg.com/wavesurfer.js"></script>
    <script src="https://unpkg.com/wavesurfer.js/dist/plugin/wavesurfer.regions.min.js"></script>

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
