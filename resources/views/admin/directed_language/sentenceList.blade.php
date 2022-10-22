
@extends('layouts.app')

@section('title', '')

@section('content')
    <div class="container-fluid px-0">
        <div class="card mb-3">
            <div class="card-header">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item" data-toggle="tooltip" data-placement="top" title="Back">
                            <a class="btn btn-sm btn-success" href="{{route('admin.directed.language.tasks.list', $directedTaskByTopic->task_assign_id)}}">
                                <i class="fas fa-arrow-left text-white"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">{{__('messages.নির্দেশিত')}}</li>
                        <li class="breadcrumb-item"  data-toggle="tooltip" data-placement="top" title="Language">
                            {{$directedTaskByTopic->taskAssign->language->name}}
                        </li>
                        <li class="breadcrumb-item"  data-toggle="tooltip" data-placement="top" title="District">
                            {{$directedTaskByTopic->taskAssign->district->name}}
                        </li>
                        <li class="breadcrumb-item"  data-toggle="tooltip" data-placement="top" title="topic">
                            {{$directedTaskByTopic->topic->name}}
                        </li>
                        {{--<li class="breadcrumb-item"  data-toggle="tooltip" data-placement="top" title="Back">
                            {{$directedTaskByTopic->topic->name}}
                        </li>--}}
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="directedTopic">
                        <thead class="table-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col" style="width: 25rem;">{{__('messages.বাক্য')}}</th>
                            <th scope="col">{{__('messages.অনুবাদ')}}</th>
                            <th scope="col">{{__('messages.অডিও')}}</th>
                            <th scope="col">{{__('messages.উচ্চারণ')}}</th>
                            <th scope="col">{{__('messages.যাচাইকৃত')}}</th>
                            <th scope="col">{{__('messages.স্ট্যাটাস')}}</th>
                            @can('Audio-Validation-Name')
                            <th scope="col" style="width: 9rem">{{__('messages.অ্যাকশন')}}</th>
                            @endcan
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($directedSentences as $key=> $directedSentence)
                            @php
                                $taskAssignID =$directedTaskByTopic->task_assign_id;
                                $districtID =$directedTaskByTopic->taskAssign->district->id;
                                $topicID =$directedTaskByTopic->topic_id;

                                $dataCollection =  \App\Models\DataCollection::where('task_assign_id', $taskAssignID)
                                    ->where('district_id', $districtID )
                                    ->where('type_id', 1)
                                    ->with('dcDirected.dcSentence')
                                    ->WhereHas('dcDirected',function($q)use($topicID){
                                        $q->where('topic_id', $topicID);
                                    })
                                    ->whereHas('dcDirected.dcSentence', function ($q1) use ($directedSentence){
                                        $q1->where('directed_id', $directedSentence->id);
                                    })
                                    ->first();
                                    // echo $dataCollection;
                            @endphp
                            <tr>
                                <th scope="row">
                                    @if(app()->getLocale() == 'bn')
                                    {{Converter::en2bn(++ $key)}}
                                @else
                                {{ ++ $key}}
                                @endif
                                    {{-- {{  ++ $key }}</th> --}}
                                <td class="">
                                    @if(isset($dataCollection->dcDirected->dcSentence->bangla))
                                        {{$dataCollection->dcDirected->dcSentence->bangla}}
                                    @else
                                        {{$directedSentence->sentence}}
                                    @endif
                                </td>
                                <td class="">
                                    @if(isset($dataCollection->dcDirected->dcSentence->english))
                                        {{$dataCollection->dcDirected->dcSentence->english}}
                                    @else
                                        {{$directedSentence->english}}
                                    @endif
                                </td>

                                <td class="">
                                    @if(isset($dataCollection))
                                        {{--<audio src="{{asset($dataCollection->dcDirected->dcSentence->audio)}}" controls>
                                            <source src="{{asset($dataCollection->dcDirected->dcSentence->audio)}}" type="audio/*">
                                        </audio>--}}
                                        <button style="display: none;" class="myLink" onclick="audioFile({{ $dataCollection->dcDirected->dcSentence }})"></button>
                                        <div id="waveform{{substr(str_replace('./uploads/data-collections/', '', $dataCollection->dcDirected->dcSentence->audio), 0, -4)}}"></div>
                                        <div id="waveform-time-indicator" class="justify-content-between">

                                            <input type="button" id="play-pause{{substr(str_replace('./uploads/data-collections/', '', $dataCollection->dcDirected->dcSentence->audio), 0, -4)}}" value="Play"/>
                                            <span id="total-time" class="time{{substr(str_replace('./uploads/data-collections/', '', $dataCollection->dcDirected->dcSentence->audio), 0, -4)}}">00:00:00</span>

                                        </div>
                                    @else
                                        <i class="fa fa-times text-danger"></i>
                                    @endif
                                </td>
                                <td class="">
                                    @if(isset($dataCollection->dcDirected->dcSentence->transcription))
                                        {{$dataCollection->dcDirected->dcSentence->transcription}}
                                    @else
                                        <i class="fa fa-times text-danger"></i>
                                    @endif
                                </td>
                                <td class="">
                                    @if(isset($dataCollection->dcDirected->dcSentence->validation_status))
                                        @if($dataCollection->dcDirected->dcSentence->validation_status==1)
                                            <span class="badge rounded-pill bg-success">{{__('messages.একমত')}}</span>
                                        @else

                                            <span class="badge rounded-pill bg-warning">{{__('messages.একমত নই')}}</span>
                                        @endif
                                    @else
                                        <i class="fa fa-times text-danger"></i>
                                    @endif
                                </td>
                                @if(isset($dataCollection))
                                    @if($dataCollection->dcDirected->dcSentence->status === null)
                                        <td class="">
                                            <i class="fa fa-times text-danger"></i>
                                        </td>
                                    @elseif($dataCollection->dcDirected->dcSentence->status == 2)
                                        <td class="">
                                            <span class="badge rounded-pill bg-danger">{{__('messages.সংশোধন')}}</span>
                                        </td>
                                    @elseif($dataCollection->dcDirected->dcSentence->status == 0)
                                        <td class="">
                                            <span class="badge rounded-pill bg-warning">{{__('messages.বিচারাধীন')}}</span>
                                        </td>
                                    @elseif($dataCollection->dcDirected->dcSentence->status == 1)
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
                                        {{-- @if(Auth::user()->hasRole(['Linguist']))--}}
                                        @if(isset($dataCollection))
                                        @if(($dataCollection->dcDirected->dcSentence->status!=1) && ($dataCollection->dcDirected->dcSentence->status!=2))
                                                @can('Directed-Edit')
                                                <a class="btn btn-info btn-sm" href="{{route('admin.data_collections.directed.edit', $dataCollection->dcDirected->dcSentence->id)}}">
                                                    <i class="text-white fas fa-edit"></i>
                                                </a>
                                                @endcan
                                            @endif
                                        @endif

                                        {{-- @endif--}}
                                        {{--@if(Auth::user()->hasRole('Validator') && $dataCollection->dcDirected->dcSentence->validation_status== null)--}}
                                        @if(isset($dataCollection))
                                            @if($dataCollection->dcDirected->dcSentence->validation_status===NULL)
                                                @can('Validation-Button')
                                                <form action="{{route('admin.validation.directed.topic.store')}}" method="post">
                                                    @csrf
                                                    <input  id="d_c_directed_sentence_id" type="hidden" name="d_c_directed_sentence_id" value="{{$dataCollection->dcDirected->dcSentence->id}}">
                                                    <input  id="Agree" type="hidden" name="validation_status" value="1">
                                                    <button class="btn btn-purple btn-sm">
                                                        {{__('messages.একমত')}}
                                                    </button>
                                                </form>

                                                <input  id="collectorID" type="hidden" name="collector_id" value="{{ $collectorID }}">
                                                {{-- <form action="{{route('admin.validation.directed.topic.store')}}" method="post">
                                                    @csrf
                                                    <input  id="d_c_directed_sentence_id" type="hidden" name="d_c_directed_sentence_id" value="{{$dataCollection->dcDirected->dcSentence->id}}">
                                                    <input class="form-check-input " id="NotAgree" type="hidden" name="validation_status" value="0">
                                                    <button class="btn btn-purple edit-btn btn-sm" type="button" value="{{$dataCollection->dcDirected->dcSentence->id}}">
                                                        {{__('messages.একমত নই')}}
                                                    </button> --}}
                                                    <button class="btn btn-purple btn-sm edit-btn text-white" type="button" value="{{$dataCollection->dcDirected->dcSentence->id}}">
                                                        {{__('messages.একমত নই')}}
                                                    </button>
                                                {{-- </form> --}}
                                                @endcan
                                            @endif
                                        @endif
                                        {{--@endif--}}
                                        @if(isset($dataCollection))
                                            @if($dataCollection->dcDirected->dcSentence->validation_status!==NULL)
                                                @if(($dataCollection->dcDirected->dcSentence->status!=1) && ($dataCollection->dcDirected->dcSentence->status!=2))
                                                    @can('Data Collection Approve')
                                                    <a class="btn btn-purple btn-sm" href="{{route('admin.data_approval.directed.sendToApprove', $dataCollection->dcDirected->dcSentence->id)}}">
                                                        <svg class="icon  text-white">
                                                            <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-check')}}"></use>
                                                        </svg>
                                                    </a>
                                                    @endcan
                                                @endif
                                            @endif
                                        @endif

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
    @include('admin.data_approval.directed_revert')
@endsection
@section('language-filter-js')
    <script>



        $(document).ready(function() {
            $('#directedTopic').DataTable( {
            dom: 'Bfrtip',
                buttons: [
                    // 'copy', 'csv', 'excel', 'print'

                    { extend: 'excel', className: 'btn btn-primary' },
                    { extend: 'csv', className: 'btn btn-secondary' },
                    { extend: 'print', className: 'btn btn-warning' }

                ]
            } );

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
            let uniqueID= unique.replace('./uploads/data-collections/', '');

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
        //revert data
        $(document).ready(function (){
            $(document).on('click', '.edit-btn', function (){
                var dcDirectedSentenceID = $(this).val();
                var collectorID = $('#collectorID').val();
                $('#trimEditForm').modal('show');

                $.ajax({
                    type: "GET",
                    url: "/admin/validator/revert/"+dcDirectedSentenceID,
                    dataType: 'json',
                    data: {dcDirectedSentenceID:dcDirectedSentenceID,collectorID:collectorID},
                    success:function (response){
                        console.log(response)
                        $('#dcDirectedSentenceID').val(dcDirectedSentenceID);
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

