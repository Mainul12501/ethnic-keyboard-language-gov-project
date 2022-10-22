@extends('layouts.app')

@section('title', 'ডাটা কালেক্টর তালিকা')

@section('content')
    <div class="container-fluid px-0">
        <div class="card mb-3">
            <div class="card-header">
                <ul class="nav nav-pills card-header-pills justify-content-between">
                    <li class="nav-item">{{__('messages.সব তথ্য')}}</li>
                    @if(Auth::user()->user_type == 4)
                        <li class="nav-item"><a class="btn btn-success btn-sm text-white" href="{{route('admin.data_collections.create')}}">
                                <svg class="icon me-2 text-white">
                                    <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-plus')}}"></use>
                                </svg>{{__('messages.নতুন')}}</a>
                        </li>
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
                <form action="{{route('admin.data_collections.index')}}" method="GET">
                    <div class="row mb-3" id="clear">
                        <div class="col-md-2">
                            <select class="form-select" name="language_id" id="language_id">
                                <option value="">{{__('messages.ভাষা নির্বাচন করুন')}}</option>
                                @foreach($languages as $lanItem)
                                <option value="{{$lanItem->language->id}}" {{ $lanItem->language->id == $selected_id['language_id'] ? 'selected' : '' }}>{{$lanItem->language->name}}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="col-md-2">
                            <select class="form-select" name="district_id" id="district_id">
                                <option value="">{{__('messages.জেলা নির্বাচন করুন')}}</option>
                                @foreach($districts as $disItem)
                                    <option value="{{$disItem->district->id}}" {{ $disItem->district->id == $selected_id['district_id'] ? 'selected' : '' }}>{{$disItem->district->name}}</option>
                                @endforeach
                            </select>

                        </div>
                        @if(Auth::user()->user_type != 4)
                        <div class="col-md-3">
                            <select class="form-select" name="collector_id" id="collector_id">
                                <option value="">{{__('messages.ডাটা কালেক্টর নির্বাচন করুন')}}</option>
                                @foreach($collectors as $collectorItem)
                                    <option value="{{$collectorItem->collector->id}}" {{ $collectorItem->collector->id == $selected_id['collector_id'] ? 'selected' : '' }}>{{$collectorItem->collector->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                        <div class="col-md-3">
                            <select class="form-select" name="speaker_id" id="speaker_id">
                                <option value="">{{__('messages.স্পিকার নির্বাচন করুন')}}</option>
                                @foreach($speakers as $speakerItem)
                                    <option value="{{$speakerItem->speaker->id}}" {{ $speakerItem->speaker->id == $selected_id['speaker_id'] ? 'selected' : '' }}>{{$speakerItem->speaker->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 ">
                            <div class="input-group">
                                <a class="btn bg-transparent" id="remove" href="{{route('admin.data_collections.index')}}"  data-toggle="tooltip" data-placement="top" title="Clear" style="display: none; margin-left: -23px; z-index: 100;">
                                    <svg class="icon text-dark">
                                        <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-x-circle')}}"></use>
                                    </svg>
                                </a>
                                <button class="btn btn-success text-white" type="submit">
                                    <svg class="icon me-2 text-white">
                                        <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-search')}}"></use>
                                    </svg>
                                </button>
                            </div>

                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="data-collection">
                        <thead class="table-dark">
                        <tr>
                            <th scope="col" style="width: 5rem;">{{__('messages.ক্রমিক নং')}}</th>
                            <th scope="col">{{__('messages.ভাষা')}}</th>
                            <th scope="col">{{__('messages.অবস্থান')}}</th>
                            <th scope="col">{{__('messages.ডাটা কালেক্টর')}}</th>
                            <th scope="col">{{__('messages.স্পিকার')}}</th>
                            <th scope="col" class="text-center" style="width: 3rem;">{{__('messages.অ্যাকশন')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($dataCollections as $key=>$dataCollection)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td class="">{{$dataCollection->language->name}}</td>
                                <td class="">{{$dataCollection->district->name}}</td>

                                @if(isset($dataCollection->collector))
                                    <td class="">
                                        <div class="row">
                                            <div class="col">
                                                <span class="small">{{$dataCollection->collector->name}}</span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <a href="tel:{{$dataCollection->collector->phone}}">

                                                    <span class="small">
                                                        @if(App::getLocale() == 'bn')
                                                        {{ Converter::en2bn($dataCollection->collector->phone)}}
                                                       @else
                                                        {{$dataCollection->collector->phone}}
                                                       @endif
                                                        </span>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                @endif
                                @if(isset($dataCollection->speaker))
                                    <td class="">
                                        <div class="row">
                                            <div class="col">
                                                <span class="small">{{$dataCollection->speaker->name}}</span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <a href="tel:{{$dataCollection->speaker->phone}}">
                                                    <span class="small">
                                                        @if(App::getLocale() == 'bn')
                                                        {{ Converter::en2bn($dataCollection->speaker->phone)}}
                                                       @else
                                                        {{$dataCollection->speaker->phone}}
                                                       @endif
                                                       </span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <span class="small"><b>{{$dataCollection->speaker->area}}</b></span>
                                            </div>
                                        </div>
                                    </td>
                                @endif
                                {{--<td class="align-middle">{{($dataCollection->type_id == 1)? 'নির্দেশিত':'স্বতঃস্ফূর্ত'}}</td>--}}
                                <td class="">
                                    <div class="d-grid gap-2 d-md-flex justify-content-center">
                                        <a class="btn btn-info btn-sm" href="{{ route('admin.data.list.show',['language_id'=>$dataCollection->language->id, 'district_id'=>$dataCollection->district->id, 'collector_id'=>$dataCollection->collector->id, 'speaker_id' => $dataCollection->speaker->id]) }}">
                                            <i class="text-white far fa-eye"></i>
                                        </a>
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

            // var target = $('option:selected').val();
            var language = $('#language_id option:selected').val();
            var district = $('#district_id option:selected').val();
            var collector = $('#collector_id option:selected').val();
            var speaker = $('#speaker_id option:selected').val();
            var x = document.getElementById("remove");
            if(language || district || collector || speaker){
                x.style.display = "block";
            }

            $('select').on('change', function() {
                var value =this.value;
                var x = document.getElementById("remove");
                if(value){
                    x.style.display = "block";
                }
            });
        });

        $('#language_id').select2({
            width: '100%',
            placeholder: "{{__('messages.ভাষা নির্বাচন করুন')}}",
            allowClear: true
        });
        $('#district_id').select2({
            width: '100%',
            placeholder: "{{__('messages.জেলা নির্বাচন করুন')}}",
            allowClear: true
        });
        $('#collector_id').select2({
            width: '100%',
            placeholder: "{{__('messages.ডাটা কালেক্টর নির্বাচন করুন')}}",
            allowClear: true
        });
        $('#speaker_id').select2({
            width: '100%',
            placeholder: "{{__('messages.স্পিকার নির্বাচন করুন')}}",
            allowClear: true
        });


    </script>

@endsection
