@extends('layouts.app')

@section('title', 'ডাটা কালেক্টর তালিকা')

@section('content')
    <div class="container-fluid px-0">
        <div class="card mb-3">
            <div class="card-header">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.data_collections.index')}}">{{__('messages.তথ্য সংগ্রহ')}}</a></li>
                       @if(!empty($firstItem))
                        <li class="breadcrumb-item " aria-current="page">{{$firstItem->language->name}}</li>
                        <li class="breadcrumb-item " aria-current="page">{{$firstItem->district->name}}</li>
                        <li class="breadcrumb-item " aria-current="page">{{$firstItem->collector->name}}</li>
                        <li class="breadcrumb-item " aria-current="page">{{$firstItem->speaker->name}}</li>
                        @endif
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                @if($errors->count() > 0)
                    <ul class="list-group notification-object">
                        @foreach($errors->all() as $error)
                            <li class="list-group-item text-danger">
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="data-collection">
                        <thead class="table-dark">
                        <tr>
                            <th scope="col" style="width: 5rem;">{{__('messages.ক্রমিক নং')}}</th>
                            <th scope="col">{{__('messages.টাইপ')}}</th>
                            <th scope="col">{{__('messages.অডিও')}}</th>
                            <th scope="col">{{__('messages.বাংলা')}}</th>
                            <th scope="col">{{__('messages.কীওয়ার্ড')}}</th>
                            <th scope="col">{{__('messages.স্ট্যাটাস')}}</th>
                            <th scope="col" class="text-center">{{__('messages.অ্যাকশন')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($dataCollections as $key=>$dataCollection)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td class="">{{($dataCollection->type_id == 1)? 'নির্দেশিত': 'স্বতঃস্ফূর্ত'}}</td>
                                @if($dataCollection->dcDirected)
                                    <td class="align-middle text-start ss " style="width: 10rem" >
                                        <button style="display: none;" class="myLink" onclick="audioFile({{ $dataCollection->dcDirected->dcSentence }})"></button>
                                        <div id="waveform{{substr(str_replace('./uploads/data-collections/', '', $dataCollection->dcDirected->dcSentence->audio), 0, -4)}}"></div>
                                        <div id="waveform-time-indicator" class="justify-content-between">
                                            <input type="button" id="play-pause{{substr(str_replace('./uploads/data-collections/', '', $dataCollection->dcDirected->dcSentence->audio), 0, -4)}}" value="Play"/>
                                            <span id="total-time" class="time{{substr(str_replace('./uploads/data-collections/', '', $dataCollection->dcDirected->dcSentence->audio), 0, -4)}}">00:00:00</span>

                                        </div>
                                    </td>
                                @else
                                    <td class="align-middle text-start ss " style="width: 10rem" >
                                        <button style="display: none;" class="myLink" onclick="audioFile({{ $dataCollection->dcSpontaneous }})"></button>
                                        <div id="waveform{{substr(str_replace('./uploads/data-collections/', '', $dataCollection->dcSpontaneous->audio), 0, -4)}}"></div>
                                        <div id="waveform-time-indicator" class="justify-content-between">
                                            <input type="button" id="play-pause{{substr(str_replace('./uploads/data-collections/', '', $dataCollection->dcSpontaneous->audio), 0, -4)}}" value="Play"/>
                                            <span id="total-time" class="time{{substr(str_replace('./uploads/data-collections/', '', $dataCollection->dcSpontaneous->audio), 0, -4)}}">00:00:00</span>

                                        </div>
                                    </td>
                                @endif
                                @if($dataCollection->dcSpontaneous)
                                    <td class=""></td>
                                    @if(Auth::user()->user_type == 4)
                                        <td class="align-middle">{{$dataCollection->dcSpontaneous->spontaneous->word}}
                                            <a href="{{route('admin.data_collections.spontaneous.edit', $dataCollection->dcSpontaneous->id)}}"><i class="fas fa-edit"></i>{{--{{__('messages.আইপিএ')}}--}}</a>
                                        </td>
                                    @else
                                        <td class="">{{$dataCollection->dcSpontaneous->spontaneous->word}}</td>
                                    @endif
                                @endif
                                @if(isset($dataCollection->dcDirected->dcSentence->directed))
                                    @if(Auth::user()->user_type == 4)
                                        <td class="align-middle">{{($dataCollection->dcDirected->dcSentence->directed->sentence)? $dataCollection->dcDirected->dcSentence->directed->sentence:''}}
                                            <a href="{{route('admin.data_collections.directed.edit', $dataCollection->dcDirected->dcSentence->id)}}"><i class="fas fa-edit"></i>{{--{{__('messages.আইপিএ')}}--}}</a>
                                        </td>
                                    @else
                                        <td class="align-middle">{{($dataCollection->dcDirected->dcSentence->directed->sentence)? $dataCollection->dcDirected->dcSentence->directed->sentence:''}}</td>
                                    @endif
                                    <td class="align-middle"></td>
                                @endif

                                @if(isset($dataCollection->dcDirected->dcSentence))
                                    @if($dataCollection->dcDirected->dcSentence->status == null && $dataCollection->dcDirected->dcSentence->approved_by == null)
                                        <td class="">
                                            <span class="badge rounded-pill bg-info">{{__('messages.প্রক্রিয়াধীন')}}</span>
                                        </td>
                                    @elseif($dataCollection->dcDirected->dcSentence->status == 2 && $dataCollection->dcDirected->dcSentence->approved_by != null)
                                        <td class="">
                                            <span class="badge rounded-pill bg-danger">{{__('messages.সংশোধন')}}</span>
                                        </td>
                                    @elseif($dataCollection->dcDirected->dcSentence->status == null && $dataCollection->dcDirected->dcSentence->approved_by != null)
                                        <td class="">
                                            <span class="badge rounded-pill bg-warning">{{__('messages.বিচারাধীন')}}</span>
                                        </td>
                                    @elseif($dataCollection->dcDirected->dcSentence->status == 1 && $dataCollection->dcDirected->dcSentence->approved_by != null)
                                        <td class="">
                                            <span class="badge rounded-pill bg-success">{{__('messages.অনুমোদিত')}}</span>
                                        </td>
                                    @endif
                                @else
                                    @if($dataCollection->dcSpontaneous->status == null && $dataCollection->dcSpontaneous->approved_by == null)
                                        <td class="">
                                            <span class="badge rounded-pill bg-info">{{__('messages.প্রক্রিয়াধীন')}}</span>
                                        </td>
                                    @elseif($dataCollection->dcSpontaneous->status == 2 && $dataCollection->dcSpontaneous->approved_by != null)
                                        <td class="">
                                            <span class="badge rounded-pill  bg-danger">{{__('messages.সংশোধন')}}</span>
                                        </td>
                                    @elseif($dataCollection->dcSpontaneous->status == null && $dataCollection->dcSpontaneous->approved_by != null)
                                        <td class="">
                                            <span class="badge rounded-pill bg-warning">{{__('messages.বিচারাধীন')}}</span>
                                        </td>
                                    @elseif($dataCollection->dcSpontaneous->status == 1 && $dataCollection->dcSpontaneous->approved_by != null)
                                        <td class="">
                                            <span class="badge rounded-pill bg-success">{{__('messages.অনুমোদিত')}}</span>
                                        </td>
                                    @endif
                                @endif

                                <td class="">
                                    <div class="d-grid gap-2 d-md-flex justify-content-start">

                                        @if(isset($dataCollection->dcDirected))
                                            <a class="btn btn-info btn-sm" href="{{ route('admin.data_collections.trim.show',['type'=>isset($dataCollection->dcDirected) ? 'directed' : '', 'id' => $dataCollection->dcDirected->dcSentence->id]) }}">
                                                <i class="text-white far fa-eye"></i>
                                            </a>
                                        @else
                                            <a class="btn btn-info btn-sm" href="{{ route('admin.data_collections.trim.show',['type'=>isset($dataCollection->dcSpontaneous) ? 'spontaneous' : '', 'id' => $dataCollection->dcSpontaneous->id]) }}">
                                                <i class="text-white far fa-eye"></i>
                                            </a>
                                        @endif
                                        @if(isset($dataCollection->dcDirected->dcSentence))
                                            @if($dataCollection->dcDirected->dcSentence->status == null && $dataCollection->dcDirected->dcSentence->approved_by == null)
                                                @if(Auth::user()->user_type == 4)
                                                    <a class="btn btn-purple btn-sm text-white" href="{{ route('trim-page',['type'=>($dataCollection->type_id == 1) ? 'directed' : '', 'id' => $dataCollection->dcDirected->dcSentence->id]) }}">
                                                        <i class="fa-solid fa-scissors"></i>
                                                    </a>
                                                @endif
                                            @endif
                                        @else
                                            @if($dataCollection->dcSpontaneous->status == null && $dataCollection->dcSpontaneous->approved_by == null)
                                                @if(Auth::user()->user_type == 4)
                                                    <a class="btn btn-purple btn-sm text-white" href="{{ route('trim-page',['type'=>($dataCollection->type_id == 2) ? 'spontaneous' : '', 'id' => $dataCollection->dcSpontaneous->id]) }}">
                                                        <i class="fa-solid fa-scissors"></i>
                                                    </a>
                                                @endif
                                            @endif
                                        @endif
                                        @if(isset($dataCollection->dcSpontaneous))
                                            <form action="{{ route('admin.data_collections.destroy', $dataCollection->dcSpontaneous->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm show_confirm">
                                                    <svg class="icon  text-white">
                                                        <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-trash')}}"></use>
                                                    </svg>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.data_collections.directed.destroy', $dataCollection->dcDirected->dcSentence->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm show_confirm">
                                                    <svg class="icon  text-white">
                                                        <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-trash')}}"></use>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
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
    <script type="text/javascript">


        $(document).ready(function() {
            //datatable
            $('#data-collection').DataTable({
                // "lengthMenu": [[2, 15, 25, -1], [5, 15, 25, "All"]]
            });

            // audio player view
            $('.myLink').trigger('click');
            $('a[data-dt-idx]').addClass('clicked-once');
            $('a[data-dt-idx="1"]').removeClass('clicked-once');

        } );
        /*$(document).one(function (){
            // trigger once
            $(".custom-select").one("click", function(){
                $('.myLink').trigger('click');
            });
        })*/


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


        // alertify delete notification
        $('.show_confirm').click(function(event) {
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

