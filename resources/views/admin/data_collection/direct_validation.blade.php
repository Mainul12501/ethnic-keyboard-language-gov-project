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
                        <li class="breadcrumb-item active" aria-current="page">{{__('messages.নির্দেশিত') }}</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                <div class="alert alert-danger print-error-msg" style="display:none">
                    <ul></ul>
                </div>

                @foreach ($sentences as $sentenceItem)
                    <form action="" id="sentence_validation" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                @if($directedAudios->isEmpty())
                                    <h4 class="text-center"><small class="text-danger">{{__('messages.আপনার ডাটাটি এখনো সংগ্রহ হয় নাই')}} </small></h4>
                                @endif
                                <div class="row mb-3">
                                    @if(!$directedAudios->isEmpty())
                                        @foreach($directedAudios as $spvItem)
                                            <label class="col-md-2 col-form-label" >{{__('messages.স্পিকার')}} </label>
                                            <div class=" col-md-4  col-form-label">
                                                <a class="text-decoration-none" href="{{route('admin.speakers.edit', $spvItem->speaker->id)}}" target="_blank">{{$spvItem->speaker->name}}</a>
                                            </div>
                                            <label class="col-md-2 col-form-label" >{{__('messages.কালেক্টর')}} </label>
                                            <div class=" col-md-4 col-form-label">
                                                <a href="{{route('admin.data_collectors.show', $spvItem->collector->id )}}" class="text-decoration-none" target="_blank">{{$spvItem->collector->name}}</a>
                                            </div>
                                        @endforeach
                                    @endif

                                </div>
                                <div class="row">
                                    <label class="col-md-2 col-sm-3 col-form-label" >{{__('messages.বিষয়')}} </label>
                                    <div class=" col-md-10 col-sm-9 col-form-label">
                                        {{ $sentenceItem->topics->name }}
                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-md-2 col-sm-3 col-form-label" >{{__('messages.অডিও')}} </label>
                                    <div class=" col-md-10 col-sm-9 col-form-label">
                                        <input type="hidden"  id="audio" value="">
                                        @if ($sentenceItem->dcSentence == !null)
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
                                <div class="row mb-2">
                                    <label class="col-md-2 col-sm-3 col-form-label" > {{__('messages.বাংলা')}}</label>
                                    <div class=" col-md-10 col-sm-9 col-form-label">
                                        {{ $sentenceItem->sentence }}
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-md-2 col-sm-3 col-form-label" >{{__('messages.ইংরেজী')}} </label>
                                    <div class=" col-md-10 col-sm-9 col-form-label">
                                        {{ $sentenceItem->english}}
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-md-2 col-sm-3 col-form-label" >{{__('messages.উচ্চারণ')}} </label>
                                    <div class=" col-md-10 col-sm-9 col-form-label">
                                        @forelse ($directedAudios as $directedItem )
                                            <textarea name="transcription" id="spelling" cols="20" rows="2" class="form-control" @if(Auth::user()->hasRole('Linguist')) readonly @endif >{{ $directedItem->dcDirected->dcSentence->transcription}}</textarea>
                                        @empty
                                            <textarea name="transcription" id="spelling" cols="20" rows="2" class="form-control" @if(Auth::user()->hasRole('Linguist')) readonly @endif ></textarea>
                                        @endforelse

                                    </div>
                                </div>
                            </div>
                            @if(Auth::user()->hasRole(['Linguist','Validator']) && !$directedAudios->isEmpty())
                                <div class="col-md-6 col-sm-12">
                                    <div class="card">
                                        @foreach($directedAudios as $directedAudio)
                                            <div class="card-header">
                                                <ul class="nav nav-pills card-header-pills justify-content-between">
                                                    <li class="nav-item">{{__('messages.যাচাইকারী')}}</li>
                                                    <ul class="nav nav-pills card-header-pills me-2">
                                                        <li class="nav-item me-2">
                                                            @if (!$directedLanguages->taskAssign->validators->isEmpty() && $directedAudio->dcDirected->dcSentence->validator == null)
                                                                <div class="input-group">
                                                                    <select class="form-select @error('name') is-invalid @enderror" id="validator_id" name="validator_id">
                                                                        @foreach($directedLanguages->taskAssign->validators as $key => $validator)
                                                                            <option value="{{$validator->id}}">{{$validator->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    @error('validator_id')
                                                                    <span class="invalid-feedback">
                                                                        <strong>{{$message}}</strong>
                                                                    </span>
                                                                    @enderror

                                                                </div>
                                                            @endif
                                                        </li>
                                                        <li class="nav-item">
                                                            <button class="btn btn-sm btn-success text-white validator-create" type="button" value="{{$directedLanguages->task_assign_id}}" >
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
                                                    <input type="hidden" id="d_c_directed_sentence_id" name="d_c_directed_sentence_id" value="{{$directedAudio->dcDirected->dcSentence->id}}">
                                                    <div class=" col-md-6 col-sm-12 col-form-label">
                                                        @if($directedAudio->dcDirected->dcSentence->validator == !null)
                                                            <div class="row ">
                                                                <label class="col-md-4 col-sm-3 col-form-label">{{__('messages.যাচাইকারী')}}</label>
                                                                <div class=" col-md-8 col-sm-9 col-form-label">
                                                                    <input type="hidden" id="validator_id" name="validator_id" value="{{$directedAudio->dcDirected->dcSentence->validator->id}}">
                                                                    <a href="{{route('admin.speakers.edit', $directedAudio->dcDirected->dcSentence->validator->id)}}" target="_blank" class="text-decoration-none">{{$directedAudio->dcDirected->dcSentence->validator->name}}</a>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class=" col-md-6 col-sm-12 col-form-label">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="form-check">
                                                                    <input class="form-check-input @error('validation_status') is-invalid @enderror" id="NotAgree" type="radio" name="validation_status" value="0" {{($directedAudio->dcDirected->dcSentence->validation_status == "0")? "checked": ""}}>
                                                                    <label class="form-check-label" for="NotAgree">
                                                                        {{__('messages.একমত নই')}}
                                                                    </label>
                                                                    @error('validation_status')
                                                                    <span class="invalid-feedback">
                                                                        <strong>{{$message}}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input @error('validation_status') is-invalid @enderror" id="PartialAgree" type="radio" name="validation_status" value="1" {{ ($directedAudio->dcDirected->dcSentence->validation_status=="1")? "checked" : "" }}>
                                                                    <label class="form-check-label" for="PartialAgree">
                                                                        {{__('messages.আংশিক একমত')}}
                                                                    </label>
                                                                    @error('validation_status')
                                                                    <span class="invalid-feedback">
                                                                        <strong>{{$message}}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input @error('validation_status') is-invalid @enderror" id="Agree" type="radio" name="validation_status" value="2" {{ ($directedAudio->dcDirected->dcSentence->validation_status=="2")? "checked" : "" }}>
                                                                    <label class="form-check-label" for="Agree">
                                                                        {{__('messages.সম্পূর্ণ একমত')}}
                                                                    </label>
                                                                    @error('validation_status')
                                                                    <span class="invalid-feedback">
                                                                        <strong>{{$message}}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            @endif
                        </div>
                        @if(!$directedAudios->isEmpty())
                        <div class="text-end">
                            <a href="{{ $sentences->nextPageUrl() != null ? $sentences->nextPageUrl() : ''  }}" style="display: none" id="next_page">z</a>
                            @if($sentences->previousPageUrl() != null)
                                <a href="{{ $sentences->previousPageUrl() }}" class="btn btn-success text-white">Previous</a>
                            @endif
                            <button type="submit" class="btn btn-success text-white" id="save_validation_form" @if($directedLanguages->taskAssign->validators->isEmpty()) data-toggle="tooltip" data-placement="top" title="you can not procceed without Validator" style="cursor:not-allowed; pointer-events: all" disabled @endif>{{ $sentences->nextPageUrl() != null ? 'Next' : 'Submit' }}</button>
                        </div>
                        @endif
                    </form>
                @endforeach
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
        var baseUrl = {!! json_encode(url('/')) !!}+ '/';
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
        // From submit for validation
        $('#sentence_validation').on('submit',function(e){
            e.preventDefault();
            page = $('#next_page').attr('href');
            submit = document.getElementById("save_validation_form").innerHTML;
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                type:'post',
                url: "{{ route('admin.validation.directed.topic.store') }}",
                data: $('#sentence_validation').serialize(),
                async :true,
                success: function (data) {
                    if($.isEmptyObject(data.error)){
                        toastr.success(data.msg);
                        if (page == undefined) {
                            window.location.href = document.location.origin;
                        }else if(submit == 'Submit'){
                            window.location.href =  document.location.origin;
                        } else{
                            window.location.href = $('#next_page').attr('href');
                        }
                    }else{
                        printErrorMsg(data.error);

                    }

                },
            });
            function printErrorMsg (msg) {
                $(".print-error-msg").find("ul").html('');
                $(".print-error-msg").css('display','block');
                $.each( msg, function( key, value ) {
                    $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                });
                setTimeout(function() {
                    $('.print-error-msg').css('display', 'none');
                }, 5000);
            }

        });

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
            // console.log(disID);
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
            // console.log(upazilaID);
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
            dropdownParent: $("#validatorForm"),
            width: '100%',
            placeholder: "{{__('messages.জেলা নির্বাচন করুন')}}",
            allowClear: true
        });
        $('#upazila_id').select2({
            dropdownParent: $("#validatorForm"),
            width: '100%',
            placeholder: "{{__('messages.উপজেলা নির্বাচন করুন')}}",
            allowClear: true
        });
        $('#union_id').select2({
            dropdownParent: $("#validatorForm"),
            width: '100%',
            placeholder: "{{__('messages.ইউনিয়ন নির্বাচন করুন')}}",
            allowClear: true
        });

    </script>


@endsection
