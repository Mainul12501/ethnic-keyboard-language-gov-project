@extends('layouts.app')

@section('title', '')

@section('content')
    <div class="container-fluid px-0">
        <div class="card mb-3">
            <div class="card-header">
                <nav aria-label="breadcrumb" role="navigation">
                    <div class="row">
                        <div class="col-md-6">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item" data-toggle="tooltip" data-placement="top" title="Back">
                                    <a class="btn btn-sm btn-success" href="{{route('admin.dashboard' )}}">
                                        <i class="fas fa-arrow-left text-white"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item">{{__('messages.স্বতঃস্ফূর্ত')}}</li>
                                <li class="breadcrumb-item">
                                    {{$firstItem->taskAssign->language->name}}
                                </li>
                                <li class="breadcrumb-item">
                                    {{$firstItem->taskAssign->district->name}}
                                </li>
                            </ol>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <span class="breadcrumb-item" data-toggle="tooltip" data-placement="top" title="District">
                                        <label class="form-check-label" for="total_time">{{__('অর্পিত সময়')}} :</label>
                                        @if(app()->getLocale() == 'bn')
                                                    {{Converter::en2bn($firstItem->taskAssign->total_time)}} {{__('মিনিট')}}
                                                @else
                                                {{Converter::bn2en($firstItem->taskAssign->total_time)}} {{__('মিনিট')}}
                                        @endif

                                    </span>
                                </div>
                                <div class="col-md-6">
                                    <span class="breadcrumb-item" data-toggle="tooltip" data-placement="top" title="District">
                                        <label class="form-check-label" for="total_time">{{__('মোট সংগ্রহ')}} :</label>
                                            @if(app()->getLocale() == 'bn')
                                                    {{Converter::en2bn($collected_time)}} {{__('মিনিট')}}
                                                @else
                                                    {{Converter::bn2en($collected_time)}} {{__('মিনিট')}}
                                            @endif
                                    </span>
                                </div>

                            </div>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="directedTopic">
                        <thead class="table-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{__('messages.কীওয়ার্ড')}}</th>
                            <th scope="col">{{__('messages.বাংলা')}}</th>
                            <th scope="col">{{__('messages.অনুবাদ')}}</th>
                            <th scope="col">{{__('messages.উচ্চারণ')}}</th>
                            {{-- <th scope="col">{{__('messages.অডিও')}}</th> --}}
                            <th scope="col">{{__('messages.অ্যাকশন')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($spontaneousTaskLanguages as $key=> $spontaneousTaskLanguage)
                            @php
                                $taskAssignID =$spontaneousTaskLanguage->task_assign_id;
                                $districtID =$spontaneousTaskLanguage->taskAssign->district->id;
                                $spontaneousID =$spontaneousTaskLanguage->spontaneous_id;

                                $dataCollection =  \App\Models\DataCollection::where('task_assign_id', $taskAssignID)
                                    ->where('district_id', $districtID )
                                    ->where('type_id', 2)
                                    ->with('dcSpontaneous')
                                    ->WhereHas('dcSpontaneous',function($q)use($spontaneousID){
                                        $q->where('spontaneous_id', $spontaneousID);
                                    })
                                    ->first();
                            @endphp
                            <tr>
                                <th scope="row">{{  ++ $key }}</th>
                                <td class="">{{$spontaneousTaskLanguage->spontaneous->word}}</td>
                                <td class="">
                                    @if(isset($dataCollection->dcSpontaneous->bangla))
                                        {{$dataCollection->dcSpontaneous->bangla}}
                                    @else
                                        <i class="fa fa-times text-danger"></i>
                                    @endif
                                </td>
                                <td class="">
                                    @if(isset($dataCollection->dcSpontaneous->english))
                                        {{$dataCollection->dcSpontaneous->english}}
                                    @else
                                        <i class="fa fa-times text-danger"></i>
                                    @endif
                                </td>
                                <td class="">
                                    @if(isset($dataCollection->dcSpontaneous->transcription))
                                        {{$dataCollection->dcSpontaneous->transcription}}
                                    @else
                                        <i class="fa fa-times text-danger"></i>
                                    @endif
                                </td>
                                {{-- <td class="">
                                    @if(isset($dataCollection))
                                        <button style="display: none;" class="myLink" onclick="audioFile({{ $dataCollection->dcSpontaneous }})"></button>
                                        <div id="waveform{{substr(str_replace('./uploads/data-collections/', '', $dataCollection->dcSpontaneous->audio), 0, -4)}}"></div>
                                        <div id="waveform-time-indicator" class="justify-content-between">
                                            <input type="button" id="play-pause{{substr(str_replace('./uploads/data-collections/', '', $dataCollection->dcSpontaneous->audio), 0, -4)}}" value="Play"/>
                                            <span id="total-time" class="time{{substr(str_replace('./uploads/data-collections/', '', $dataCollection->dcSpontaneous->audio), 0, -4)}}">00:00:00</span>

                                        </div>
                                    @else
                                        <i class="fa fa-times text-danger"></i>
                                    @endif
                                </td> --}}
                                <td class="text-center">
                                    <div class="d-grid gap-2 d-md-block">

                                        @if(isset($dataCollection))

                                        <a class="btn btn-info btn-sm text-white" href="{{route('admin.spontaneous.trim.list', $dataCollection->dcSpontaneous->id)}}">
                                            {{__('দেখুন')}}
                                        </a>

                                            @can('Spontaneous-Edit')
                                                <a class="btn btn-info btn-sm" href="{{route('admin.data_collections.spontaneous.edit', $dataCollection->dcSpontaneous->id)}}">
                                                    <i class="text-white fas fa-edit"></i>
                                                </a>
                                            @endcan
                                        @endif
                                        @can('Data Collection Show')
                                        <a class="btn btn-purple btn-sm text-white" data-toggle="tooltip" data-placement="top" title="Data Collection" href="{{route('admin.data_collection.spontaneous.word',['task_assign_id'=>$taskAssignID,'spontaneous_id'=>$spontaneousID])}}">
                                            {{__('ডাটা সংগ্রহ')}}
                                         </a>
                                         @endcan

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>
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
    </script>

@endsection

