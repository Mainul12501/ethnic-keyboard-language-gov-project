@extends('layouts.app')

@section('title', 'ডাটা কালেক্টর তালিকা')

@section('content')
    <div class="container-fluid px-0">
        <div class="card mb-3">
            <div class="card-header">
                <ul class="nav nav-pills card-header-pills justify-content-between">
                    <li class="nav-item">{{__('messages.বিবেচনাধীন ডাটা')}}</li>
                    @if(Auth::user()->user_type == 4)
                        {{-- <li class="nav-item"><a class="btn btn-success btn-sm text-white" href="{{route('admin.data_collections.create')}}">
                                <svg class="icon me-2 text-white">
                                    <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-plus')}}"></use>
                                </svg>{{__('messages.নতুন')}}</a>
                        </li> --}}
                    @endif
                </ul>
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
                {{--@if(Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ Session::get('success') }}
                        <button class="btn-close" type="button" data-coreui-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif--}}
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="data-collection">
                        <thead class="table-dark">
                        <tr>
                            <th scope="col" style="width: 5rem;">{{__('messages.ক্রমিক নং')}}</th>
                            <th scope="col">{{__('messages.ভাষা')}}</th>
                            <th scope="col">{{__('messages.অবস্থান')}}</th>
                            <th scope="col">{{__('messages.ডাটা কালেক্টর')}}</th>
                            <th scope="col">{{__('messages.স্পিকার')}}</th>
                            <th scope="col">{{__('messages.টাইপ')}}</th>
                            <th scope="col">{{__('messages.কীওয়ার্ড')}}</th>
                            <th scope="col">{{__('messages.বাক্য')}}</th>
                            <th scope="col">{{__('messages.অডিও')}}</th>

                            {{-- <th scope="col" class="text-center">{{__('messages.অ্যাকশন')}}</th> --}}
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($dataCollections as $key=>$dataCollection)
                            <tr>
                                <td>{{++ $key }}</td>
                                @if(isset($dataCollection->collection->language))
                                    <td class="">{{$dataCollection->collection->language->name}}</td>
                                @else
                                    <td class="">
                                        {{isset($dataCollection->dcDirected->collection->language->name)? $dataCollection->dcDirected->collection->language->name:''}}
                                    </td>
                                @endif
                                @if(isset($dataCollection->collection->district))
                                    <td class="">{{$dataCollection->collection->district->name}}</td>
                                @else
                                    <td class="">{{isset($dataCollection->dcDirected->collection->district->name)? $dataCollection->dcDirected->collection->district->name: ''}}</td>
                                @endif
                                @if(isset($dataCollection->collection->collector))
                                    <td class="">{{$dataCollection->collection->collector->name}}</td>
                                @else
                                    <td class="">{{isset($dataCollection->dcDirected->collection->collector->name)? $dataCollection->dcDirected->collection->collector->name: ''}}</td>
                                @endif
                                @if(isset($dataCollection->collection->speaker))
                                    <td class="">{{$dataCollection->collection->speaker->name}}</td>
                                @else
                                    <td class="">{{isset($dataCollection->dcDirected->collection->speaker->name)? $dataCollection->dcDirected->collection->speaker->name: ''}}</td>
                                @endif
                                @if(isset($dataCollection->collection))
                                    <td class="">{{($dataCollection->collection->type_id== 2)? 'স্বতঃস্ফূর্ত':''}}</td>
                                @elseif(isset($dataCollection->dcDirected->collection))
                                    <td class="">{{($dataCollection->dcDirected->collection->type_id == 1)? 'নির্দেশিত': ''}}</td>
                                @endif
                                @if($dataCollection->spontaneous)
                                {{-- <td class=""></td> --}}
                                <td class="">{{$dataCollection->spontaneous->word}}</td>
                                @endif
                                @if($dataCollection->directed)
                                    <td class="">{{$dataCollection->dcDirected->topic->name}}</td>
                                    {{-- <td class=""></td> --}}
                                @endif
                                @if($dataCollection->spontaneous)
                                <td class=""></td>
                                {{-- <td class="">{{$dataCollection->spontaneous->word}}</td> --}}
                                @endif
                                @if($dataCollection->directed)
                                    <td class="">{{$dataCollection->directed->sentence}}</td>
                                    {{-- <td class=""></td> --}}
                                @endif
                                <td class="align-middle text-start ss " style="width: 10rem" >
                                    <button style="display: none;" class="myLink" onclick="audioFile({{ $dataCollection }})"></button>
                                    <div id="waveform{{substr(str_replace('./uploads/data-collections/', '', $dataCollection->audio), 0, -4)}}"></div>
                                    <div id="waveform-time-indicator" class="justify-content-between">
                                        <input type="button" id="play-pause{{substr(str_replace('./uploads/data-collections/', '', $dataCollection->audio), 0, -4)}}" value="Play"/>
                                        <span id="total-time" class="time{{substr(str_replace('./uploads/data-collections/', '', $dataCollection->audio), 0, -4)}}">00:00:00</span>

                                    </div>
                                </td>

                                {{-- <td class="">
                                    <div class="d-grid gap-2 d-md-flex justify-content-center">

                                       @if($dataCollection->collection)
                                            <a class="btn btn-info btn-sm" href="{{route('admin.data_collections.show', $dataCollection->id)}}">
                                                <svg class="icon  text-white">
                                                    <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-low-vision')}}"></use>
                                                </svg>
                                            </a>
                                        @else
                                            <a class="btn btn-info btn-sm" href="{{route('admin.data_collections.directed.show', $dataCollection->id)}}">
                                                <svg class="icon  text-white">
                                                    <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-low-vision')}}"></use>
                                                </svg>
                                            </a>
                                        @endif

                                         <a class="btn btn-purple btn-sm" href="{{ route('admin.trim-approved',['type'=>isset($dataCollection->d_c_directed_id) ? 'directed' : 'spontaneous', 'id' => $dataCollection->id]) }}">
                                             <svg class="icon  text-white">
                                                 <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-check')}}"></use>
                                             </svg>
                                         </a>
                                    </div>
                                </td> --}}
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

