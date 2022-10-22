@extends('layouts.app')
@section('content')
    <div class="container-fluid pl-0 px-0">
        <div class="card mb-3">
            <div class="card-header">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.data_collections.index')}}">{{__('messages.তথ্য সংগ্রহ')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('বিচারাধীন ট্রিমিং')}}</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                {{-- <input type="hidden" id="parent_audio" value="{{$audio->id}}"> --}}
                @if (isset($audio->directed))
                    <input type="hidden" id="collectorID" value="{{$audio->dcDirected->collection->collector->id}}">
                @else
                    <input type="hidden" id="collectorID" value="{{$audio->collection->collector->id}}">
                @endif
                <div class="row">
                    <div class="col-md-7 col-sm-12">
                        @if (isset($audio->directed))
                            <input type="hidden" id="audioType" value="directed">

                            <div class="row">
                                <label class="col-md-3 col-sm-3 col-form-label" >{{__('messages.বিষয়')}} </label>
                                <div class=" col-md-9 col-sm-9 col-form-label">
                                    {{$audio->dcDirected->topic->name}}
                                </div>
                            </div>
                        @endif
                        <div class="row">
                            <label class="col-md-3 col-sm-3 col-form-label" >{{__('messages.সংগৃহীত')}} </label>
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
                                    {{$audio->directed->sentence}}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-3 col-sm-3 col-form-label" >{{__('messages.ইংরেজী')}} </label>
                                <div class=" col-md-9 col-sm-9 col-form-label">
                                    {{$audio->directed->english}}
                                </div>
                            </div>
                        @else
                            <input type="hidden" id="audioType" value="spontaneous">
                            <div class="row mb-2">
                                <label class="col-md-3 col-sm-3 col-form-label" >{{__('messages.কীওয়ার্ডঃ')}} </label>
                                <div class=" col-md-9 col-sm-9 col-form-label">
                                    {{ $audio->spontaneous->word }}
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
                <h6>{{__('messages.বিচারাধীন ট্রিমিং এর তালিকা')}} </h6>
            </div>
            <div class="card-body">
                <div>
                    <div class="table-responsive">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <form action="{{route('admin.send.trim.approved', $audio->id)}}" method="post" >
                                    @csrf
                                    @method("PUT")
                                    <table class="table table-hover table-bordered" id="trim-collection">
                                        @if($audio->d_c_directed_id != null)
                                            <input class="form-check-input" id="d_c_directed_sentences_id" name ="d_c_directed_sentences_id"  type="hidden" value="{{$audio->id}}">
                                        @else
                                            <input class="form-check-input" id="d_c_spontaneouses_id" name ="d_c_spontaneouses_id"  type="hidden" value="{{$audio->id}}">
                                        @endif
                                        <thead class="table-dark">
                                        <tr>

                                            <th scope="col" style="width: 9rem;">
                                                @if($audio->status != 2)
                                                <input class="form-check-input" id="all-trim-select"  type="checkbox">
                                                @endif
                                                {{__('messages.সব নির্বাচন করুন')}}

                                            </th>
                                            <th scope="col" style="width: 5rem;">{{__('messages.ক্রমিক নং')}}</th>
                                            <th scope="col">{{--<button class="btn btn-sm btn-dark audio-trigger">--}}{{__('messages.অডিও ট্রিম')}}{{--</button>--}}</th>
                                            <th scope="col">{{__('messages.বাংলা')}} </th>
                                            <th scope="col">{{__('messages.ইংরেজী')}}</th>
                                            <th scope="col">{{__('messages.উচ্চারণ')}} </th>
                                            <th scope="col">{{__('messages.স্ট্যাটাস')}} </th>
                                            <th scope="col" class="text-center">{{__('messages.অ্যাকশন')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody id="tbody">
                                        @foreach($trims as $key =>$trim)
                                            <tr>
                                                <td>

                                                    <input class="form-check-input trim-checked" type="checkbox" name="status[]" value="{{$trim->id}}" @if($trim->status ==2)disabled @endif>
                                                </td>
                                                <td>{{++$key}}</td>
                                                <td class="align-middle text-center" >
                                                    {{-- <button style="display: none;" class="myLink" onclick="audioFile({{ $trim }})"></button>
                                                    <div id="waveform{{substr(str_replace('uploads/trim-audio/', '', $trim->audio), 0, -4)}}"></div>
                                                    <div id="waveform-time-indicator" class="justify-content-between">
                                                        <input type="button" id="play-pause{{substr(str_replace('uploads/trim-audio/', '', $trim->audio), 0, -4)}}" value="Play"/>
                                                        <span id="total-time" class="time{{substr(str_replace('uploads/trim-audio/', '', $trim->audio), 0, -4)}}">00:00:00</span>

                                                    </div> --}}
                                                    <audio src="{{ asset($trim->audio) }}" controls>
                                                        <source src="{{ asset($trim->audio) }}" type="audio/*">
                                                   </audio>
                                                </td>
                                                <td>{{$trim->bangla}}</td>
                                                <td>{{$trim->english}}</td>
                                                <td>{{$trim->transcription}}</td>
                                                @if($trim->status == 1)
                                                    <td class="align-middle">
                                                        <span class="badge rounded-pill bg-warning">{{__('messages.বিচারাধীন')}}</span>
                                                    </td>
                                                @elseif($trim->status == 2)
                                                    <td class="align-middle">
                                                        <span class="badge rounded-pill bg-danger">{{__('messages.সংশোধন')}}</span>
                                                    </td>
                                                @endif
                                                @if($trim->status == 1)
                                                    <td class="align-middle">
                                                        <div class="d-grid gap-2 d-md-flex justify-content-center">
                                                            <button class="btn btn-purple btn-sm edit-btn" type="button" value="{{$trim->id}}">
                                                                {{__('messages.রিভার্ট')}}
                                                            </button>
                                                            {{--<form action="{{route('del-trim-audio', $trim->id)}}" method="post">
                                                                @csrf
                                                                <button class="btn btn-danger btn-sm show_confirm">
                                                                    <svg class="icon  text-white">
                                                                        <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-trash')}}"></use>
                                                                    </svg>
                                                                </button>
                                                            </form>--}}
                                                        </div>
                                                    </td>
                                                @endif

                                            </tr>

                                        @endforeach
                                        </tbody>
                                    </table>
                                    <div class="row " id="trim-button" style="display: none;">
                                        <div class="col-12 text-end">
                                            <button class="btn btn-success text-white" type="submit">
                                                <svg class="icon  text-white">
                                                    <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-check')}}"></use>
                                                </svg>
                                                {{__('messages.অনুমোদন')}}
                                            </button>
                                        </div>
                                    </div>
                               </form>
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
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- revert  modal-->
    @include('admin.data_collection.revert')

@endsection
@section('language-js')
    <script>
        $(document).on('change', "input[type='checkbox'].trim-checked", function() {
            var a = $("input[type='checkbox'].trim-checked");
            if(a.length == a.filter(":checked").length){
                $('input:checkbox').not(this).prop('checked', this.checked);
                var x = document.getElementById("trim-button");
                if (x.style.display === "none") {
                    x.style.display = "block";
                } else {
                    x.style.display = "none";
                }
            }
            if (a.length !== a.filter(":checked").length){
                var x = document.getElementById("trim-button");
                x.style.display = "none";
            }

        });

        $("#all-trim-select").on('click', function(){
            $('input:checkbox').not(this).prop('checked', this.checked);

            var a = $("input[type='checkbox'].trim-checked");

            if(a.length == a.filter(":checked").length) {
                var x = document.getElementById("trim-button");
                if (x.style.display === "none") {
                    x.style.display = "block";
                } else {
                    x.style.display = "none";
                }
            }
            if (a.length !== a.filter(":checked").length){
                var x = document.getElementById("trim-button");
                x.style.display = "none";
            }

        });

        $(document).ready(function (){
            $(document).on('click', '.edit-btn', function (){
                var trimID = $(this).val();
                var ID = $('#parent_audio').val();
                var Type = $('#audioType').val();
                var collectorID = $('#collectorID').val();

                $('#trimEditForm').modal('show');

                $.ajax({
                    type: "GET",
                    url: "/admin/revert/"+trimID,
                    dataType: 'json',
                    data: {ID:ID, Type:Type, collectorID:collectorID},
                    success:function (response){
                        console.log(response)
                        $('#trimID').val(trimID);
                        $('#ID').val(ID);
                        $('#audio_type').val(Type);
                        $('#collector_id').val(collectorID);

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
        /*$(document).ready(function(e){
              e.preventDefault();
            e.stopImmediatePropagation();
            $('.myLink').trigger('click');
        });*/

        /*$(".audio-trigger").one('click', function (event){
            event.preventDefault();
            event.stopImmediatePropagation();
            $('.myLink').trigger('click');
        })*/
        /*$("form").submit(function(e) {
            e.preventDefault();
            // $('form').unbind('submit').submit();
        });*/

        // $(window).on('load', function (event){
        //     event.preventDefault();
        //     /*   event.stopPropagation();
        //        event.stopImmediatePropagation();*/
        //     // $('.myLink').triggerHandler('click');
        //     // $('.myLink').trigger('click');
        // })

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
