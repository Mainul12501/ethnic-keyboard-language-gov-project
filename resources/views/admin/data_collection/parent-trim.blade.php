@extends('layouts.app')

@section('front-css')
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-ios.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intro.js/2.9.3/introjs.min.css">
@endsection

@section('content')
    <div class="container-fluid pl-0 px-0">
        <div class="card mb-3">
            <div class="card-header">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="">{{__('messages.তথ্য সংগ্রহ')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('অডিও ট্রিমিং')}}</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-7 col-sm-12">
                        @if (isset($audio->directed))
                            <input type="hidden" id="audioType" value="directed">
                            <div class="row">
                                <label class="col-md-3 col-sm-3 col-form-label" >{{__('messages.বিষয়')}} </label>
                                <div class=" col-md-9 col-sm-9 col-form-label">
{{--                                    {{$audio->dcDirected->topic->name}}--}}
                                    {{ $audio->directed->topics->name }}
                                </div>
                            </div>
                        @endif
                        <div class="row">
                            <label class="col-md-3 col-sm-3 col-form-label" >{{__('messages.অডিও')}} </label>
                            <div class=" col-md-9 col-sm-9 col-form-label">
                                <input type="hidden" id="audio" value="{{$audio->audio}}">
                                <input type="hidden" id="audio_blob" value="{{$audio->audio_blob}}">
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
                                <label class="col-md-3 col-sm-3 col-form-label" >{{__('messages.অনুবাদ')}} </label>
                                <div class=" col-md-9 col-sm-9 col-form-label">
                                    {{$audio->directed->english}}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-3 col-sm-3 col-form-label" >{{__('messages.উচ্চারণ')}} </label>
                                <div class=" col-md-9 col-sm-9 col-form-label">
                                    {{$audio->transcription}}
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
                            <div class="row mb-2">
                                <label class="col-md-3 col-sm-3 col-form-label" > {{__('messages.বাংলা')}}</label>
                                <div class=" col-md-9 col-sm-9 col-form-label">
                                    {{$audio->bangla}}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-3 col-sm-3 col-form-label" >{{__('messages.অনুবাদ')}} </label>
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

                    </div>
                </div>
                <div class="row">
                    {{--audiofly test start--}}
                    <div class="col-md-12 mb-4">
                        <div class="card card-body">
                            <div class="w3-container">
                                <br>
                                <div id="waveform" class="w3-border w3-round-large"
                                     data-step="3" data-intro="Click and drag to select section">
                                </div>
                                <br>
                                <div class="w3-row">
                                    <div class="w3-half w3-container w3-hide" id="audio-buttons">
                                        <button class="w3-button w3-border w3-border-green w3-round-xlarge" onClick="playAndPause()">
                                            <i id="play-pause-icon" class="fa fa-play"></i>
                                        </button>

                                        <b id="time-current">0.00</b> / <b id="time-total">0.00</b>
                                    </div>
                                    <div class="w3-half w3-container text-end">

                                        {{-- <input id="audio-file" type="file" onChange="loadAudio()"
                                               data-step="2" data-intro="Select a MP3 File"> --}}
                                        <span id="trim_audio" class="btn btn-success trim text-white" onClick="trimming()">{{__('messages.ট্রিম অডিও')}}</span>
                                        <div id="myImg">

                                        </div>
                                    </div>
                                </div>
                                {{--  <hr>
                                  <div data-step="4" data-intro="Would you like to know how to merge tracks. Click Next.">
                                      <table class="w3-table-all w3-card-4" id="audio-tracks"
                                             data-step="5" data-intro="Select atleast 2 checkboxes for merging. Click Next.">
                                          <thead>
                                          <tr class="w3-border w3-border-teal --}}{{--w3-text-teal--}}{{--">
                                              <th></th>
                                              <th>Start</th>
                                              <th>End</th>
                                              <th>Play</th>
                                              <th>Download</th>
                                              <th>Action</th>
                                          </tr>
                                          </thead>
                                          <tbody></tbody>
                                          <tfoot></tfoot>
                                      </table>
                                  </div>--}}
                                <br>
                                <div id="merge-option" class="w3-hide">
                                    <br><br>
                                    <div class="w3-row w3-hide" id="merged-track-div">
                                        <b class="w3-col l1 w3-text-olive"><i>Merged Audio : </i></b>
                                        <audio controls="controls" class="w3-col l11" id="merged-track">
                                            <source src="" type="">
                                        </audio>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--audiofly test end--}}
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>
                        {{--<form action="{{ route('trim-audio') }}" method="post" id="trimAudio">
                            @csrf--}}
                        <div class="row">
                            <div class="col-md-7 col-sm-12">
                                <div data-step="4" data-intro="Would you like to know how to merge tracks. Click Next.">
                                    <table class="w3-table-all w3-card-4" id="audio-tracks"
                                           data-step="5" data-intro="Select atleast 2 checkboxes for merging. Click Next.">
                                        <thead>
                                        <tr class="w3-border w3-border-teal w3-text-teal">
                                            <th></th>
                                            <th>{{__('messages.শুরুর সময়')}}</th>
                                            <th>{{__('messages.শেষের সময়')}}</th>
                                            <th>{{__('messages.অডিও শুনুন')}}</th>
                                            {{--<th>Download</th>--}}
                                            <th>{{__('messages.অ্যাকশন')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody id="tableBody"></tbody>
                                        <tfoot></tfoot>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-5 col-sm-12">
                                <form action="{{ route('admin.replace-parent-trim-audio') }}" method="post" id="trimAudio">
                                    @csrf
                                    <div class="">
                                        {{-- <audio src="{{ asset($audio->audio) }}" controls>
                                            <source src="{{ asset($audio->audio) }}" type="audio/*">
                                        </audio> --}}
                                        <div id="form-hidden">
                                            <input type="hidden" name="audio_id" value="{{ $audio->id }}" />
                                            <input type="hidden" name="directed_id" value="{{ isset($audio->directed) ? $audio->directed->id : '' }}" />
                                        </div>
                                        <input type="hidden" name="type" value="{{ $type }}">
                                        <input type="hidden" name="spontaneous_id" value="{{ isset($audio->spontaneous) ? $audio->spontaneous_id : '' }}" />
                                        <input type="hidden" name="skip_time" id="skipTimeValue{{ $audio->id }}">
                                        <input type="hidden" name="audio_duration" id="audioDurationValue{{ $audio->id }}">
                                        <input type="hidden" id="trimTableId">
                                        <input type="hidden" name="is_directed" value="{{ isset($audio->directed) ? 1 : 0 }}">
                                        <input type="hidden" name="is_spontaneous" value="{{ isset($audio->spontaneous) ? 1 : 0 }}">
                                    </div>
                                    {{-- <div class="row mb-3">
                                        <label for="">{{__('messages.ট্রিম শুরুর সময়')}}</label>
                                        <div class="input-group ">
                                            <input type="text" name="" placeholder="00:00" id="skipTime{{ $audio->id }}" class="form-control start-time-input" />
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="">{{__('messages.ট্রিম শেষের সময়')}}</label>
                                        <div class="input-group ">
                                            <input type="text" name="" placeholder="00:00" id="audioDuration{{ $audio->id }}" class="form-control end-time-input" />
                                        </div>
                                    </div> --}}
                                    <div class="row mb-3">
                                        {{-- <label for="">choose options<span class="text-danger">*</span></label> --}}
                                        <div class="input-group ">
                                            <label for=""><input type="radio" name="replaceInput" value="1" id="replaceInput">&nbsp;{{ 'অডিও পরিবর্তন' }}<span class="text-danger">*</span></label>
                                        </div>

                                        <span class="text-danger error-text bangla_err"></span>
                                    </div>

                                    <div class="float-end mt-3">
                                        <input type="submit"  class="btn  btn-success trim text-white" data-id="{{ $audio->id }}" onclick="return confirm('আপনি কি আগের অডিওটি পরিবর্তন করে নতুন অডিওটি সেভ করতে চান ?একবার নতুন  অডিওটি সেভ করলে আগের অডিওটি মুছে যাবে । আপনি কি নিশ্চিত যে নতুন অডিওটি সেভ করবেন ?')" value="{{__('messages.জমা দিন')}}">
                                    </div>
                                </form>
                            </div>
                        </div>
                        {{-- </form>--}}
                    </div>
                </div>
            </div>
        </div>

    </div>



@endsection
@section('language-js')
    {{--    audiofy scripts start--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wavesurfer.js/1.2.3/wavesurfer.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wavesurfer.js/1.2.3/plugin/wavesurfer.regions.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intro.js/2.9.3/intro.min.js"></script>
    {{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/sass.js/0.6.3/worker.js"></script>--}}
    <script src="{{ asset('/') }}assets/audiofy/actionhelper.js"></script>
    <script src="{{ asset('/') }}assets/audiofy/audio.js"></script>
    {{--audiofy scripts end--}}

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



        const timeString = '23:54:43';
        const other = '12:30:00';
        const withoutSeconds = '10:30';
        function countSeconds (str) {
            const [ mm = '0', ss = '0'] = (str || '0:0').split(':');
            const minute = parseInt(mm, 10) || 0;
            const second = parseInt(ss, 10) || 0;
            return  (minute*60) + (second);
        }
        var baseUrl = {!! json_encode(url('/')) !!}+ '/';
        $(document).ready(function (){
            $('.audioPlayer').each(function (){
                var audioId = $(this).attr('data-id');
                var audioUrl = $(this).attr('data-audio-url');
                $("#playAudio"+audioId).jsRapAudio({
                    src: audioUrl,
                    autoplay:false,
                    controls:true,
                    capHeight:4,
                    capSpeed:0.6,
                    frequency:0.7,
                });
            })
        })
        var audioId = {!! json_encode($audio->id) !!}
        $(document).on('click', 'input[data-checkbox="true"]', function (){
            var tdId = $(this).attr('data-id');
            $('#skipTime'+audioId).val('0:'+Math.round($('#'+tdId+1).text()));
            $('#audioDuration'+audioId).val('0:'+Math.round($('#'+tdId+2).text()));
            $('#trimTableId').val(tdId);
        })
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
        $(document).ready(function() {
            $(".trimx").click(function(e){
                // alert('fuck');
                e.preventDefault();
                var audioId = $(this).data('id');
                var skipTime = $('#skipTime'+audioId).val();
                var x = countSeconds(skipTime);
                $('#skipTimeValue'+audioId).val(countSeconds(skipTime));
                var audioTrim = $('#audioDuration'+audioId).val();
                var y = countSeconds(audioTrim);
                $('#audioDurationValue'+audioId).val(y-x);
                var audio_id = $('input[name="audio_id"]').val();
                var directed_id = $('input[name="directed_id"]').val();
                var spontaneous_id = $('input[name="spontaneous_id"]').val();
                var skip_time = $('input[name="skip_time"]').val();
                var audio_duration = $('input[name="audio_duration"]').val();
                var replaceAudioRadioButton = $('input[name="replaceInput"]:checked').val();

                // var english = $('textarea[name="english"]').val();
                // var transcription = $('textarea[name="transcription"]').val();
                if (replaceAudioRadioButton == 1)
                {
                    var trimRowId = $('#trimTableId').val();
                    var get_audio_base64 = $('#trim_base64').val();
                    $('#loader').show();
                    $.ajax({
                        url: "{{ route('admin.replace-parent-trim-audio') }}",
                        method: 'POST',
                        dataType: 'JSON',
                        data: {audio_id:audio_id,directed_id:directed_id,spontaneous_id:spontaneous_id,skip_time:skip_time,audio_duration:audio_duration,audio_file:get_audio_base64},
                        success: function (data) {
                            console.log(data);
                            if($.isEmptyObject(data.error)){
                                $('#replaceInput').val('');
                                // $('#englishInput').val('');
                                // $('#transcriptionInput').val('');
                                // $('input[name="audio_id"]').val('');
                                $('.start-time-input').val('');
                                $('.end-time-input').val('');
                                $('#trim_base64').remove();
                                $('#'+trimRowId).remove();
                                setTimeout(function() {
                                    $(".error-text").empty();
                                }, 1000);
                                toastr.success('audio has been trimmed successfully.');
                            }else{
                                printErrorMsg(data.error);
                            }
                        },
                        complete: function(){
                            $('#loader').hide();
                        }
                        /*error: function (err) {
                            toastr.error('Something went wrong, please try again.');
                        }*/
                    })
                }

            })
            function printErrorMsg (msg) {
                $.each( msg, function( key, value ) {
                    $('.'+key+'_err').text(value);
                });
            }
        } );

        /*   $(window).on('load',function (event){
               // event.preventDefault();
               // event.stopImmediatePropagation();
               // $('.myLink').trigger('click');
               setTimeout(function(event) {
                   event.preventDefault();
                   // event.stopImmediatePropagation();
                   $('.myLink').trigger('click');
               }, 1000);
           })*/


        $(document).ready(function(event) {
            var audioID = $('input[name="audio_id"]').val();
            var Type = $('#audioType').val();
            console.log(audioID)
            console.log(Type)
            function ajax(){
                $('#loader').show();
                $.ajax({
                    type : 'GET',
                    dataType: "json",
                    url  : "{{ route('get-trim-audios') }}",
                    data : {id: audioID, type:Type},
                    success : function (res) {
                        table_audios_row(res);
                    },
                    complete: function(){
                        $('#loader').hide();
                    },
                    error : function(error){
                        console.log(error);
                    }
                });
            }
            ajax();
            $(document).on('click','.trim', function() {

                setTimeout(function(e) {
                    ajax();
                }, 3000);

            });
            // table row with ajax
            function table_audios_row(res){
                let htmlView = '';
                if(res.audios.length <= 0){
                    htmlView+= `
                    <tr>
                      <td colspan="4">No data.</td>
                     </tr>`;
                }
                for(let i = 0; i < res.audios.length; i++){
                    htmlView += `
          <tr>
             <td><input class="form-check-input trim-checked" type="checkbox" name="status[]" value="`+res.audios[i].id+`"></td>
             <td>`+ (i+1) +`</td>
             <td class="align-middle text-center" >
                <audio src="`+baseUrl+res.audios[i].audio+`" controls>
                     <source src="`+baseUrl+res.audios[i].audio+`" type="audio/*">
                </audio>
             </td>
             <td>`+res.audios[i].bangla+`</td>
              <td>`+res.audios[i].english+`</td>
              <td>`+res.audios[i].transcription+`</td>`
                    if(res.audios[i].comment == null){
                        htmlView += `<td></td>`
                    }else {
                        htmlView += `<td>`+res.audios[i].comment+`</td>`

                    }
                    htmlView += `
                <td class="align-middle">
                    <form action="`+baseUrl+`delete-trim-audios/`+res.audios[i].id+`" method="post">
                    @csrf
                    <button class="btn btn-danger btn-sm show_confirm">
                    <svg class="icon  text-white">
                        <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-trash')}}"></use>
                        </svg>
                        </button>
                    </form>
                </td>

            </tr>
            `;
                }
                $('#tbody').html(htmlView);
            }

            /*setTimeout(function(e) {
                $('.myLink').trigger('click');
            }, 5000);*/
        });



        /* $("form").submit(function(e) {
             e.preventDefault();
             // $('form').unbind('submit').submit();
         });*/
        /*  $(window).on('load',function (event){

              event.preventDefault();
              // event.stopImmediatePropagation();
              $('.myLink').trigger('click');
          })*/

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
        function audioFile(audio ){
            var baseUrl = {!! json_encode(url('/')) !!}+ '/';
            let audioPath = baseUrl+'uploads/trim-audio/'+audio+'.mp3';
            var buttons = {
                play: document.getElementById("play-pause"+audio),
            };
            var Spectrum = WaveSurfer.create({
                container: '#waveform'+audio,
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
                $('#waveform-time-indicator .time'+audio).text(formattedTime);
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
        $(window).on('load',function (){
            // loadAudioFromDb($('#audioDb').val());
            // var audioUrl = $('#audioDb').val();
            var audioUrl = baseUrl+{!! json_encode($audio->audio) !!};
            var rootUrl = {!! json_encode(asset('/')) !!};
            // window.location.href = audioUrl;
            /* var link = document.createElement('a');
             document.body.appendChild(link);
             link.href=audioUrl;
             link.download= "file_"+new Date() +'.mp3';
             link.click();
             link.remove();*/
        })

    </script>

    <!-- Audio Trim Scripts -->
    <script>
        function trimming(){

            var  get_file = $('#audio_blob').val();
            var  blob_file = urlB64ToUint8Array(get_file)

            loadAudio(blob_file);
        }

        function urlB64ToUint8Array(base64){

            var arr = base64.split(',');

            if (arr.length != 2) {

                bstr = atob(base64);

                var ourputArray = new Uint8Array(bstr.length);

                for (let i = 0; i < bstr.length; i++) {

                    ourputArray[i] = bstr.charCodeAt(i);
                }

                const blob = new Blob([ourputArray], {type: 'audio/mp3'});

                return blob;
            }else{

                mime = arr[0].match(/:(.*?);/)[1];
                bstr = atob(arr[1]);

                var ourputArray = new Uint8Array(bstr.length);

                for (let i = 0; i < bstr.length; i++) {

                    ourputArray[i] = bstr.charCodeAt(i);
                }

                const blob = new Blob([ourputArray], {type: 'audio/mp3'});

                return blob;
            }

        }
    </script>
    <style>
        .show-me {
            display: contents!important;
        }
    </style>
    <script>
        $(document).on('click',function () {
            $('.w3-table-all tbody tr').css('display', 'none')
            $('.w3-table-all>tbody>tr:first').addClass('show-me');
        })
    </script>
    <script>
        // $(document).on('click', '.w3-table-all>tbody>tr:first>input', function () {
        //     alert('This will replace existing audio.');
        // });
        $(document).on('click', '#replaceInput', function () {
            alert('আপনি কি আগের অডিও টি পরিবর্তন করে নতুন অডিওটি সেভ করতে চান ?');
        });

        // monu code starts - commented for debug
        $(document).on('submit','#trimAudio', function () {
            // var replaceAudioRadioButton = $('input[name="replaceInput"]:checked').val();
            if(!$('#replaceInput').is(':checked'))
            {
                event.preventDefault();
                // return false;
            }
        })
        // monu code ends - commented for debug
    </script>
@endsection
