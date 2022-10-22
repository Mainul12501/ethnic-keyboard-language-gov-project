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
                        <li class="breadcrumb-item"><a href="{{route('admin.data_collections.index')}}">{{__('messages.তথ্য সংগ্রহ')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('messages.স্বতঃস্ফূর্ত') }}</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">

                <form action="{{route('admin.validation.spontaneous.word.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        @if($spontaneousAudio == !null)
                            <input type="hidden" id="d_c_spontaneous_id" name="d_c_spontaneous_id" value="{{$spontaneousAudio->dcSpontaneous->id}}">
                        @endif
                        <div class="col-md-6 col-sm-12">
                            @if($spontaneousAudio == null)
                                <h4 class="text-center"><small class="text-danger">{{__('messages.আপনার ডাটাটি এখনো সংগ্রহ হয় নাই')}} </small></h4>
                            @endif
                            <div class="row mb-3">
                                <label class="col-md-2 col-form-label" >{{__('messages.স্পিকার')}} </label>
                                <div class=" col-md-4  col-form-label">
                                    @if($spontaneousAudio == !null)
                                        <a class="text-decoration-none" href="{{route('admin.speakers.edit', $spontaneousAudio->speaker->id)}}" target="_blank">{{$spontaneousAudio->speaker->name}}</a>

                                    @endif
                                </div>
                                <label class="col-md-2 col-form-label" >{{__('messages.কালেক্টর')}} </label>
                                <div class=" col-md-4 col-form-label">
                                    @if($spontaneousAudio == !null)
                                        <a href="{{route('admin.data_collectors.show', $spontaneousAudio->collector->id )}}"  target="_blank" class="text-decoration-none">{{$spontaneousAudio->collector->name}}</a>
                                    @endif
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-md-2 col-sm-3 col-form-label" >{{__('messages.বিষয়')}} </label>
                                <div class=" col-md-10 col-sm-9 col-form-label">
                                    <div class="input-group">
                                        {{ $spontaneous->spontaneous->word }}
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-md-2 col-sm-3 col-form-label" >{{__('messages.অডিও')}} </label>
                                <div class=" col-md-10 col-sm-9 col-form-label">
                                    <input type="hidden" id="audio" value="">
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
                                <label class="col-md-2 col-sm-3 col-form-label" > {{__('messages.বাংলা')}}</label>
                                <div class=" col-md-10 col-sm-9 col-form-label">
                                    <textarea name="bangla" id="bangla" cols="20" rows="2" class="form-control @error('bangla') is-invalid @enderror" @if(Auth::user()->hasRole('Linguist')) readonly @endif>{{ ($spontaneousAudio == !null)? $spontaneousAudio->dcSpontaneous->bangla :'' }}</textarea>
                                    @error('bangla')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-2 col-sm-3 col-form-label" >{{__('messages.ইংরেজী')}} </label>
                                <div class=" col-md-10 col-sm-9 col-form-label">
                                    <textarea name="english" id="english" cols="20" rows="2" class="form-control @error('english') is-invalid @enderror" @if(Auth::user()->hasRole('Linguist')) readonly @endif>{{ ($spontaneousAudio == !null)? $spontaneousAudio->dcSpontaneous->english :'' }} </textarea>
                                    @error('english')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-2 col-sm-3 col-form-label" >{{__('messages.উচ্চারণ')}} </label>
                                <div class=" col-md-10 col-sm-9 col-form-label">
                                    <textarea name="transcription" id="spelling" cols="20" rows="2" class="form-control @error('transcription') is-invalid @enderror"  @if(Auth::user()->hasRole('Linguist')) readonly @endif >{{ ($spontaneousAudio == !null)? $spontaneousAudio->dcSpontaneous->transcription :'' }}</textarea>
                                    @error('transcription')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        @if(Auth::user()->hasRole(['Validator','Linguist']) && $spontaneousAudio == !null)
                            <div class="col-md-6 col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <ul class="nav nav-pills card-header-pills justify-content-between">
                                            <li class="nav-item">{{__('messages.যাচাইকারী')}}</li>
                                            <ul class="nav nav-pills card-header-pills me-2">
                                                <li class="nav-item me-2">
                                                    @if (!$spontaneous->taskAssign->validators->isEmpty() && $spontaneousAudio->dcSpontaneous->validator == null)
                                                        <div class="input-group">
                                                            <select class="form-select @error('validator_id') is-invalid @enderror " id="validator_id" name="validator_id">
                                                                @foreach($spontaneous->taskAssign->validators as $key => $validator)
                                                                    <option value="{{$validator->id}}">{{$validator->name}}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('validator_id')
                                                            <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror

                                                        </div>
                                                    @endif
                                                </li>
                                                <li class="nav-item">
                                                    <button class="btn btn-sm btn-success text-white validator-create" type="button" value="{{$spontaneous->task_assign_id}}" >
                                                        <svg class="icon me-2">
                                                            <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-plus')}}"></use>
                                                        </svg>{{__('messages.যাচাইকারী')}}
                                                    </button>
                                                </li>
                                            </ul>
                                        </ul>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-3">

                                            <div class=" col-md-6 col-sm-12 col-form-label">
                                                @if($spontaneousAudio->dcSpontaneous->validator == !null)
                                                    <div class="row ">
                                                        <label class="col-md-4 col-sm-3 col-form-label">{{__('messages.যাচাইকারী')}}</label>
                                                        <div class=" col-md-8 col-sm-9 col-form-label">
                                                            <input type="hidden" value="{{$spontaneousAudio->dcSpontaneous->validator->id}}" name="validator_id">
                                                            <a href="{{route('admin.speakers.edit', $spontaneousAudio->dcSpontaneous->validator->id)}}" target="_blank" class="text-decoration-none">{{$spontaneousAudio->dcSpontaneous->validator->name}}</a>

                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class=" col-md-6 col-sm-12 col-form-label">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="form-check">
                                                            <input class="form-check-input" id="NotAgree" type="radio" name="validation_status" value="0" {{($spontaneousAudio->dcSpontaneous->validation_status == "0")? "checked": ""}}>
                                                            <label class="form-check-label" for="NotAgree">
                                                                {{__('messages.একমত নই')}}
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" id="PartialAgree" type="radio" name="validation_status" value="1" {{ ($spontaneousAudio->dcSpontaneous->validation_status=="1")? "checked" : "" }}>
                                                            <label class="form-check-label" for="PartialAgree">
                                                                {{__('messages.আংশিক একমত')}}
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" id="Agree" type="radio" name="validation_status" value="2" {{ ($spontaneousAudio->dcSpontaneous->validation_status=="2")? "checked" : "" }}>
                                                            <label class="form-check-label" for="Agree">
                                                                {{__('messages.সম্পূর্ণ একমত')}}
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end mt-3">
                                    <button type="submit" class="btn btn-success  text-white" @if($spontaneous->taskAssign->validators->isEmpty()) data-toggle="tooltip" data-placement="top" title="you can not procceed without speaker" style="cursor:not-allowed; pointer-events: all" disabled @endif >{{__('messages.জমা দিন')}}</button>
                                </div>
                            </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Validator create modal-->
    @include('admin.speaker.validator-create')

@endsection
@section('language-js')
    <script>

        $("#validator_id option:first").attr("selected", "selected");

        // player added
        var baseUrl = window.location.origin+'/';
        var filePath = $('#audio-exist').val();
        let audioPath = baseUrl+filePath;
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
    <script>
        $( document ).ready(function() {
            @if (count($errors) > 0)
            $('#validatorForm').modal('show');
            @endif

        });
        $(document).ready(function (){
            $(document).on('click', '.validator-create', function (){
                var taskAssignID = $(this).val();
                var spontaneousID = $("#spontaneous_id").val();
                $('#validatorForm').modal('show');
                $.ajax({
                    type: "GET",
                    url: "{{ route('admin.speakers.validator.create')}}" + '/' + taskAssignID,
                    dataType: 'json',
                    data: {spontaneousID:spontaneousID},
                    success:function (response){
                        console.log(response)
                        $('#taskAssignID').val(taskAssignID);
                        $('#spontaneousID').val(spontaneousID);
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
