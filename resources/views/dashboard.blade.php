@extends('layouts.app')

@section('title', 'ড্যাশবোর্ড')

@section('content')
    <div class="container-fluid px-0">
        <div class="card mb-3">
            <div class="card-header">{{__('messages.ড্যাশবোর্ড')}}</div>
            <div class="card-body">
                <div class="row mb-3">
                    @if(Auth::user()->user_type == 4)
                        <div class="col-sm-6 col-lg-3">
                            <div class="card bg-danger -new mb-4">
                                <div class="card-body p-3 d-flex align-items-center">
                                    <div class="bg-white text-info p-3 me-3 rounded-3">
                                        <svg class="icon icon-xl">
                                            <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-storage')}}"></use>
                                        </svg>
                                    </div>
                                    <div class="custom-hover">
                                        <div class="fs-6 fw-semibold text-white">
                                            @if(app()->getLocale() == 'bn')
                                                {{isset($totalLang)? Converter::en2bn($totalLang):0}}
                                            @else
                                                {{isset($totalLang)? $totalLang:0}}
                                            @endif
                                            {{-- /
                                             @if(app()->getLocale() == 'bn')
                                                 {{isset($totalApproved)? Converter::en2bn($totalApproved): 0}}
                                             @else
                                                 {{isset($totalApproved)? $totalApproved: 0}}
                                             @endif--}}

                                        </div>
                                        <div class="text-white">
                                            <a class="text-decoration-none text-white" href="{{route('admin.languageList')}}">{{__('messages.অর্পিত ভাষা')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="col-sm-6 col-lg-3">
                            <div class="card bg-primary -new mb-4">
                                <div class="card-body p-3 d-flex align-items-center">
                                    <div class="bg-white text-info p-3 me-3 rounded-3">
                                        <svg class="icon icon-xl">
                                            <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-storage')}}"></use>
                                        </svg>
                                    </div>
                                    <div class="custom-hover">
                                        <div class="fs-6 fw-semibold text-white">
                                            <p class="card-text text-center mb-0 custom-hover">
                                                <a class="text-decoration-none text-white">
                                                    {{__('messages.নির্দেশিত')}}
                                                    @if(app()->getLocale() == 'bn')
                                                        {{isset($totalDirected)? Converter::en2bn($totalDirected):0}}/{{isset($totalDirPending)? Converter::en2bn( $totalDirPending):0}}
                                                    @else
                                                        {{isset($totalDirected)? $totalDirected:0}}/{{isset($totalDirPending)? $totalDirPending:0}}
                                                    @endif
                                                </a>
                                            </p>
                                            <p class="card-text text-center mb-0 custom-hover">
                                                <a class="text-decoration-none text-white">
                                                    {{__('messages.স্বতঃস্ফূর্ত')}}
                                                    @if(app()->getLocale() == 'bn')
                                                        {{isset($totalSpon)? Converter::en2bn($totalSpon):0}}/{{isset( $totalPendingSpon)? Converter::en2bn( $totalPendingSpon):0}}
                                                    @else
                                                        {{isset($totalSpon)? $totalSpon:0}}/{{isset( $totalPendingSpon)?  $totalPendingSpon:0}}
                                                    @endif
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        {{-- <div class="col-sm-6 col-lg-3">
                            <div class="card bg-info-new mb-4">
                                <div class="card-body p-3 d-flex align-items-center">
                                    <div class="bg-white text-info p-3 me-3 rounded-3">
                                        <svg class="icon icon-xl">
                                            <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-storage')}}"></use>
                                        </svg>
                                    </div>
                                    <div class="custom-hover">
                                        <div class="fs-6 fw-semibold text-white">
                                            @if(app()->getLocale() == 'bn')
                                                {{isset($totalCollections)? Converter::en2bn($totalCollections):0}}
                                            @else
                                                {{isset($totalCollections)? $totalCollections:0}}
                                            @endif --}}
                                            {{-- /
                                             @if(app()->getLocale() == 'bn')
                                                 {{isset($totalApproved)? Converter::en2bn($totalApproved): 0}}
                                             @else
                                                 {{isset($totalApproved)? $totalApproved: 0}}
                                             @endif--}}

                                        {{-- </div>
                                        <div class="text-white">
                                            <a class="text-decoration-none text-white" href="{{route('admin.users.index')}}">{{__('messages.তথ্য সংগ্রহ')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}


                        <div class="col-sm-6 col-lg-3">
                            <div class="card bg-navy mb-4">
                                <div class="card-body p-3 d-flex align-items-center">
                                    <div class="bg-white text-info p-3 me-3 rounded-3">
                                        <svg class="icon icon-xl">
                                            <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-view-stream')}}"></use>
                                        </svg>
                                    </div>
                                    <div class="custom-hover">
                                        <div class="fs-6 fw-semibold text-white">
                                            @if(app()->getLocale() == 'bn')
                                                {{isset($totalPending)? Converter::en2bn($totalPending): 0}}
                                            @else
                                                {{isset($totalPending)? $totalPending: 0}}
                                            @endif
                                        </div>
                                        <div class="text-white">
                                            <a class="text-decoration-none text-white" href="{{route('admin.data_collections.userpending.list')}}">{{__('messages.বিবেচনাধীন ডাটা')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-ms-6 col-lg-3">
                            <div class="card bg-success mb-4">
                                <div class="card-body p-3 d-flex align-items-center">
                                    <div class="bg-white text-success p-3 me-3 rounded-3">
                                        <svg class="icon icon-xl">
                                            <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-task')}}"></use>
                                        </svg>
                                    </div>
                                    <div class="custom-hover">
                                        <div class="fs-6 fw-semibold text-white">
                                            @if(app()->getLocale() == 'bn')
                                                {{isset($totalApproved)? Converter::en2bn($totalApproved): 0}}
                                            @else
                                                {{isset($totalApproved)? $totalApproved: 0}}
                                            @endif
                                        </div>
                                        <div class="text-white">
                                            <a class="text-decoration-none text-white" href="{{route('admin.data_collections.userapproval.list')}}">{{__('messages.অনুমোদিত ডেটা')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="card bg-purple mb-4">
                                <div class="card-body p-3 d-flex align-items-center">
                                    <div class="bg-white text-primary p-3 me-3 rounded-3">
                                        <svg class="icon icon-xl">
                                            <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-people')}}"></use>
                                        </svg>
                                    </div>
                                    <div class="custom-hover">
                                        <div class="fs-6 fw-semibold text-white">
                                            @if(app()->getLocale() == 'bn')
                                                {{isset($totalSpeakers)? Converter::en2bn($totalSpeakers): 0}}
                                            @else
                                                {{isset($totalSpeakers)? $totalSpeakers: 0}}
                                            @endif
                                        </div>
                                        <div class="text-white">
                                            <a class="text-decoration-none text-white" href="{{route('admin.speakers.index')}}">{{__('messages.স্পিকার')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif(Auth::user()->hasRole('Linguist'))
                        <div class="col-sm-6 col-lg-3">
                            <div class="card bg-info-new mb-4">
                                <div class="card-body p-3 d-flex align-items-center">
                                    <div class="bg-white text-info p-3 me-3 rounded-3">
                                        <svg class="icon icon-xl">
                                            <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-language')}}"></use>
                                        </svg>
                                    </div>
                                    <div class="custom-hover">
                                        <div class="fs-6 fw-semibold text-white">
                                            @if(app()->getLocale() == 'bn')
                                                {{isset($totalLanguages)? Converter::en2bn($totalLanguages):0}}
                                            @else
                                                {{isset($totalLanguages)? $totalLanguages:0}}
                                            @endif
                                        </div>
                                        <div class="text-white">
                                            <a class="text-decoration-none text-white" href="{{route('admin.languages.index')}}">{{__('messages.ভাষা')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="card bg-purple mb-4">
                                <div class="card-body p-3 d-flex align-items-center">
                                    <div class="bg-white text-primary p-3 me-3 rounded-3">
                                        <svg class="icon icon-xl">
                                            <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-hamburger-menu')}}"></use>
                                        </svg>
                                    </div>
                                    <div class="custom-hover">
                                        <div class="fs-6 fw-semibold text-white">
                                            @if(app()->getLocale() == 'bn')
                                                {{isset($totalDirectedTopics)? Converter::en2bn($totalDirectedTopics): 0}}
                                            @else
                                                {{isset($totalDirectedTopics)? $totalDirectedTopics: 0}}
                                            @endif

                                        </div>
                                        <div class="text-white">
                                            <a class="text-decoration-none text-white" href="{{route('admin.directeds.index')}}">{{__('messages.নির্দেশিত')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="card bg-navy mb-4">
                                <div class="card-body p-3 d-flex align-items-center">
                                    <div class="bg-white text-info p-3 me-3 rounded-3">
                                        <svg class="icon icon-xl">
                                            <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-list')}}"></use>
                                        </svg>
                                    </div>
                                    <div class="custom-hover">
                                        <div class="fs-6 fw-semibold text-white">
                                            @if(app()->getLocale() == 'bn')
                                                {{isset($totalDirectedSentences)? Converter::en2bn($totalDirectedSentences): 0}}
                                            @else
                                                {{isset($totalDirectedSentences)? $totalDirectedSentences: 0}}
                                            @endif

                                        </div>
                                        <div class="text-white">
                                            <a class="text-decoration-none text-white" {{--href="{{route('admin.data_collections.index')}}"--}}>{{__('messages.বাক্য')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-ms-6 col-lg-3">
                            <div class="card bg-success mb-4">
                                <div class="card-body p-3 d-flex align-items-center">
                                    <div class="bg-white text-success p-3 me-3 rounded-3">
                                        <svg class="icon icon-xl">
                                            <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-tag')}}"></use>
                                        </svg>
                                    </div>
                                    <div class="custom-hover">
                                        <div class="fs-6 fw-semibold text-white">
                                            @if(app()->getLocale() == 'bn')
                                                {{isset($totalSpontaneous)? Converter::en2bn($totalSpontaneous): 0}}
                                            @else
                                                {{isset($totalSpontaneous)? $totalSpontaneous: 0}}
                                            @endif

                                        </div>
                                        <div class="text-white">
                                            <a class="text-decoration-none text-white" href="{{route('admin.spontaneouses.index')}}">{{__('messages.স্বতঃস্ফূর্ত')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-sm-6 col-lg-3">
                            <div class="card bg-info-new mb-4">
                                <div class="card-body p-3 d-flex align-items-center">
                                    <div class="bg-white text-info p-3 me-3 rounded-3">
                                        <svg class="icon icon-xl">
                                            <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-people')}}"></use>
                                        </svg>
                                    </div>
                                    <div class="custom-hover">

                                        <div class="fs-6 fw-semibold text-white">
                                            @if(app()->getLocale() == 'bn')
                                                {{isset($allUsers)? Converter::en2bn($allUsers):0}}/{{isset($login)? Converter::en2bn($login):0}}
                                            @else
                                                {{isset($allUsers)? $allUsers:0}}/{{isset($login)? $login:0}}
                                            @endif
                                        </div>
                                        <div class="text-white">
                                            <a class="text-decoration-none text-white" {{-- href="{{route('admin.users.index')}}" --}}>{{('কর্মকর্তা')}}/{{('উপস্থিতি')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="card bg-purple mb-4">
                                <div class="card-body p-3 d-flex align-items-center">
                                    <div class="bg-white text-primary p-3 me-3 rounded-3">
                                        <svg class="icon icon-xl">
                                            <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-storage')}}"></use>
                                        </svg>
                                    </div>
                                    <div class="custom-hover">
                                        <div class="fs-6 fw-semibold text-white">
                                            @if(app()->getLocale() == 'bn')
                                                {{isset($totalCollectors)? Converter::en2bn($totalCollectors): 0}}
                                            @else
                                                {{isset($totalCollectors)? $totalCollectors: 0}}
                                            @endif

                                        </div>
                                        <div class="text-white">
                                            <a class="text-decoration-none text-white" href="{{route('admin.data_collectors.index')}}">{{__('কালেকশন')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="card bg-navy mb-4">
                                <div class="card-body p-3 d-flex align-items-center">
                                    <div class="bg-white text-info p-3 me-3 rounded-3">
                                        <svg class="icon icon-xl">
                                            <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-view-stream')}}"></use>
                                        </svg>
                                    </div>
                                    <div class="custom-hover">
                                        <div class="fs-6 fw-semibold text-white">
                                            @if(app()->getLocale() == 'bn')
                                                {{isset($totalPending)? Converter::en2bn($totalPending): 0}}
                                            @else
                                                {{isset($totalPending)? $totalPending: 0}}
                                            @endif
                                        </div>
                                        <div class="text-white">

                                            <a class="text-decoration-none text-white" href="{{route('admin.data_collections.userpending.list')}}">{{__('messages.বিবেচনাধীন ডাটা')}}</a>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-ms-6 col-lg-3">
                            <div class="card bg-success mb-4">
                                <div class="card-body p-3 d-flex align-items-center">
                                    <div class="bg-white text-success p-3 me-3 rounded-3">
                                        <svg class="icon icon-xl">
                                            <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-task')}}"></use>
                                        </svg>
                                    </div>
                                    <div class="custom-hover">
                                        <div class="fs-6 fw-semibold text-white">
                                            @if(app()->getLocale() == 'bn')
                                                {{isset($totalApproved)? Converter::en2bn($totalApproved): 0}}
                                            @else
                                                {{isset($totalApproved)? $totalApproved: 0}}
                                            @endif
                                        </div>
                                        <div class="text-white">
                                            <a class="text-decoration-none text-white" {{--href="{{route('admin.data_collections.index')}}"--}}>{{__('messages.অনুমোদিত ডেটা')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
                @if(Auth::user()->hasRole('Data Collector'))
                    <div class="card mb-3">
                        <div class="card-header">
                            <ul class="nav nav-pills card-header-pills justify-content-between">
                                <li class="nav-item">{{__('messages.ভাষা অনুসারে টাস্ক অ্যাসাইন')}}</li>
                                <li class="nav-item">
                                    <a class="btn btn-success btn-sm text-white" href="{{route('admin.task-assign.language.list')}}">
                                        {{__('View All')}}
                                    </a>
                                </li>
                            </ul>

                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach($taskAssignByLanguage as $taskAssign)
                                    <div class="col-xl-2">
                                        @php
                                            $total=0;
                                        @endphp
                                        @foreach($taskAssign->directedTasks as $t)
                                            @php
                                                $num = $t->topic->directeds_count;
                                                $total = $num + $total;
                                                $directedCollectionAudio = \App\Models\DataCollection::where('task_assign_id', $t->task_assign_id)
                                                                                                                           ->where('type_id', 1)
                                                                                                                           ->whereHas('dcDirected', function ($q) use($t){
                                                                                                                               $q->where('topic_id', $t->topic_id);})
                                                                                                                           ->whereHas('dcDirected.dcSentence', function ($q0){
                                                                                                                                $q0->whereNotNull('audio');
                                                                                                                            })
                                                                                                                           ->count();
                                                                                                                        //    echo $directedCollectionAudio;
                                                $totalCollects=0;

                                                $totalDirect=$num;
                                                // echo $totalDirect;

                                                if( $directedCollectionAudio==$totalDirect)

                                                //  $totalCollects=0;
                                                //  $totalDirect=$taskAssign->directed_tasks_count;
                                                ++$totalCollects;
                                                @endphp
                                        @endforeach
                                                  @php
                                                  $totalSpontCollects=0;
                                                  @endphp
                                                {{-- @foreach($taskAssign->spontaneousTasks as $v) --}}
                                                    @php
                                                $spontaneousCollectAudio = \App\Models\DataCollection::where('task_assign_id', $taskAssign->task_assign_id)
                                                                                    ->where('type_id', 2)
                                                                                    ->whereHas('dcSpontaneous', function ($q) use($taskAssign){
                                                                                        $q->where('spontaneous_id', $taskAssign->spontaneous_id)
                                                                                        ->whereNotNull('audio');
                                                                                    })
                                                                                    ->count();
                                                                                    // echo $spontaneousCollectAudio;
                                                $numSpont = $taskAssign->spontaneous_tasks_count;
                                                // echo $numSpont;

                                                $totalSpont=$numSpont;

                                                if( $spontaneousCollectAudio==$totalSpont)

                                                //  $totalCollects=0;
                                                //  $totalDirect=$taskAssign->directed_tasks_count;
                                                ++ $totalSpontCollects;
                                                // echo $totalSpontCollects;
                                                @endphp

                                                {{-- @endforeach --}}

                                        {{-- @endforeach --}}

                                        <div class="card text-white @if($taskAssign->collections->isEmpty()) bg-danger @elseif(count($taskAssign->collections) == $total+$taskAssign->spontaneous_tasks_count ) bg-success approve @else bg-primary-new @endif mb-3">
                                            {{-- <div class="card text-white @if($taskAssign->collections->isEmpty()) bg-danger @elseif(count($taskAssign->collections) != $total+$taskAssign->spontaneous_tasks_count ) bg-primary-new @endif mb-3"> --}}
                                            <div class="card-body" >
                                                <h5 class="card-title text-center">{{$taskAssign->language->name}}</h5>
                                                {{-- @foreach($taskAssign->language->subLanguages as $subLang)
                                                <h5 class="card-title text-center">{{$subLang->sub_name}}</h5>
                                                @endforeach --}}
                                                <h6 class="card-subtitle text-center mb-2">({{$taskAssign->district->name}})</h6>
                                                <p class="card-text text-center mb-0 custom-hover">
                                                    <a class="text-white text-decoration-none" href="{{route('admin.directed.language.tasks.list', $taskAssign->id)}}">
                                                        {{__('messages.নির্দেশিত')}}
                                                        @if(app()->getLocale() == 'bn')
                                                            ({{Converter::en2bn($taskAssign->directed_tasks_count)}}/{{Converter::en2bn( $totalCollects)}})
                                                        @else
                                                            ({{$taskAssign->directed_tasks_count}})
                                                           {{-- ({{count($taskAssign->collections)}}) --}}
                                                        @endif
                                                    </a>
                                                </p>
                                                <p class="card-text text-center custom-hover" id="scrollToDiv">
                                                    <a class="text-white text-decoration-none" href="{{route('admin.spontaneous.language.tasks.list', $taskAssign->id)}}">
                                                        {{__('messages.স্বতঃস্ফূর্ত')}}
                                                        @if(app()->getLocale() == 'bn')
                                                            ({{Converter::en2bn($taskAssign->spontaneous_tasks_count)}}/{{Converter::en2bn( $totalSpontCollects)}})
                                                        @else
                                                            ({{$taskAssign->spontaneous_tasks_count}})
                                                        @endif
                                                    </a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    {{-- approve task --}}
                    <div class="card mb-3">
                        <div class="card-header">
                            <ul class="nav nav-pills card-header-pills justify-content-between">
                                <li class="nav-item">{{__('ভাষা অনুসারে তথ্য সংগ্রহ')}}</li>

                            </ul>

                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach($taskAssignByLanguage as $taskAssign)
                                    <div class="col-xl-2">
                                        {{-- @php
                                            $total=0;
                                        @endphp
                                        @foreach($taskAssign->directedTasks as $t)
                                            @php
                                                $num = $t->topic->directeds_count;
                                                $total = $num + $total;
                                                $approve=count($taskAssign->collections) == $total+$taskAssign->spontaneous_tasks_count;
                                            @endphp
                                        @endforeach --}}
                                        @php
                                            $total=0;
                                        @endphp
                                        @foreach($taskAssign->directedTasks as $t)
                                            @php
                                                $num = $t->topic->directeds_count;
                                                $total = $num + $total;
                                                $directedCollectionAudio = \App\Models\DataCollection::where('task_assign_id', $t->task_assign_id)
                                                                                                                           ->where('type_id', 1)
                                                                                                                           ->whereHas('dcDirected', function ($q) use($t){
                                                                                                                               $q->where('topic_id', $t->topic_id);})
                                                                                                                           ->whereHas('dcDirected.dcSentence', function ($q0){
                                                                                                                                $q0->whereNotNull('audio');
                                                                                                                            })
                                                                                                                           ->count();
                                                                                                                        //    echo $directedCollectionAudio;
                                                $totalCollects=0;

                                                $totalDirect=$num;
                                                // echo $totalDirect;

                                                if( $directedCollectionAudio==$totalDirect)

                                                //  $totalCollects=0;
                                                //  $totalDirect=$taskAssign->directed_tasks_count;
                                                ++$totalCollects;
                                                @endphp
                                        @endforeach
                                                  @php
                                                  $totalSpontCollects=0;
                                                  @endphp
                                                @foreach($taskAssign->spontaneousTasks as $v)
                                                    @php
                                                $spontaneousCollectAudio = \App\Models\DataCollection::where('task_assign_id', $v->task_assign_id)
                                                                                    ->where('type_id', 2)
                                                                                    ->whereHas('dcSpontaneous', function ($q) use($v){
                                                                                        $q->where('spontaneous_id', $v->spontaneous_id)
                                                                                        ->whereNotNull('audio');
                                                                                    })
                                                                                    ->count();
                                                                                    // echo $spontaneousCollectAudio;
                                                $numSpont = $v->spontaneous_tasks_count;
                                                // echo $numSpont;

                                                $totalSpont=$numSpont;
                                                // echo $totalSpont;

                                                if( $spontaneousCollectAudio==$totalSpont)

                                                //  $totalCollects=0;
                                                //  $totalDirect=$taskAssign->directed_tasks_count;
                                                ++ $totalSpontCollects;
                                                @endphp
                                                @endforeach
                                        {{-- @if(!empty($approve)) --}}
                                        <div class="card text-white @if($taskAssign->collections->isEmpty()) bg-danger assign @elseif(count($taskAssign->collections) == $total+$taskAssign->spontaneous_tasks_count ) bg-success @else bg-primary-new progress @endif mb-3">
                                            {{-- <div class="card text-white @if($taskAssign->collections->isEmpty()) bg-danger @elseif(count($taskAssign->collections) != $total+$taskAssign->spontaneous_tasks_count ) bg-primary-new @endif mb-3"> --}}
                                            <div class="card-body" >
                                                <h5 class="card-title text-center">{{$taskAssign->language->name}}</h5>
                                                {{-- @foreach($taskAssign->language->subLanguages as $subLang)
                                                <h5 class="card-title text-center">{{$subLang->sub_name}}</h5>
                                                @endforeach --}}
                                                <h6 class="card-subtitle text-center mb-2">({{$taskAssign->district->name}})</h6>
                                                <p class="card-text text-center mb-0 custom-hover">
                                                    <a class="text-white text-decoration-none" href="{{route('admin.directed.language.tasks.list', $taskAssign->id)}}">
                                                        {{__('messages.নির্দেশিত')}}
                                                        @if(app()->getLocale() == 'bn')
                                                            ({{Converter::en2bn($taskAssign->directed_tasks_count)}}/{{Converter::en2bn( $totalCollects)}})
                                                        @else
                                                            ({{$taskAssign->directed_tasks_count}})
                                                           {{-- ({{count($taskAssign->collections)}}) --}}
                                                        @endif
                                                    </a>
                                                </p>
                                                <p class="card-text text-center custom-hover" id="scrollToDiv">
                                                    <a class="text-white text-decoration-none" href="{{route('admin.spontaneous.language.tasks.list', $taskAssign->id)}}">
                                                        {{__('messages.স্বতঃস্ফূর্ত')}}
                                                        @if(app()->getLocale() == 'bn')
                                                            ({{Converter::en2bn($taskAssign->spontaneous_tasks_count)}}/{{Converter::en2bn( $totalSpontCollects)}})
                                                        @else
                                                            ({{$taskAssign->spontaneous_tasks_count}})
                                                        @endif
                                                    </a>
                                                </p>
                                            </div>
                                        </div>
                                        {{-- @endif --}}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    {{-- end approvr task  --}}

                    @elseif(Auth::user()->hasRole(['Linguist']))
                    <div class="card mb-3">
                        <div class="card-header">
                            <ul class="nav nav-pills card-header-pills justify-content-between">
                                <li class="nav-item">{{__('messages.ভাষা অনুসারে টাস্ক অ্যাসাইন')}}</li>
                                {{-- <li class="nav-item">
                                    <a class="btn btn-success btn-sm text-white" href="{{route('admin.task-assign.language.list')}}">
                                        {{__('View All')}}
                                    </a>
                                </li> --}}
                            </ul>

                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach($taskAssignByLinguists as $linguistTaskAssign)
                                    <div class="col-xl-2">
                                        @php
                                            $total=0;
                                        @endphp
                                        @foreach($linguistTaskAssign->directedTasks as $t)
                                            @php
                                                $num = $t->topic->directeds_count;
                                                $total = $num + $total;
                                            @endphp
                                        @endforeach

                                        <div class="card text-white @if($linguistTaskAssign->collections->isEmpty()) bg-danger @elseif(count($linguistTaskAssign->collections) == $total+$linguistTaskAssign->spontaneous_tasks_count ) bg-success @else bg-primary-new @endif mb-3">
                                            <div class="card-body" >
                                                <h5 class="card-title text-center">{{$linguistTaskAssign->language->name}}</h5>
                                                <h6 class="card-subtitle text-center mb-2">({{$linguistTaskAssign->district->name}})</h6>
                                                <p class="card-text text-center mb-0 custom-hover">
                                                    <a class="text-white text-decoration-none" href="{{route('admin.directed.language.tasks.list', $linguistTaskAssign->id)}}">
                                                        {{__('messages.নির্দেশিত')}}
                                                        @if(app()->getLocale() == 'bn')
                                                            ({{Converter::en2bn($linguistTaskAssign->directed_tasks_count)}})
                                                        @else
                                                            ({{$linguistTaskAssign->directed_tasks_count}})
                                                        @endif
                                                    </a>
                                                </p>
                                                <p class="card-text text-center custom-hover" id="scrollToDiv">
                                                    <a class="text-white text-decoration-none" href="{{route('admin.spontaneous.language.tasks.list', $linguistTaskAssign->id)}}">
                                                        {{__('messages.স্বতঃস্ফূর্ত')}}
                                                        @if(app()->getLocale() == 'bn')
                                                            ({{Converter::en2bn($linguistTaskAssign->spontaneous_tasks_count)}})
                                                        @else
                                                            ({{$linguistTaskAssign->spontaneous_tasks_count}})
                                                        @endif
                                                    </a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @elseif(Auth::user()->hasRole(['Validator']))
                    <div class="card mb-3">
                        <div class="card-header">
                            <ul class="nav nav-pills card-header-pills justify-content-between">
                                <li class="nav-item">{{__('messages.ভাষা অনুসারে টাস্ক অ্যাসাইন')}}</li>
                                <li class="nav-item">
                                    <a class="btn btn-success btn-sm text-white" href="{{route('admin.task-assign.language.list')}}">
                                        {{__('View All')}}
                                    </a>
                                </li>
                            </ul>

                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach($taskAssignByValidators as $validatorTaskAssign)
                                    <div class="col-xl-2">
                                        @php
                                            $total=0;
                                        @endphp
                                        @foreach($validatorTaskAssign->directedTasks as $t)
                                            @php
                                                $num = $t->topic->directeds_count;
                                                $total = $num + $total;
                                            @endphp
                                        @endforeach

                                        <div class="card text-white @if($validatorTaskAssign->collections->isEmpty()) bg-danger @elseif(count($validatorTaskAssign->collections) == $total+$validatorTaskAssign->spontaneous_tasks_count ) bg-success @else bg-primary-new @endif mb-3">
                                            <div class="card-body" >
                                                <h5 class="card-title text-center">{{$validatorTaskAssign->language->name}}</h5>
                                                <h6 class="card-subtitle text-center mb-2">({{$validatorTaskAssign->district->name}})</h6>
                                                <p class="card-text text-center mb-0 custom-hover">
                                                    <a class="text-white text-decoration-none" href="{{route('admin.directed.language.tasks.list', $validatorTaskAssign->id)}}">
                                                        {{__('messages.নির্দেশিত')}}
                                                        @if(app()->getLocale() == 'bn')
                                                            ({{Converter::en2bn($validatorTaskAssign->directed_tasks_count)}})
                                                        @else
                                                            ({{$validatorTaskAssign->directed_tasks_count}})
                                                        @endif
                                                    </a>
                                                </p>
                                                <p class="card-text text-center custom-hover" id="scrollToDiv">
                                                    <a class="text-white text-decoration-none" href="{{route('admin.spontaneous.language.tasks.list', $validatorTaskAssign->id)}}">
                                                        {{__('messages.স্বতঃস্ফূর্ত')}}
                                                        @if(app()->getLocale() == 'bn')
                                                            ({{Converter::en2bn($validatorTaskAssign->spontaneous_tasks_count)}})
                                                        @else
                                                            ({{$validatorTaskAssign->spontaneous_tasks_count}})
                                                        @endif
                                                    </a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card mb-3">
                        <div class="card-header">{{__('messages.ভাষা অনুসারে টাস্ক অ্যাসাইন')}}</div>
                        <div class="card-body">
                            <div class="row">
                                @foreach($taskAssignByLanguage as $taskAssign)
                                    <div class="col-xl-2">
                                        <div class="card text-white bg-primary-new mb-3">
                                            <div class="card-body" >
                                                <h5 class="card-title text-center">
                                                    <p class="card-text text-center mb-0 custom-hover">
                                                        <a class="text-white text-decoration-none" href="">
                                                            {{$taskAssign->language->name}}
                                                        </a>
                                                    </p>
                                                </h5>
                                                {{-- <p class="card-text text-center mb-0 custom-hover">
                                                    @if(app()->getLocale() == 'bn')
                                                        {{isset($taskAssign->task_assign_count)? Converter::en2bn($taskAssign->task_assign_count): 0}}
                                                    @else
                                                        {{isset($taskAssign->task_assign_count)? $taskAssign->task_assign_count: 0}}
                                                    @endif

                                                </p> --}}
                                                {{--@foreach($taskAssign->taskAssign as $item)
                                                <p class="card-text text-center mb-0 custom-hover">
                                                    <a class="text-white text-decoration-none" --}}{{--href="{{route('admin.directed.language.tasks.list', $taskAssign->id)}}"--}}{{-->
                                                        নির্দেশিত({{$item->directed_tasks_count}})
                                                    </a>
                                                </p>
                                                <p class="card-text text-center custom-hover" id="scrollToDiv">
                                                    <a class="text-white text-decoration-none" --}}{{--href="{{route('admin.spontaneous.language.tasks.list', $taskAssign->id)}}"--}}{{-->
                                                        স্বতঃস্ফূর্ত({{$item->spontaneous_tasks_count}})
                                                    </a>
                                                </p>
                                                @endforeach--}}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
                @if(Auth::user()->hasRole(['Manager']))
                <div class="card mb-3">
                    <div class="card-header">
                        <ul class="nav nav-pills card-header-pills justify-content-between">
                            <li class="nav-item">{{__('messages.আজকের তথ্য সংগ্রহ')}}</li>

                        </ul>

                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($todayDataCollects as $todayData)
                                <div class="col-xl-2">
                                    {{-- @php
                                        $total=0;
                                    @endphp
                                    @foreach($todayData->directedTasks as $t)
                                        @php
                                            $num = $t->topic->directeds_count;
                                            $total = $num + $total;
                                        @endphp
                                    @endforeach --}}

                                    <div class="card text-white bg-primary-new mb-3">
                                        <div class="card-body" >
                                            <h6 class="card-title text-center">{{$todayData->collector->name}}</h6>
                                            <h5 class="card-title text-center">{{$todayData->language->name}}</h5>
                                            <h6 class="card-subtitle text-center mb-2">({{$todayData->district->name}})</h6>
                                            <p class="card-text text-center mb-0 custom-hover">
                                                <a class="text-white text-decoration-none" href="{{route('admin.directed.language.tasks.list', $todayData->id)}}">
                                                    {{__('messages.নির্দেশিত')}}
                                                    @if(app()->getLocale() == 'bn')
                                                        ({{Converter::en2bn($todayData->taskAssign->directed_tasks_count)}})
                                                    @else
                                                        ({{$todayData->taskAssign->directed_tasks_count}})
                                                    @endif
                                                </a>
                                            </p>
                                            <p class="card-text text-center custom-hover" id="scrollToDiv">
                                                <a class="text-white text-decoration-none" href="{{route('admin.spontaneous.language.tasks.list', $todayData->id)}}">
                                                    {{__('messages.স্বতঃস্ফূর্ত')}}
                                                    @if(app()->getLocale() == 'bn')
                                                        ({{Converter::en2bn($todayData->spontaneous_tasks_count)}})
                                                    @else
                                                        ({{$todayData->spontaneous_tasks_count}})
                                                    @endif
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
                <div class="row mb-3" >
                    @if(Auth::user()->hasRole('Data Collector') || Auth::user()->hasRole('Linguist') || Auth::user()->hasRole('Validator'))


                        <div class="col-md-12 col-sm-12">
                            @if(Auth::user()->hasRole('Data Collector'))
                            <div class="card">
                                <div class="card-header">
                                    {{__('messages.আজকের তথ্য সংগ্রহ')}} <span class="small">(
                                        @if(app()->getLocale() == 'bn')
                                            {{isset($todaycollections)? Converter::en2bn($todaycollections): 0}}
                                        @else
                                            {{isset($todaycollections)? $todaycollections: 0}}
                                        @endif
                                       )</span>
                                </div>
                                <div class="card-body">
                                    @forelse($todayDataCollections as $key =>$todayDataCollection)
                                        <ul class="list-group list-group-horizontal mb-3">
                                            <li class="list-group-item" style="width: 12rem;">
                                                <div class="row">
                                                    <div class="col">
                                                        <a href="" class="text-decoration-none text-dark"><strong>{{__('messages.ভাষাঃ')}} {{$todayDataCollection->language->name}}</strong></a>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <a href="#" class="text-decoration-none text-dark"><span class="small">{{__('messages.ভাষার ধরনঃ')}} {{($todayDataCollection->type_id== 1)? 'নির্দেশিত':'স্বতঃস্ফূর্ত'}} </span></a>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        @if(!empty($todayDataCollection->dcDirected))
                                                            <a href="#" class="text-decoration-none text-dark"><span class="small">{{__('messages.বিষয়ঃ')}} {{isset($todayDataCollection->dcDirected->topic->name)? $todayDataCollection->dcDirected->topic->name: ''}} </span></a>
                                                        @else
                                                            <a href="#" class="text-decoration-none text-dark"><span class="small">{{__('messages.বিষয়ঃ')}} {{isset($todayDataCollection->dcSpontaneous->spontaneous->word)? $todayDataCollection->dcSpontaneous->spontaneous->word: ''}} </span></a>
                                                        @endif

                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item" style="width: 13rem;">
                                                <div class="row">
                                                    <div class="col">
                                                        <a href="" class="text-decoration-none text-dark"><strong>{{__('messages.তারিখঃ')}}
                                                                @if(app()->getLocale() == 'bn')
                                                                    {{Converter::en2bn(\Carbon\Carbon::parse($todayDataCollection->created_at)->format('d/m/Y'))}} ইং
                                                                @else
                                                                    {{\Carbon\Carbon::parse($todayDataCollection->created_at)->format('d/m/Y')}}
                                                                @endif
                                                            </strong></a>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <a href="#" class="text-decoration-none text-dark"><span class="small">{{__('messages.সংগ্রাহকঃ')}} {{$todayDataCollection->collector->name}}</span></a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item" style="width: 11rem;">
                                                <a href="{{route('admin.data_collections.view', $todayDataCollection->id)}}" class="btn btn-success text-white">{{__('messages.বিস্তারিত দেখুন')}}</a>
                                            </li>
                                        </ul>
                                    @empty
                                        {{__('messages.কোন কিছু পাওয়া যায়নি')}}
                                    @endforelse
                                    {{ $todayDataCollections->links('vendor.pagination.custom') }}
                                </div>
                            </div>
                            @endif
                        </div>

                        {{-- <div class="col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-header">{{__('messages.নোটিফিকেশান')}}({{isset($notificationCounts)? $notificationCounts: 0}})</div>
                                <div class="card-body">
                                    <ul class="list-group list-group-horizontal ">
                                        <li class="list-group-item" style="width: 12rem;"><strong>{{__('messages.সাবজেক্ট')}}</strong></li>
                                        <li class="list-group-item" style="width: 15rem;"><strong>{{__('messages.মেসেজ')}}</strong></li>
                                        <li class="list-group-item" style="width: 10rem;"><strong>{{__('messages.তারিখঃ')}}</strong></li>
                                    </ul>
                                    @forelse($notifications as $key =>$notification)
                                        <ul class="list-group list-group-horizontal ">
                                            <li class="list-group-item" style="width: 12rem;">
                                                {{$notification->title}}
                                            </li>
                                            <li class="list-group-item notice more" style="width: 15rem;">
                                                {{$notification->body}}
                                            </li>
                                            <li class="list-group-item" style="width: 10rem;">
                                                @if(app()->getLocale() == 'bn')
                                                    {{Converter::en2bn(\Carbon\Carbon::parse($notification->created_at)->format('d/m/Y'))}} ইং
                                                @else
                                                    {{\Carbon\Carbon::parse($notification->created_at)->format('d/m/Y')}}
                                                @endif
                                            </li>
                                        </ul>
                                    @empty
                                        {{__('messages.কোন কিছু পাওয়া যায়নি')}}
                                    @endforelse
                                </div>
                            </div>
                        </div> --}}
                    @elseif(Auth::user()->hasRole('Linguist'))
                        <div class="col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link text-dark active" id="directed-tab" data-coreui-toggle="tab" data-coreui-target="#directed" type="button" role="tab" aria-controls="directed" aria-selected="true">
                                                {{__('messages.আজকের নির্দেশিত বাক্য')}}({{isset($todayDirctedCounts)? $todayDirctedCounts: 0}})
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link text-dark" id="spontaneous-tab" data-coreui-toggle="tab" data-coreui-target="#spontaneous" type="button" role="tab" aria-controls="spontaneous" aria-selected="false">
                                                {{__('messages.আজকের স্বতঃস্ফূর্ত কীওয়ার্ড')}}({{isset($todaySpontaneouCounts)? $todaySpontaneouCounts: 0}})
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        {{-- <ul class="nav nav-tabs" id="myTab" role="tablist">
                                             <li class="nav-item" role="presentation">
                                                 <button class="nav-link active" id="directed-tab" data-coreui-toggle="tab" data-coreui-target="#directed" type="button" role="tab" aria-controls="directed" aria-selected="true">{{__('messages.স্পিকার তালিকা')}}</button>
                                             </li>
                                             <li class="nav-item" role="presentation">
                                                 <button class="nav-link" id="spontaneous-tab" data-coreui-toggle="tab" data-coreui-target="#spontaneous" type="button" role="tab" aria-controls="spontaneous" aria-selected="false">{{__('messages.নতুন স্পিকার')}}</button>
                                             </li>
                                         </ul>--}}
                                        <div class="tab-content" id="myTabContent">
                                            <div class="tab-pane fade show active " id="directed" role="tabpanel" aria-labelledby="directed-tab">
                                                <ul class="list-group list-group-horizontal ">
                                                    <li class="list-group-item" style="width: 10rem;"><strong>{{__('messages.বিষয়')}}</strong></li>
                                                    <li class="list-group-item" style="width: 18rem;"><strong>{{__('messages.বাক্য')}}</strong></li>
                                                    <li class="list-group-item" style="width: 9rem;"><strong>{{__('messages.তারিখঃ')}}</strong></li>
                                                </ul>
                                                @forelse($todayDirecteds as $key =>$todayDirected)
                                                    <ul class="list-group list-group-horizontal ">
                                                        <li class="list-group-item" style="width: 10rem;">
                                                            {{$todayDirected->topics->name}}
                                                        </li>
                                                        <li class="list-group-item" style="width: 18rem;">
                                                            {{$todayDirected->sentence}}
                                                        </li>
                                                        <li class="list-group-item" style="width: 9rem;">
                                                            @if(app()->getLocale() == 'bn')
                                                                {{Converter::en2bn(\Carbon\Carbon::parse($todayDirected->created_at)->format('d/m/Y'))}} ইং
                                                            @else
                                                                {{\Carbon\Carbon::parse($todayDirected->created_at)->format('d/m/Y')}}
                                                            @endif
                                                        </li>
                                                    </ul>
                                                @empty
                                                    {{__('messages.কোন কিছু পাওয়া যায়নি')}}
                                                @endforelse
                                                {{ $todayDirecteds->links('vendor.pagination.custom') }}
                                            </div>
                                            <div class="tab-pane fade" id="spontaneous" role="tabpanel" aria-labelledby="spontaneous-tab">
                                                <ul class="list-group list-group-horizontal ">
                                                    <li class="list-group-item" style="width: 22rem;"><strong>{{__('messages.কীওয়ার্ড')}}</strong></li>
                                                    <li class="list-group-item" style="width: 10rem;"><strong>{{__('messages.তারিখঃ')}}</strong></li>
                                                </ul>
                                                @forelse($todaySpontaneouses as $key =>$todaySpontaneous)
                                                    <ul class="list-group list-group-horizontal ">
                                                        <li class="list-group-item" style="width: 22rem;">
                                                            {{$todaySpontaneous->word}}
                                                        </li>
                                                        <li class="list-group-item" style="width: 10rem;">
                                                            @if(app()->getLocale() == 'bn')
                                                                {{Converter::en2bn(\Carbon\Carbon::parse($todaySpontaneous->created_at)->format('d/m/Y'))}} ইং
                                                            @else
                                                                {{\Carbon\Carbon::parse($todaySpontaneous->created_at)->format('d/m/Y')}}
                                                            @endif
                                                        </li>
                                                    </ul>
                                                @empty
                                                    {{__('messages.কোন কিছু পাওয়া যায়নি')}}
                                                @endforelse
                                                {{ $todaySpontaneouses->links('vendor.pagination.custom') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-header">{{__('messages.বিজ্ঞপ্তি')}}{{--({{isset($notificationCounts)? $notificationCounts: 0}})--}}</div>
                                <div class="card-body">
                                    <ul class="list-group list-group-horizontal ">
                                        <li class="list-group-item" style="width: 12rem;"><strong>{{__('messages.সাবজেক্ট')}}</strong></li>
                                        <li class="list-group-item" style="width: 16rem;"><strong>{{__('messages.মেসেজ')}}</strong></li>
                                        <li class="list-group-item" style="width: 9rem;"><strong>{{__('messages.তারিখঃ')}}</strong></li>
                                    </ul>
                                    @forelse($notifications as $key =>$notification)
                                        <ul class="list-group list-group-horizontal ">
                                            <li class="list-group-item" style="width: 12rem;">
                                                {{$notification->title}}
                                            </li>
                                            <li class="list-group-item notice more" style="width: 15rem;">
                                                {{$notification->body}}
                                            </li>
                                            <li class="list-group-item" style="width: 10rem;">
                                                @if(app()->getLocale() == 'bn')
                                                    {{Converter::en2bn(\Carbon\Carbon::parse($notification->created_at)->format('d/m/Y'))}} ইং
                                                @else
                                                    {{\Carbon\Carbon::parse($notification->created_at)->format('d/m/Y')}}
                                                @endif
                                            </li>
                                        </ul>
                                    @empty
                                        {{__('messages.কোন কিছু পাওয়া যায়নি')}}
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    @else
                    <div class="col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-header">{{__('messages.ডেটা সংগ্রহের হার')}}</div>
                            <div class="card-body">
                                {{--<div class="c-chart-wrapper">
                                    <canvas id="canvas-3"></canvas>
                                </div>--}}
                                <div id="piechart" style="/*width: 570px;*/ height: 380px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-header">{{__('messages.ডেটা সংগ্রহের হার')}} ({{ __('messages.অনুমোদিত ডাটা') }})</div>
                            <div class="card-body">
                                {{--<div class="c-chart-wrapper">
                                    <canvas id="canvas-3"></canvas>
                                </div>--}}
                                <div id="piechart2" style="/*width: 570px;*/ height: 380px;"></div>
                            </div>
                        </div>
                    </div>
                        <div class="col-md-12 col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    {{__('messages.আজকের তথ্য সংগ্রহ')}} <span class="small">(
                                        @if(app()->getLocale() == 'bn')
                                            {{isset($todaycollections)? Converter::en2bn($todaycollections): 0}}
                                        @else
                                            {{isset($todaycollections)? $todaycollections: 0}}
                                        @endif
                                        )</span>
                                </div>
                                <div class="card-body">
                                    @forelse($todayDataCollections as $key =>$todayDataCollection)
                                        <ul class="list-group list-group-horizontal mb-3">
                                            <li class="list-group-item" style="width: 12rem;">
                                                <div class="row">
                                                    <div class="col">
                                                        <a href="" class="text-decoration-none text-dark"><strong>{{__('messages.ভাষাঃ')}} {{$todayDataCollection->language->name}}</strong></a>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <a href="#" class="text-decoration-none text-dark"><span class="small">{{__('messages.ভাষার ধরনঃ')}} {{($todayDataCollection->type_id== 1)? 'নির্দেশিত':'স্বতঃস্ফূর্ত'}} </span></a>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        @if(!empty($todayDataCollection->dcDirected))
                                                            <a href="#" class="text-decoration-none text-dark"><span class="small">{{__('messages.বিষয়ঃ')}} {{isset($todayDataCollection->dcDirected->topic->name)? $todayDataCollection->dcDirected->topic->name: ''}} </span></a>
                                                        @else
                                                            <a href="#" class="text-decoration-none text-dark"><span class="small">{{__('messages.বিষয়ঃ')}} {{isset($todayDataCollection->dcSpontaneous->spontaneous->word)? $todayDataCollection->dcSpontaneous->spontaneous->word: ''}} </span></a>
                                                        @endif

                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item" style="width: 13rem;">
                                                <div class="row">
                                                    <div class="col">
                                                        <a href="" class="text-decoration-none text-dark"><strong>{{__('messages.তারিখঃ')}}
                                                                @if(app()->getLocale() == 'bn')
                                                                    {{Converter::en2bn(\Carbon\Carbon::parse($todayDataCollection->created_at)->format('d/m/Y'))}} ইং
                                                                @else
                                                                    {{\Carbon\Carbon::parse($todayDataCollection->created_at)->format('d/m/Y')}}
                                                                @endif
                                                            </strong></a>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <a href="#" class="text-decoration-none text-dark"><span class="small">{{__('messages.সংগ্রাহকঃ')}}{{isset($todayDataCollection->collector->name)? $todayDataCollection->collector->name:''}}</span></a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item" style="width: 11rem;">
                                                <a href="{{route('admin.data_collections.view', $todayDataCollection->id)}}" class="btn btn-success text-white">{{__('messages.বিস্তারিত দেখুন')}}</a>
                                            </li>
                                        </ul>
                                    @empty
                                        {{__('messages.কোন কিছু পাওয়া যায়নি')}}
                                    @endforelse
                                    {{ $todayDataCollections->links('vendor.pagination.custom') }}
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-header">{{__('messages.ডেটা সংগ্রহের হার')}}</div>
                                <div class="card-body">
                                    <div id="piechart" style="/*width: 570px;*/ height: 380px;"></div>
                                </div>
                            </div>

                        </div> --}}
                        <div class="col-md-12 col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    {{__('আজকের কাজ')}}
                                    {{-- <span class="small">(
                                        @if(app()->getLocale() == 'bn')
                                            {{isset($todaycollections)? Converter::en2bn($todaycollections): 0}}
                                        @else
                                            {{isset($todaycollections)? $todaycollections: 0}}
                                        @endif
                                        )</span> --}}
                                </div>
                                <div class="card-body">
                                    {{-- @forelse($todayDataCollections as $key =>$todayDataCollection) --}}
                                     <div class="table-responsive">
                                         <table class="table table-hover table-bordered" id="directedTopic">
                                             <thead class="table-dark">
                                             <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">{{__('messages.ভাষা')}}</th>
                                                <th scope="col">{{__('ডাটা সংগ্রহ')}}</th>
                                                <th scope="col">{{__('messages.যাচাইকৃত')}}</th>
                                                <th scope="col">{{__('messages.অনুমোদিত')}}</th>
                                                {{-- <th scope="col" class="text-center">{{__('messages.অ্যাকশন')}}</th> --}}
                                             </tr>
                                             </thead>
                                            <tbody>
                                                {{-- @foreach($todaystest as $key =>$todayDataCollection)
                                                <tr>
                                                    <th scope="row">{{  ++ $key }}</th>
                                                    <th scope="row">
                                                        <div class="row">
                                                            <div class="col">
                                                                @foreach($todayDataCollection as $t)
                                                                <span class="bold">{{$t->language->name}}</span><br>
                                                                <span class="bold">({{ $t->district->name }})</span>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </th>
                                                </tr>

                                                @endforeach --}}
                                            </tbody>
                                         </table>
                                        </div>
                                        {{-- {{ $todayDataCollection->links('vendor.pagination.custom') }} --}}
                                    {{-- @empty
                                        {{__('messages.কোন কিছু পাওয়া যায়নি')}}
                                    @endforelse
                                    {{ $todayDataCollections->links('vendor.pagination.custom') }} --}}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="row">
                    @if( Auth::user()->user_type ==  1 || Auth::user()->hasRole(['Admin']))
                        <div class="col-md-12">
                            <div class="card mb-4">
                                <div class="card-header">{{__('messages.ভাষাভিত্তিক তথ্য সংগ্রহ')}}
                                </div>
                                <div class="card-body">
                                    <div class="c-chart-wrapper">
                                        <canvas id="canvas-2"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('pie-chart-js')
    <script>

        $(document).ready(function() {
            $(".approve").parent().hide();
            $(".assign").parent().hide();
            $(".progress").parent().hide();
        });
        // document.getElementsByClassName('approve')[0].style.visibility = 'hidden';

        // core ui pi chart
        /* const pieChart = new Chart(document.getElementById('canvas-3'), {
             type: 'pie',
             data: {
                 labels: ['সংগৃহীত', 'অবশিষ্ট'],
                 datasets: [{
                     data: [
{{--@php
                          echo $totalApproved;
                        @endphp--}},
                        {{--@php
                            echo $totalPending;
                        @endphp--}}
        ],
        backgroundColor: ['#0a672d', '#0d6efd'],
        hoverBackgroundColor: ['#0a672d', '#0d6efd']
    }]
},
options: {
    width:400,
    height:300,
    responsive: true
}
});*/

        // google pie chart
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        google.charts.setOnLoadCallback(drawChart2);

        function drawChart() {

            var data = google.visualization.arrayToDataTable([

                ['Task', 'Hours per Day'],
                @php
                if ($totalAudio != false){

                foreach($totalAudio as $key=>$audio)
                {
                    // $result=[$key,$audio];
                    echo "['".$key."', ".$audio."],";
                    // echo json_encode($result);

                }
            }
                @endphp



                // ['Task', 'Hours per Day'],
                // {{ json_encode($result) }}
                // ['সংগৃহীত ডাটা',
                //     @php
                //         echo $totalCollections;
                //     @endphp

                // ],
                // ['বিবেচনাধীন',
                //     @php
                //         echo $totalPending;
                //     @endphp

                // ],
                // ['অনুমোদিত',
                //     @php
                //         echo $totalApproved;
                //     @endphp
                // ]
            ]);

            var options = {
                title: '',
                responsive: true,
                legend: {
                    position:'bottom',
                },

            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);
        }
        function drawChart2() {

                var data = google.visualization.arrayToDataTable([

                    ['Task', 'Hours per Day'],
                    @php
                    if ($totalAudioApprove != false){

                    foreach($totalAudioApprove as $key=>$audio)
                    {
                        // $result=[$key,$audio];
                        echo "['".$key."', ".$audio."],";
                        // echo json_encode($result);

                    }
                }
                    @endphp



                    // ['Task', 'Hours per Day'],
                    // {{ json_encode($result) }}
                    // ['সংগৃহীত ডাটা',
                    //     @php
                    //         echo $totalCollections;
                    //     @endphp

                    // ],
                    // ['বিবেচনাধীন',
                    //     @php
                    //         echo $totalPending;
                    //     @endphp

                    // ],
                    // ['অনুমোদিত',
                    //     @php
                    //         echo $totalApproved;
                    //     @endphp
                    // ]
                ]);

                var options = {
                    title: '',
                    responsive: true,
                    legend: {
                        position:'bottom',
                    },

                };

                var chart = new google.visualization.PieChart(document.getElementById('piechart2'));

                chart.draw(data, options);
            }


        const barChart = new Chart(document.getElementById('canvas-2'), {
            type: 'bar',
            data: {
                labels: [
                    @php
                    if ($totalAudio != false){
                    foreach($totalAudio as $key =>$value) {
                            echo "'$key', ";
                        }
                    }
                    @endphp


                ],
                datasets: [{

                    label: 'সংগৃহীত ডাটা',
                    backgroundColor: 'rgb(63, 104, 196)',
                    borderColor: 'rgba(220, 220, 220, 0.8)',
                    highlightFill: 'rgba(220, 220, 220, 0.75)',
                    highlightStroke: 'rgba(220, 220, 220, 1)',
                    barThickness: 30,
                    // barPercentage: 0.5,
                    // categoryPercentage: 2,

                    data: [
                        @php
                            // foreach($barDirecteds as $key =>$value) {
                            //     $result = count($value->dataCollection);
                            //     //  $result=$value;
                            //     echo "'$result',";
                            // }
                            if ($totalAudio != false){
                            foreach($totalAudio as $key =>$value) {
                                $result = $value;
                                //  $result=$value;
                                echo "'$result',";
                            }
                        }
                        @endphp
                    ]
                },
                //  {
                //     label: 'সংগৃহীত ডাটা (স্বতঃস্ফূর্ত)',
                //     backgroundColor: 'rgb(46, 184, 92)',
                //     borderColor: 'rgba(151, 187, 205, 0.8)',
                //     highlightFill: 'rgba(151, 187, 205, 0.75)',
                //     highlightStroke: 'rgba(151, 187, 205, 1)',
                //     barThickness: 35,
                //     data: [
                //         @php
                //             foreach($barSpontaneous as $key =>$value) {
                //                $result = count($value->dataCollection);
                //                 echo "'$result',";
                //             }
                //         @endphp
                //     ]
                // },
            ]
            },
            options: {
                responsive: true
            }
        });



        /*scroll to div */

        $(document).ready(function () {
            if (window.location.href.indexOf('?page=') > 0) {
                $('html, body').animate({
                    scrollTop: $('#scrollToDiv').offset().top
                }, 'slow');
            }

        });


        $(document).ready(function() {
            var showChar = 125;
            var ellipsestext = "...";
            var moretext = "more";
            var lesstext = "less";
            $('.more').each(function() {
                var content = $(this).html();

                if(content.length > showChar) {

                    var c = content.substr(0, showChar);
                    var h = content.substr(showChar-1, content.length - showChar);

                    var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';

                    $(this).html(html);
                }

            });

            $(".morelink").click(function(){
                if($(this).hasClass("less")) {
                    $(this).removeClass("less");
                    $(this).html(moretext);
                } else {
                    $(this).addClass("less");
                    $(this).html(lesstext);
                }
                $(this).parent().prev().toggle();
                $(this).prev().toggle();
                return false;
            });

            /* $('#data-collection').DataTable({
             });*/
        });
        console.alart("yes");
    </script>
@endsection
