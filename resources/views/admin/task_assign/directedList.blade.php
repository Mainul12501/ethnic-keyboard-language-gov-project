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
                            <li class="breadcrumb-item">{{__('messages.নির্দেশিত')}}</li>
                            <li class="breadcrumb-item" data-toggle="tooltip" data-placement="top" title="Language">
                                {{$firstItem->taskAssign->language->name}}
                            </li>
                            <li class="breadcrumb-item" data-toggle="tooltip" data-placement="top" title="District">
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
                            <th scope="col">{{__('messages.বিষয়')}}</th>
                            <th scope="col">Status</th>
                            <th scope="col" class="text-center">{{__('messages.অ্যাকশন')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($directedTaskLanguages as $key=> $directedTaskLanguage)
                            <tr>
                                <th scope="row">
                                    @if(app()->getLocale() == 'bn')
                                    ({{Converter::en2bn( ++ $key)}})
                                @else
                                    ({{ ++ $key}})
                                @endif
                                    {{-- {{  ++ $key }} --}}
                                </th>
                                <td class="">{{$directedTaskLanguage->topic->name}}
                                    @if(app()->getLocale() == 'bn')
                                    ({{Converter::en2bn( $directedTaskLanguage->topic->directeds->count())}})
                                @else
                                    ({{$directedTaskLanguage->topic->directeds->count()}})
                                @endif
                                @php
                                $partialCollection = \App\Models\DataCollection::where('task_assign_id', $directedTaskLanguage->task_assign_id)
                                ->where('type_id', 1)
                                // ->where('collector_id', Auth::id())
                                ->whereHas('dcDirected', function ($q) use($directedTaskLanguage){
                                    $q->where('topic_id', $directedTaskLanguage->topic_id);})
                                ->whereHas('dcDirected.dcSentence', function ($q0){
                                     $q0->where('topic_status',1);
                                 })
                                ->get();
                                $voiceCollection = \App\Models\DataCollection::where('task_assign_id', $directedTaskLanguage->task_assign_id)
                                ->where('type_id', 1)
                                // ->where('collector_id', Auth::id())
                                ->whereHas('dcDirected', function ($q) use($directedTaskLanguage){
                                    $q->where('topic_id', $directedTaskLanguage->topic_id);})
                                ->whereHas('dcDirected.dcSentence', function ($q0){
                                     $q0->where('topic_status',2);
                                 })
                                ->get();
                                $validation = \App\Models\DataCollection::where('task_assign_id', $directedTaskLanguage->task_assign_id)
                                ->where('type_id', 1)
                                // ->where('collector_id', Auth::id())
                                ->whereHas('dcDirected', function ($q) use($directedTaskLanguage){
                                    $q->where('topic_id', $directedTaskLanguage->topic_id);})
                                ->whereHas('dcDirected.dcSentence', function ($q0){
                                     $q0->where('topic_status',3);
                                 })
                                ->get();
                                $approve = \App\Models\DataCollection::where('task_assign_id', $directedTaskLanguage->task_assign_id)
                                ->where('type_id', 1)
                                // ->where('collector_id', Auth::id())
                                ->whereHas('dcDirected', function ($q) use($directedTaskLanguage){
                                    $q->where('topic_id', $directedTaskLanguage->topic_id);})
                                ->whereHas('dcDirected.dcSentence', function ($q0){
                                     $q0->where('topic_status',4);
                                 })
                                ->get();
                                $test=count($voiceCollection);
                                $test1=count($directedTaskLanguage->topic->directeds);
                                // echo $test;
                                // echo $test1;

                                @endphp

                                    @if((count($voiceCollection) == count($directedTaskLanguage->topic->directeds)))
                                    <td><span class="badge rounded-pill bg-primary">{{__('অডিও সংগৃহীত')}}</span></td>
                                    @elseif(count($voiceCollection)>0 &&  count($voiceCollection)<count($directedTaskLanguage->topic->directeds))
                                    <td><span class="badge rounded-pill bg-warning">{{__('আংশিক সংগৃহীত')}}</span></td>


                                    @elseif ((count($validation) == count($directedTaskLanguage->topic->directeds)))
                                    <td><span class="badge rounded-pill bg-purple">{{__('যাচাইকৃত')}}</span></td>
                                    @elseif(count($validation)>0 && count($validation) < count($directedTaskLanguage->topic->directeds))
                                    <td><span class="badge rounded-pill bg-primary">{{__('অডিও সংগৃহীত')}}</span></td>

                                    @elseif ((count($approve) == count($directedTaskLanguage->topic->directeds)))
                                    <td><span class="badge rounded-pill bg-success">{{__('অনুমোদিত')}}</span></td>
                                    @elseif(count($approve)>0 && count($approve) < count($directedTaskLanguage->topic->directeds))
                                    <td>{{__('যাচাইকৃত')}}</td>

                                    @else
                                    <td><span class="badge rounded-pill bg-danger">{{__('অর্পিত')}}</span></td>
                                    @endif

                                <td class="text-center">
                                    <div class="d-grid gap-2 d-md-block">
                                        {{-- @can('') --}}
                                        <a class="btn btn-info btn-sm text-white" data-toggle="tooltip" data-placement="top" title="Next Page" href="{{route('admin.directed.languages.sentence.list',['task_assign_id'=>$directedTaskLanguage->task_assign_id, 'topic_id'=>$directedTaskLanguage->topic->id] )}}">
                                            {{__('দেখুন')}}
                                        </a>
                                        {{-- @endcan --}}
                                        @can('Data Collection Show')
                                        <a class="btn btn-purple btn-sm text-white" data-toggle="tooltip" data-placement="top" title="Next Page" href="{{route('admin.data_collection.directed.topic',['task_assign_id'=>$directedTaskLanguage->task_assign_id, 'topic_id'=>$directedTaskLanguage->topic->id] )}}">
                                            {{__('ডাটা সংগ্রহ')}}
                                        </a>
                                        @endcan
                                        {{-- @foreach($taskBycollection->directedTasks as $directedTaskTopic)
                                        @if(Auth::user()->hasRole('Data Collector'))
                                        <a class="btn btn-success text-white" data-toggle="tooltip" href="{{route('admin.data_collection.directed.topic', ['task_assign_id'=>$taskBycollection->id, 'topic_id'=>$directedTaskTopic->topic->id ])}}">Data Collection</a>
                                        @endif
                                        @endforeach --}}
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
        } );
    </script>

@endsection

