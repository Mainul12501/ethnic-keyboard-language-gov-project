@extends('layouts.app')

@section('title', '')

@section('content')
    <div class="container-fluid px-0">
        <div class="card mb-3">
            <div class="card-header">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item" data-toggle="tooltip" data-placement="top" title="Back">
                            <a class="btn btn-sm btn-success" href="{{route('admin.spontaneous.language.tasks.list', $firstItem->collection->task_assign_id)}}">
                                <i class="fas fa-arrow-left text-white"></i>
                            </a>
                        </li>

                        <li class="breadcrumb-item">{{__('messages.স্বতঃস্ফূর্ত')}}</li>
                        <li class="breadcrumb-item" data-toggle="tooltip" data-placement="top" title="Language" >
                            {{$firstItem->collection->language->name}}
                        </li>
                        <li class="breadcrumb-item" data-toggle="tooltip" data-placement="top" title="District">
                            {{$firstItem->collection->district->name}}
                        </li>
                        <li class="breadcrumb-item" data-toggle="tooltip" data-placement="top" title="Topic">
                            {{$firstItem->spontaneous->word}}
                        </li>
                        <li class="breadcrumb-item" data-toggle="tooltip" data-placement="top" title="Group">
                            {{isset($firstItem->collection->taskAssign->group)? $firstItem->collection->taskAssign->group->name: ''}}
                        </li>
                        <li class="breadcrumb-item" data-toggle="tooltip" data-placement="top" title="Collector">
                            <a href="{{route('admin.data_collectors.show', $firstItem->collection->collector->id )}}" class="text-decoration-none" target="_blank">
                                {{$firstItem->collection->collector->name}}
                            </a>

                        </li>
                        <li class="breadcrumb-item" data-toggle="tooltip" data-placement="top" title="Speaker">
                            <a href="{{route('admin.speakers.edit', $firstItem->collection->speaker->id)}}" class="text-decoration-none" target="_blank">
                                {{$firstItem->collection->speaker->name}}
                            </a>

                        </li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="directedTopic">
                        <thead class="table-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{__('messages.বাংলা')}}</th>
                            <th scope="col">{{__('messages.অনুবাদ')}}</th>
                            <th scope="col">{{__('messages.উচ্চারণ')}}</th>
                            <th scope="col">{{__('messages.অডিও')}}</th>
                            <th scope="col">{{__('messages.যাচাইকৃত')}}</th>
                            <th scope="col">{{__('messages.স্ট্যাটাস')}}</th>
                            @can('Audio-Validation-Name')
                            <th scope="col">{{__('messages.অ্যাকশন')}}</th>
                            @endcan
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($spontaneousTrimLists as $key=> $spontaneousTrimItem)
                            <tr>
                                <th scope="row">{{  ++ $key }}</th>
                                <td class="">
                                    {{$spontaneousTrimItem->bangla}}
                                </td>
                                <td class="">
                                        {{$spontaneousTrimItem->english}}
                                </td>
                                <td class="">
                                        {{$spontaneousTrimItem->transcription}}
                                </td>
                                <td class="">
                                    @if(isset($spontaneousTrimItem))
                                        <button style="display: none;" class="myLink" onclick="audioFile({{ $spontaneousTrimItem}})"></button>
                                        <div id="waveform{{substr(str_replace('uploads/trim-audio/', '', $spontaneousTrimItem->audio), 0, -4)}}"></div>
                                        <div id="waveform-time-indicator" class="justify-content-between">
                                            <input type="button" id="play-pause{{substr(str_replace('uploads/trim-audio/', '', $spontaneousTrimItem->audio), 0, -4)}}" value="Play"/>
                                            <span id="total-time" class="time{{substr(str_replace('uploads/trim-audio/', '', $spontaneousTrimItem->audio), 0, -4)}}">00:00:00</span>

                                        </div>
                                    @else
                                        <i class="fa fa-times text-danger"></i>
                                    @endif
                                </td>
                                <td class="">
                                    @if(isset($spontaneousTrimItem->validation_status))
                                        @if($spontaneousTrimItem->validation_status==1)
                                            <span class="badge rounded-pill bg-success">{{__('messages.সঠিক')}}</span>
                                        @else

                                            <span class="badge rounded-pill bg-warning">{{__('messages.সঠিক না')}}</span>
                                        @endif
                                    @else
                                        <i class="fa fa-times text-danger"></i>
                                    @endif
                                </td>
                                @if(isset($spontaneousTrimItem))
                                    @if($spontaneousTrimItem->status == 0)
                                        <td class="">
                                            <i class="fa fa-times text-danger"></i>
                                        </td>
                                    @elseif($spontaneousTrimItem->status == 2)
                                        <td class="">
                                            <span class="badge rounded-pill bg-danger">{{__('messages.সংশোধন')}}</span>
                                        </td>
                                    @elseif($spontaneousTrimItem->status == 1)
                                        <td class="">
                                            <span class="badge rounded-pill bg-warning">{{__('messages.বিচারাধীন')}}</span>
                                        </td>
                                    @elseif($spontaneousTrimItem->status == 3)
                                        <td class="">
                                            <span class="badge rounded-pill bg-success">{{__('messages.অনুমোদিত')}}</span>
                                        </td>
                                    @endif

                                @else
                                    <td>
                                        <i class="fa fa-times text-danger"></i>
                                    </td>
                                @endif
                                @can('Approval-List')
                                <td>
                                    <div class="d-grid gap-2 d-md-flex justify-content-start">
                                        @if(isset($spontaneousTrimItem))
                                            @if($spontaneousTrimItem->status===1)
                                                @can('Spontaneous-Edit')
                                                    <a class="btn btn-info btn-sm" href="{{route('admin.data_collections.spont.trim.edit', $spontaneousTrimItem->id)}}">
                                                        <i class="text-white fas fa-edit"></i>
                                                    </a>
                                                @endcan
                                            @endif
                                        @endif

                                        @if(isset($spontaneousTrimItem))
                                            @if($spontaneousTrimItem->validation_status === null && $spontaneousTrimItem->status== 1)
                                               @can('Validation-Button')
                                                    <form action="{{route('admin.validation.spontaneous.word.store')}}" method="post">
                                                        @csrf
                                                        <input  id="audio_trim_id" type="hidden" name="audio_trim_id" value="{{$spontaneousTrimItem->id}}">
                                                        <input  id="Agree" type="hidden" name="validation_status" value="1">
                                                        <button class="btn btn-purple btn-sm">
                                                            {{__('messages.একমত')}}
                                                        </button>
                                                    </form> 
                                                    <form action="{{route('admin.validation.spontaneous.word.store')}}" method="post">
                                                        @csrf
                                                        <input  id="audio_trim_id" type="hidden" name="audio_trim_id" value="{{$spontaneousTrimItem->id}}">
                                                        <input class="form-check-input " id="NotAgree" type="hidden" name="validation_status" value="0">
                                                        {{-- <button class="btn btn-purple btn-sm">
                                                            {{__('messages.একমত নই')}}
                                                        </button> --}}
                                                        <button class="btn btn-purple btn-sm edit-btn text-white" type="button" value="{{$spontaneousTrimItem->id}}">
                                                            {{__('messages.একমত নই')}}
                                                        </button>
                                                    </form>
                                                @endcan
                                            @endif
                                            @if(isset($spontaneousTrimItem))
                                            @if($spontaneousTrimItem->validation_status!=NULL)
                                                @if($spontaneousTrimItem->status===1)
                                                @can('Data Collection Approve')
                                                <form action="{{route('admin.approved.spontaneous.word.store')}}" method="post">
                                                    @csrf
                                                    <input  id="audio_trim_id" type="hidden" name="audio_trim_id" value="{{$spontaneousTrimItem->id}}">
                                                    <input  id="Agree" type="hidden" name="validation_status" value="1">
                                                    <button class="btn btn-success btn-sm text-white">
                                                        {{__('messages.অনুমোদন')}}
                                                    </button>
                                                </form>
                                                <form action="{{route('admin.validation.spontaneous.word.store')}}" method="post">
                                                    @csrf
                                                    <input  id="audio_trim_id" type="hidden" name="audio_trim_id" value="{{$spontaneousTrimItem->id}}">
                                                    <input class="form-check-input " id="NotAgree" type="hidden" name="validation_status" value="0">
                                                    <button class="btn btn-danger btn-sm edit-btn text-white" type="button" value="{{$spontaneousTrimItem->id}}">
                                                        {{__('messages.রিভার্ট')}}
                                                    </button>
                                                </form>
                                                @endcan
                                                @endif
                                            @endif
                                        @endif
                                        @endif

                                    </div>
                                </td>
                                @endcan
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('admin.data_collection.revert')
@endsection

@section('language-filter-js')
    <script>
        $(document).ready(function() {
            $('#directedTopic').DataTable();

            // audio player view
            $('.myLink').trigger('click');
            $('a[data-dt-idx]').addClass('clicked-once');
            $('a[data-dt-idx="1"]').removeClass('clicked-once');
        } );


        $(document).on("click", ".page-link", function(e) {
            var ID =  $(this).data('dt-idx');
            ID = ID+1
            if($(this).hasClass('clicked-once')){
                $('.myLink').trigger('click');
                $('a[data-dt-idx="'+ID+'"]').addClass('clicked-once');
            } else {
                // $('a[data-dt-idx="'+ID+'"]').addClass('clicked-once');
                /*setTimeout(function() {
                    $('.myLink').trigger('click');
                }, 1000);*/
            }


        });

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
    </script>

@endsection

