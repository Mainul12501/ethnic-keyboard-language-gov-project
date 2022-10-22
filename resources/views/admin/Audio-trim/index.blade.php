@extends('layouts.app')

@section('title', 'ডাটা কালেক্টর তালিকা')

@section('content')
    <div class="container-fluid px-0">
        <div class="card mb-3">
            <div class="card-header">
                <ul class="nav nav-pills card-header-pills justify-content-between">
                    <li class="nav-item">{{__('messages.তথ্য সংগ্রহ')}}</li>
                    <li class="nav-item"><a class="btn btn-success btn-sm text-white" href="{{route('admin.data_collections.create')}}">
                            <svg class="icon me-2 text-white">
                                <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-plus')}}"></use>
                            </svg></a>
                    </li>
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
                @if(Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ Session::get('success') }}
                        <button class="btn-close" type="button" data-coreui-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="d-flex justify-content-between">
                    <div  class="col-md-4">
                        <div class="row" id="filterSearch" style="display: none">
                            <form>
                                <div class="input-group d-flex">
                                    <input type="text" class="form-control" placeholder="{{__('messages.ভাষার নাম খুঁজুন')}}">
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary" type="submit">
                                            <svg class="icon me-2">
                                                <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-search')}}"></use>
                                            </svg>{{__('messages.খুঁজুন')}}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-check form-switch form-switch-xl mb-4">
                            <label class="form-check-label" for="flexSwitchCheckDefault">Filter</label>
                            <input class="form-check-input" onclick="searchBox()" id="flexSwitchCheckDefault" type="checkbox">
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <div class="row mb-3">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="directed-tab" data-coreui-toggle="tab" data-coreui-target="#directed" type="button" role="tab" aria-controls="directed" aria-selected="true">বিচারাধীন</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="approve-tab" data-coreui-toggle="tab" data-coreui-target="#approve" type="button" role="tab" aria-controls="approve" aria-selected="false">অনুমোদন</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active " id="directed" role="tabpanel" aria-labelledby="directed-tab">
                                <table class="table table-hover table-bordered" >
                                    <thead class="table-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">{{__('messages.টাইপ')}}</th>
                                        <th scope="col">{{__('messages.সংগৃহীত')}}</th>
                                        <th scope="col">{{__('messages.ট্রিমিং')}}</th>
                                        <th scope="col">{{__('messages.বাংলা')}}</th>
                                        <th scope="col">{{__('messages.কীওয়ার্ড')}}</th>
                                        <th scope="col" class="text-center">{{__('messages.অ্যাকশন')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($dataCollections as $key=>$dataCollection)
                                        <tr>
                                            <td>{{$dataCollections->firstItem() + $key }}</td>
                                            @if($dataCollection->collection)
                                            <td class="align-middle">{{($dataCollection->collection->type_id== 2)? 'স্বতঃস্ফূর্ত':''}}</td>
                                            @elseif($dataCollection->dcDirected->collection)
                                                <td class="align-middle">{{($dataCollection->dcDirected->collection->type_id == 1)? 'নির্দেশিত': ''}}</td>
                                            @endif
{{--                                            <td class="align-middle">{{$dataCollection->audio}}</td>--}}
                                            <td class="align-middle">
                                                <audio src="{{asset($dataCollection->audio)}}" controls>
                                                    <source src="" type="audio/*">
                                                </audio>
                                            </td>
                                            <td><a class="btn btn-success btn-sm text-white" href="">
                                                <i class="fa-solid fa-scissors"></i>
                                                {{__('messages.ট্রিম')}}</a></td>
                                            @if($dataCollection->spontaneous)
                                                <td class="align-middle"></td>
                                            <td class="align-middle">{{$dataCollection->spontaneous->word}}</td>
                                            @endif
                                            @if($dataCollection->directed)
                                            <td class="align-middle">{{$dataCollection->directed->sentence}}</td>
                                                <td class="align-middle"></td>
                                            @endif
                                            <td class="text-center">
                                                <div class="d-grid gap-2 d-md-flex justify-content-center">
                                                    <a class="btn btn-info btn-sm" href="{{route('admin.data_collections.show', $dataCollection->id)}}">
                                                        <svg class="icon  text-white">
                                                            <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-low-vision')}}"></use>
                                                        </svg>
                                                    </a>
                                                    @if($dataCollection->collection)
                                                        <a class="btn btn-purple btn-sm" href="{{route('admin.data_collections.edit', $dataCollection->id)}}">
                                                            <svg class="icon  text-white">
                                                                <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-color-border')}}"></use>
                                                            </svg>
                                                        </a>
                                                    @else
                                                        <a class="btn btn-purple btn-sm" href="{{route('admin.data_collections.edit', $dataCollection->id)}}">
                                                            <svg class="icon  text-white">
                                                                <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-color-border')}}"></use>
                                                            </svg>
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{  $dataCollections->links('vendor.pagination.custom') }}
                            </div>
                            <div class="tab-pane fade" id="approve" role="tabpanel" aria-labelledby="approve-tab">
                                {{--<table class="table table-hover table-bordered" >
                                    <thead class="table-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">টাইপ</th>
                                        <th scope="col">সংগৃহীত</th>
                                        <th scope="col">কীওয়ার্ড</th>
                                        <th scope="col" class="text-center">অ্যাকশন</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($spontaneouses as $key=>$spontaneous)
                                        <tr>
                                            <td>{{ $spontaneouses->firstItem() + $key }}</td>
                                            <td class="align-middle">{{($spontaneous->collection->type_id == 2)? ' স্বতঃস্ফূর্ত': '' }}</td>
                                            <td class="align-middle">{{$spontaneous->audio}}</td>
                                            <td class="align-middle">{{$spontaneous->spontaneous->word}}</td>
                                            <td class="text-center">
                                                <div class="d-grid gap-2 d-md-flex justify-content-center">
                                                    <a class="btn btn-info btn-sm" href="{{route('admin.data_collectors.show', $spontaneous->id)}}">
                                                        <svg class="icon  text-white">
                                                            <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-low-vision')}}"></use>
                                                        </svg>
                                                    </a>
                                                    <a class="btn btn-purple btn-sm" href="{{route('admin.data_collectors.edit', $spontaneous->id)}}">
                                                        <svg class="icon  text-white">
                                                            <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-color-border')}}"></use>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{ $spontaneouses->links('vendor.pagination.custom') }}--}}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('language-filter-js')
<script>
        // filter search
        function searchBox() {
            var x = document.getElementById("filterSearch");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        }


    const audio = new Audio(/* Blob URL or URL of recording */);
    const chunks = [];\
    const audio.play();
    // const chunk.pop();
   const audio.oncanplay = e => {
    audio.play();
    // const audio.capture();
    const jsAudio= new jsAudio();

  const stream = audio.captureStream();
  const recorder = new MediaRecorder(stream);
  recorder.ondataavailable = e => {
    if (recorder.state === "recording") {
      recorder.stop()
    };
    chunks.push(e.data);
  }
  recorder.MediaRecorder(audio.trim.play);
  recorder.captureStream(recorder.data);
  recorder.chunks(recorder.data);


  recorder.onstop = e => {
    console.log(chunks)
  }
  recorder.start(3000);
}
        </script>
@endsection


