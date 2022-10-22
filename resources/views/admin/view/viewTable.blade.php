@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="col-md-12 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered" id="data-collection">
                                <thead class="table-dark">
                                <tr>
                                    <th class="align-top" rowspan="2" style="width: 5rem;">{{__('messages.ক্রমিক নং')}}</th>
                                    <th class="align-top" rowspan="2">{{__('messages.ভাষা')}}</th>
                                    <th class="align-top" rowspan="2">{{__('টাইপ')}}</th>
                                    <th class="text-center" colspan="2" style="width: 20rem;">{{__('messages.তথ্য সংগ্রহ')}}</th>
                                    <th class="text-center" colspan="2">{{__('messages.অডিও')}}</th>
                                    <th class="text-center" colspan="2">{{__('messages.অনুবাদ')}}</th>
                                    <th class="text-center" colspan="2">{{__('messages.উচ্চারণ')}}</th>
                                </tr>
                                <tr>
                                    <th>{{__('messages.নির্দেশিত')}}</th>
                                    <th>{{__('messages.স্বতঃস্ফূর্ত')}}</th>
                                    <th>{{__('messages.নির্দেশিত')}}</th>
                                    <th>{{__('messages.স্বতঃস্ফূর্ত')}}</th>
                                    <th>{{__('messages.নির্দেশিত')}}</th>
                                    <th>{{__('messages.স্বতঃস্ফূর্ত')}}</th>
                                    <th>{{__('messages.নির্দেশিত')}}</th>
                                    <th>{{__('messages.স্বতঃস্ফূর্ত')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($taskBycollections as $key=>$taskBycollection)
                                    <tr>
                                        <td>{{++ $key }}</td>
                                        <td>

                                            <div class="row">
                                                <div class="col">
                                                    <span class="bold">{{$taskBycollection->language->name}}</span><br>
                                                    <span class="bold">({{$taskBycollection->district->name}})</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col">
                                                    <span class="small"> {{__('messages.নির্দেশিত')}}({{$taskBycollection->directed_tasks_count}})</span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <span class="small">{{__('messages.স্বতঃস্ফূর্ত')}}({{$taskBycollection->spontaneous_tasks_count}})</span>
                                                </div>
                                            </div>

                                            {{-- <div class="row">
                                                <div class="col" data-toggle="tooltip" data-placement="top" title="Speaker">

                                                    @if($taskBycollection->speakers == !null)
                                                       <label class="" for="speaker_id">{{__('messages.স্পিকার')}}</label>
                                                        @foreach($taskBycollection->speakers as $key => $speaker)
                                                            <span class="text-decoration-none badge rounded-pill bg-info">{{$speaker->name}}</span><br>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div> --}}
                                            {{--<div class="row">
                                                <div class="col">
                                                    @if($taskBycollection->validators == !null)
                                                        <label class="" for="speaker_id">{{__('messages.যাচাইকারী')}}</label>
                                                        @foreach($taskBycollection->validators as $key => $validator)
                                                            <span class="text-decoration-none badge rounded-pill bg-info">{{$validator->name}}</span>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>--}}
                                        </td>
                                        <td>
                                            @foreach($taskBycollection->directedTasks as $directedTaskTopic)
                                                <div class="row">
                                                    <div class="col">
                                                        @if(Auth::user()->hasRole('Data Collector'))
                                                            <a href="{{route('admin.data_collection.directed.topic', ['task_assign_id'=>$taskBycollection->id, 'topic_id'=>$directedTaskTopic->topic->id ])}}" class="text-success">{{$directedTaskTopic->topic->name}}</a>
                                                        @else
                                                            {{$directedTaskTopic->topic->name}}
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($taskBycollection->spontaneousTasks as $spontaneousTaskWord)
                                                <div class="row">
                                                    <div class="col">
                                                        @if(Auth::user()->hasRole('Data Collector'))
                                                            <a href="{{route('admin.data_collection.spontaneous.word', ['task_assign_id'=>$taskBycollection->id, 'spontaneous_id'=>$spontaneousTaskWord->spontaneous_id ])}}" class="text-success">{{$spontaneousTaskWord->spontaneous->word}}</a>
                                                        @else
                                                            {{$spontaneousTaskWord->spontaneous->word}}
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($taskBycollection->directedTasks as $directedTaskTopic)
                                                @php
                                                    if (Auth::user()->hasRole('Data Collector')){
                                                       $directedCollections = \App\Models\DataCollection::where('task_assign_id', $directedTaskTopic->task_assign_id)
                                                                           ->where('type_id', 1)
                                                                           ->where('collector_id', Auth::id())
                                                                           ->whereHas('dcDirected', function ($q) use($directedTaskTopic){
                                                                               $q->where('topic_id', $directedTaskTopic->topic_id);})
                                                                           ->get();
                                                       }else{
                                                       $directedCollections = \App\Models\DataCollection::where('task_assign_id', $directedTaskTopic->task_assign_id)
                                                                           ->where('type_id', 1)
                                                                           ->whereHas('dcDirected', function ($q) use($directedTaskTopic){
                                                                               $q->where('topic_id', $directedTaskTopic->topic_id);})
                                                                           ->get();
                                                       }

                                                @endphp

                                                <div class="row">
                                                    <div class="col">
                                                        <span class="small" data-toggle="tooltip" data-placement="top" title="{{$directedTaskTopic->topic->name}}">
                                                            @if($directedCollections->isEmpty())
                                                                <i class="fa fa-times text-danger"></i>
                                                            @elseif(count($directedCollections) == $directedTaskTopic->topic->directeds_count)
                                                                <i class="fa fa-check text-success"></i>
                                                            @else
                                                                <i class="fa fa-times text-danger"></i>
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>

                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($taskBycollection->spontaneousTasks as $spontaneousTaskWord)
                                                @php
                                                    if (Auth::user()->hasRole('Data Collector')){
                                                    $spontaneousCollections = \App\Models\DataCollection::where('task_assign_id', $spontaneousTaskWord->task_assign_id)
                                                                     ->where('type_id', 2)
                                                                     ->where('collector_id', Auth::id())
                                                                     ->whereHas('dcSpontaneous', function ($q) use($spontaneousTaskWord){
                                                                         $q->where('spontaneous_id', $spontaneousTaskWord->spontaneous_id);
                                                                     })
                                                                     ->get();
                                                    }else{
                                                    $spontaneousCollections = \App\Models\DataCollection::where('task_assign_id', $spontaneousTaskWord->task_assign_id)
                                                                     ->where('type_id', 2)
                                                                     ->whereHas('dcSpontaneous', function ($q) use($spontaneousTaskWord){
                                                                         $q->where('spontaneous_id', $spontaneousTaskWord->spontaneous_id);
                                                                     })
                                                                     ->get();
                                                    }
                                                @endphp
                                                <div class="row">
                                                    <div class="col">
                                                        <span class="small" data-toggle="tooltip" data-placement="top" title="{{$spontaneousTaskWord->spontaneous->word}}">
                                                             @if($spontaneousCollections->isEmpty())
                                                                <i class="fa fa-times text-danger"></i>
                                                            @else
                                                                <i class="fa fa-check text-success"></i>
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($taskBycollection->directedTasks as $directedTaskTopic)
                                                @php
                                                    $directedEnglishField = \App\Models\Directed::where('topic_id', $directedTaskTopic->topic_id)
                                                           ->whereNotNull('english')
                                                           ->get();
                                                @endphp
                                                <div class="row">
                                                    <div class="col">
                                                        <span class="small" data-toggle="tooltip" data-placement="top" title="{{$directedTaskTopic->topic->name}}">
                                                             @if($directedEnglishField->isEmpty())
                                                                <i class="fa fa-times text-danger"></i>
                                                            @elseif(count($directedEnglishField) == $directedTaskTopic->topic->directeds_count)
                                                                <i class="fa fa-check text-success"></i>
                                                            @else
                                                                <i class="fa fa-times text-danger"></i>
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>
                                            @endforeach

                                        </td>
                                        <td>
                                            @foreach($taskBycollection->spontaneousTasks as $spontaneousTaskWord)
                                                @php
                                                    if(Auth::user()->hasRole('Data Collector')){
                                                        $spontaneousEnglish = \App\Models\DataCollection::where('task_assign_id', $spontaneousTaskWord->task_assign_id)
                                                                         ->where('type_id', 2)
                                                                         ->where('collector_id', Auth::id())
                                                                         ->whereHas('dcSpontaneous', function ($q) use($spontaneousTaskWord){
                                                                             $q->where('spontaneous_id', $spontaneousTaskWord->spontaneous_id)
                                                                             ->whereNotNull('english');
                                                                         })
                                                                         ->get();
                                                    }else{
                                                         $spontaneousEnglish = \App\Models\DataCollection::where('task_assign_id', $spontaneousTaskWord->task_assign_id)
                                                                         ->where('type_id', 2)
                                                                         ->whereHas('dcSpontaneous', function ($q) use($spontaneousTaskWord){
                                                                             $q->where('spontaneous_id', $spontaneousTaskWord->spontaneous_id)
                                                                             ->whereNotNull('english');
                                                                         })
                                                                         ->get();
                                                    }

                                                @endphp
                                                <div class="row">
                                                    <div class="col">
                                                        <span class="small" data-toggle="tooltip" data-placement="top" title="{{$spontaneousTaskWord->spontaneous->word}}">
                                                            @if($spontaneousEnglish->isEmpty())
                                                                <i class="fa fa-times text-danger"></i>
                                                            @else
                                                                <i class="fa fa-check text-success"></i>
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($taskBycollection->directedTasks as $directedTaskTopic)
                                                @php
                                                    if(Auth::user()->hasRole('Data Collector')){
                                                           $directedCollectionTranscription = \App\Models\DataCollection::where('task_assign_id', $directedTaskTopic->task_assign_id)
                                                                        ->where('type_id', 1)
                                                                        ->where('collector_id', Auth::id())
                                                                        ->whereHas('dcDirected', function ($q) use($directedTaskTopic){
                                                                            $q->where('topic_id', $directedTaskTopic->topic_id);})
                                                                        ->whereHas('dcDirected.dcSentence', function ($q0){
                                                                             $q0->whereNotNull('transcription');
                                                                         })
                                                                        ->get();
                                                       }else{
                                                           $directedCollectionTranscription = \App\Models\DataCollection::where('task_assign_id', $directedTaskTopic->task_assign_id)
                                                                        ->where('type_id', 1)
                                                                        ->whereHas('dcDirected', function ($q) use($directedTaskTopic){
                                                                            $q->where('topic_id', $directedTaskTopic->topic_id);})
                                                                        ->whereHas('dcDirected.dcSentence', function ($q0){
                                                                             $q0->whereNotNull('transcription');
                                                                         })
                                                                        ->get();
                                                       }

                                                @endphp
                                                <div class="row">
                                                    <div class="col">
                                                        <span class="small" data-toggle="tooltip" data-placement="top" title="{{$directedTaskTopic->topic->name}}">
                                                            @if($directedCollectionTranscription->isEmpty())
                                                                <i class="fa fa-times text-danger"></i>
                                                            @elseif(count($directedCollectionTranscription) == $directedTaskTopic->topic->directeds_count)
                                                                <i class="fa fa-check text-success"></i>
                                                            @else
                                                                <i class="fa fa-times text-danger"></i>
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>
                                            @endforeach

                                        </td>
                                        <td>
                                            @foreach($taskBycollection->spontaneousTasks as $spontaneousTaskWord)
                                                @php
                                                    if(Auth::user()->hasRole('Data Collector')){
                                                       $spontaneousTrancription = \App\Models\DataCollection::where('task_assign_id', $spontaneousTaskWord->task_assign_id)
                                                                        ->where('type_id', 2)
                                                                        ->where('collector_id', Auth::id())
                                                                        ->whereHas('dcSpontaneous', function ($q) use($spontaneousTaskWord){
                                                                            $q->where('spontaneous_id', $spontaneousTaskWord->spontaneous_id)
                                                                            ->whereNotNull('transcription');
                                                                        })
                                                                        ->get();
                                                   }else{
                                                        $spontaneousTrancription = \App\Models\DataCollection::where('task_assign_id', $spontaneousTaskWord->task_assign_id)
                                                                        ->where('type_id', 2)
                                                                        ->whereHas('dcSpontaneous', function ($q) use($spontaneousTaskWord){
                                                                            $q->where('spontaneous_id', $spontaneousTaskWord->spontaneous_id)
                                                                            ->whereNotNull('transcription');
                                                                        })
                                                                        ->get();
                                                   }

                                                @endphp
                                                <div class="row">
                                                    <div class="col">
                                                        <span class="small" data-toggle="tooltip" data-placement="top" title="{{$spontaneousTaskWord->spontaneous->word}}">
                                                            @if($spontaneousTrancription->isEmpty())
                                                                <i class="fa fa-times text-danger"></i>
                                                            @else
                                                                <i class="fa fa-check text-success"></i>
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $taskBycollections->links('vendor.pagination.custom') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
{{-- @endsection --}}
