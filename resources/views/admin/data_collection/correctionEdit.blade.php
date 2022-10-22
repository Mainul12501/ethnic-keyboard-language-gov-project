@extends('layouts.app')
@section('content')
    <div class="container-fluid pl-0 px-0">
        <div class="card mb-3">
            <div class="card-header">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.data_collections.index')}}">{{__('messages.তথ্য সংগ্রহ')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{($type == 'directed')? __('messages.নির্দেশিত ট্রিমিং'): __('messages.স্বতঃস্ফূর্ত ট্রিমিং') }}</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-7 col-sm-12">
                        @if (isset($audio->directed))
                            <div class="row">
                                <label class="col-md-3 col-sm-3 col-form-label" >{{__('messages.বিষয়')}} </label>
                                <div class=" col-md-9 col-sm-9 col-form-label">
                                    {{$audio->dcDirected->topic->name}}
                                </div>
                            </div>
                        @endif
                        <div class="row">
                            <label class="col-md-3 col-sm-3 col-form-label" >{{__('messages.অডিও')}} </label>
                            <div class=" col-md-9 col-sm-9 col-form-label">
                                <input type="hidden" id="audio" value="{{$audio->audio}}">
                                <div id="wavetrim"></div>
                                <div id="waveform-time-indicator" class="justify-content-between">
                                    <input type="button" id="btn-play" value="Play"/>
                                    <span class="time">00:00:00</span>
                                </div>
                            </div>
                        </div>
                        @if (isset($audio->directed))
                            <div class="row mb-2">
                                <label class="col-md-3 col-sm-3 col-form-label" > {{__('messages.বাংলা')}}</label>
                                <div class=" col-md-9 col-sm-9 col-form-label">
                                    <textarea class="form-control" name="bangla" id="english" cols="30" rows="3">{{$audio->directed->sentence}}</textarea>

                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-3 col-sm-3 col-form-label" >{{__('messages.ইংরেজী')}} </label>
                                <div class=" col-md-9 col-sm-9 col-form-label">
                                    <textarea class="form-control" name="english" id="english" cols="30" rows="3">  {{$audio->directed->english}}</textarea>

                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-3 col-sm-3 col-form-label" >{{__('messages.উচ্চারণ')}} </label>
                                <div class=" col-md-9 col-sm-9 col-form-label">
                                    <textarea class="form-control" name="transcription" id="transcription" cols="30" rows="3">{{$audio->transcription}}</textarea>

                                </div>
                            </div>
                        @else
                            <div class="row mb-2">
                                <label class="col-md-3 col-sm-3 col-form-label" >{{__('messages.কীওয়ার্ডঃ')}} </label>
                                <div class=" col-md-9 col-sm-9 col-form-label">
                                    {{ $audio->spontaneous->word }}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-3 col-sm-3 col-form-label" > {{__('messages.বাংলা')}}</label>
                                <div class=" col-md-9 col-sm-9 col-form-label">
                                    {{$audio->bangla}}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-3 col-sm-3 col-form-label" >{{__('messages.ইংরেজী')}} </label>
                                <div class=" col-md-9 col-sm-9 col-form-label">
                                    {{$audio->english}}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-3 col-sm-3 col-form-label" >{{__('messages.উচ্চারণ')}} </label>
                                <div class=" col-md-9 col-sm-9 col-form-label">
                                    {{$audio->transcription}}
                                </div>
                            </div>
                        @endif

                    </div>
                    <div class="col-md-5 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <div>{{__('messages.Meta data')}}</div>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    @if(isset($audio->dcDirected->collection->taskAssign->group))
                                    <label class="col-md-3 col-sm-3 col-form-label" >{{__('messages.গ্রুপের নামঃ')}} </label>
                                    @elseif(isset($audio->collection->taskAssign->group))
                                        <label class="col-md-3 col-sm-3 col-form-label" >{{__('messages.গ্রুপের নামঃ')}} </label>
                                    @else
                                        <label class="col-md-3 col-sm-3 col-form-label" ></label>
                                    @endif
                                    <div class=" col-md-9 col-sm-9 col-form-label">
                                        @if (isset($audio->directed))
                                            {{isset($audio->dcDirected->collection->taskAssign->group)? $audio->dcDirected->collection->taskAssign->group->name: ''}}
                                        @else
                                            {{isset($audio->collection->taskAssign->group)? $audio->collection->taskAssign->group->name: ''}}
                                        @endif
                                    </div>
                                </div>
                                <hr>
                                <div class="row ">
                                    <label class="col-md-3 col-sm-3 col-form-label" >{{__('messages.কালেক্টর নামঃ')}} </label>
                                    <div class=" col-md-9 col-sm-9 col-form-label">
                                        @if (isset($audio->directed))
                                            {{$audio->dcDirected->collection->collector->name}}
                                        @else
                                            {{$audio->collection->collector->name}}
                                        @endif
                                    </div>
                                </div>
                                <div class="row ">
                                    <label class="col-md-3 col-sm-3 col-form-label" >{{__('messages.ইমেইলঃ')}} </label>
                                    <div class=" col-md-9 col-sm-9 col-form-label">
                                        @if (isset($audio->directed))
                                            <a href="mail:{{$audio->dcDirected->collection->collector->email}}">{{$audio->dcDirected->collection->collector->email}}</a>
                                        @else
                                            <a href="mail:{{$audio->collection->collector->email}}">{{$audio->collection->collector->email}}</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="row ">
                                    <label class="col-md-3 col-sm-3 col-form-label" >{{__('messages.ফোনঃ')}} </label>
                                    <div class=" col-md-9 col-sm-9 col-form-label">
                                        @if (isset($audio->directed))
                                            <a href="tel:{{$audio->dcDirected->collection->collector->phone}}">{{$audio->dcDirected->collection->collector->phone}}</a>
                                        @else
                                            <a href="tel:{{$audio->collection->collector->phone}}">{{$audio->collection->collector->phone}}</a>
                                        @endif
                                    </div>
                                </div>
                                <hr>
                                <div class="row ">
                                    <label class="col-md-3 col-sm-3 col-form-label" > {{__('messages.স্পিকার নামঃ')}}</label>
                                    <div class=" col-md-9 col-sm-9 col-form-label">
                                        @if (isset($audio->directed))
                                            {{$audio->dcDirected->collection->speaker->name}}
                                        @else
                                            {{$audio->collection->speaker->name}}
                                        @endif
                                    </div>
                                </div>
                                <div class="row ">
                                    <label class="col-md-3 col-sm-3 col-form-label" >{{__('messages.বয়সঃ')}} </label>
                                    <div class=" col-md-9 col-sm-9 col-form-label">
                                        @if (isset($audio->directed))
                                            {{$audio->dcDirected->collection->speaker->age}}
                                        @else
                                            {{$audio->collection->speaker->age}}
                                        @endif
                                    </div>
                                </div>
                                <div class="row ">
                                    <label class="col-md-3 col-sm-3 col-form-label" >{{__('messages.পেশাঃ')}} </label>
                                    <div class=" col-md-9 col-sm-9 col-form-label">
                                        @if (isset($audio->directed))
                                            {{$audio->dcDirected->collection->speaker->occupation}}
                                        @else
                                            {{$audio->collection->speaker->occupation}}
                                        @endif
                                    </div>
                                </div>
                                <div class="row ">
                                    <label class="col-md-3 col-sm-3 col-form-label" >{{__('messages.লিঙ্গঃ')}} </label>
                                    <div class=" col-md-9 col-sm-9 col-form-label">
                                        @if (isset($audio->directed))
                                            @if($audio->dcDirected->collection->speaker->gender == 0)
                                                {{__('messages.পুরুষ')}}
                                            @elseif($audio->dcDirected->collection->speaker->gender== 1)
                                                {{__('messages.মহিলা')}}
                                            @else
                                                {{__('messages.অন্যান্য')}}
                                            @endif
                                        @else
                                            @if($audio->collection->speaker->gender == 0)
                                                {{__('messages.পুরুষ')}}
                                            @elseif($audio->collection->speaker->gender== 1)
                                                {{__('messages.মহিলা')}}
                                            @else
                                                {{__('messages.অন্যান্য')}}
                                            @endif
                                        @endif

                                    </div>
                                </div>
                                <div class="row ">
                                    <label class="col-md-3 col-sm-3 col-form-label" >{{__('messages.পেশাঃ')}} </label>
                                    <div class=" col-md-9 col-sm-9 col-form-label">
                                        {{-- <a target="_blank" href="https://www.google.com/maps/place/{{$audio->collection->longitude}}{{$audio->collection->latitude}}">GoogleMaps</a> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="container-fluid pl-0 px-0">
        <div class="card mb-3">
            <div class="card-header">
                <h6>{{__('messages.ট্রিমিং এর তালিকা')}} </h6>
            </div>
            <div class="card-body">
                <div>
                    <div class="table-responsive">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <table class="table table-hover table-bordered" id="trim-collection">
                                    @if($audio->d_c_directed_id == $audio->id)
                                        <input class="form-check-input" id="d_c_directed_sentences_id" name ="d_c_directed_sentences_id"  type="hidden" value="{{$audio->id}}">
                                    @else
                                        <input class="form-check-input" id="d_c_spontaneouses_id" name ="d_c_spontaneouses_id"  type="hidden" value="{{$audio->id}}">
                                    @endif
                                    <thead class="table-dark">
                                    <tr>
                                        <th scope="col">{{__('messages.ক্রমিক নং')}}</th>
                                        <th scope="col">{{__('messages.অডিও ট্রিম')}}</th>
                                        <th scope="col">{{__('messages.বাংলা')}} </th>
                                        <th scope="col">{{__('messages.ইংরেজী')}}</th>
                                        <th scope="col">{{__('messages.উচ্চারণ')}} </th>
                                        <th scope="col">{{__('messages.স্ট্যাটাস')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbody">
                                    @foreach($trims as $key =>$trim)
                                        <tr>
                                            <td>{{++$key}}</td>
                                            <td class="align-middle text-center" >
                                                <button style="display: none;" class="myLink" onclick="audioFile({{ $trim }})"></button>
                                                <div id="waveform{{substr(str_replace('uploads/trim-audio/', '', $trim->audio), 0, -4)}}"></div>
                                                <div id="waveform-time-indicator" class="justify-content-between">
                                                    <input type="button" id="play-pause{{substr(str_replace('uploads/trim-audio/', '', $trim->audio), 0, -4)}}" value="Play"/>
                                                    <span id="total-time" class="time{{substr(str_replace('uploads/trim-audio/', '', $trim->audio), 0, -4)}}">00:00:00</span>

                                                </div>
                                            </td>
                                            <td>{{$trim->bangla}}</td>
                                            <td>{{$trim->english}}</td>
                                            <td>{{$trim->transcription}}</td>
                                            <td>
                                                @if($trim->status == 0)
                                                    <span class="badge rounded-pill bg-info">{{__('messages.প্রক্রিয়াধীন')}}</span>
                                                @elseif($trim->status == 1)
                                                    <span class="badge rounded-pill bg-warning">{{__('messages.বিচারাধীন')}}</span>
                                                @elseif($trim->status == 3)
                                                    <span class="badge rounded-pill bg-success">{{__('messages.অনুমোদিত')}}</span>
                                                @else
                                                    <span class="badge rounded-pill bg-danger">{{__('messages.সংশোধন')}}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('language-js')
    <script>
        $("#all-trim-select").on('click', function(){
            $('input:checkbox').not(this).prop('checked', this.checked);

            var x = document.getElementById("trim-button");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }

        });
        $(document).ready(function(){
            $('.myLink').trigger('click');
        });

        /*$(".audio-trigger").one('click', function (e){
            e.preventDefault();
            $('.myLink').trigger('click');
        })
*/
        /*$(window).on('load',function (){
            $('.myLink').trigger('click');
        })*/

        // alertify delete notification
        $(document).on('click', '.show_confirm', function(event) {
            var form =  $(this).closest("form");
            event.preventDefault();
            alertify.confirm('Whoops!', 'Are you sure you want to Delete?',
                function(){
                    form.submit();
                    // alertify.success('Ok')
                },
                function(){
                    // alertify.error('Cancel')
                });
        });



        var baseUrl = {!! json_encode(url('/')) !!}+ '/';
        var filePath = $('#audio').val();
        let audioPath = baseUrl+filePath;
        var buttons = {
            play: document.getElementById("btn-play"),
            pause: document.getElementById("btn-pause"),
            stop: document.getElementById("btn-stop")
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

        // daynamic anotaion trim audio
        function audioFile(data ){
            var baseUrl = {!! json_encode(url('/')) !!}+ '/';
            let audioPath = baseUrl+data.audio;
            let unique = data.audio;
            let uniqueID= unique.replace('uploads/trim-audio/', '');

            var buttons = {
                play: document.getElementById("play-pause"+uniqueID.slice(0, -4)),
            };

            var Spectrum = WaveSurfer.create({
                container: '#waveform'+uniqueID.slice(0, -4),
                waveColor: '#8eea8e',
                progressColor: "#CACACA",
                height: '60',
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

            Spectrum.load(audioPath);

            Spectrum.on('ready', updateTimer)
            Spectrum.on('audioprocess', updateTimer)
            Spectrum.on('seek', updateTimer)

            function updateTimer() {
                var formattedTime = secondsToTimestamp(Spectrum.getCurrentTime());
                $('#waveform-time-indicator .time'+uniqueID.slice(0, -4) ).text(formattedTime);
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

        }

    </script>

@endsection
