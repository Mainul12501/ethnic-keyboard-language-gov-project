@extends('layouts.app')

@section('title', '')

@section('content')
    <div class="container-fluid px-0">
        <div class="card mb-3">
            <div class="card-header">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">{{__('messages.ভাষা অনুসারে টাস্ক অ্যাসাইন')}}</li>
                        {{-- <li class="breadcrumb-item">
                        </li> --}}
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="directedTopic">
                        <thead class="table-dark">
                        <tr>
                            <th scope="col" rowspan="2" style="width: 5rem;">{{__('messages.ক্রমিক নং')}}</th>
                            <th scope="col" rowspan="2">{{__('messages.ভাষা')}}</th>
                            <th scope="col" rowspan="2">{{__('messages.জেলা')}}</th>
                            <th scope="col" rowspan="2">{{'কালেক্টরের নাম'}}</th>
                            <th class="text-center" colspan="2">{{__('messages.টাইপ')}}</th>
                        </tr>
                        <tr>
                            <th>{{__('messages.নির্দেশিত')}}</th>
                            <th>{{__('messages.স্বতঃস্ফূর্ত')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($taskAssignListByLanguages as $key=> $taskAssignListByLanguage)
                            <tr>
                                <th scope="row">{{  ++ $key }}</th>
                                <td class="">{{ $taskAssignListByLanguage->language->name }}</td>
                                <td class="">{{ $taskAssignListByLanguage->district->name }}</td>
                                <td class="">{{ $taskAssignListByLanguage->collector->name }}</td>
                                <td class="blod">
                                    @foreach($taskAssignListByLanguage->directedTasks as $directedTaskTopic)
                                        <div class="row">
                                            <div class="col">
                                            <a href="{{route('admin.directed.languages.sentence.list',['task_assign_id'=>$taskAssignListByLanguage->id, 'topic_id'=>$directedTaskTopic->topic->id] )}}" class="text-success"> {{ $directedTaskTopic->topic->name}}</a>
                                            </div>
                                        </div>

                                    @endforeach
                                </td>
                                {{-- <td class="blod">
                                    @foreach($taskAssignListByLanguage->spontaneousTasks as $spontaneousWord)
                                        <div class="row">
                                            <div class="col">
                                            <a href="{{route('admin.directed.languages.sentence.list',['task_assign_id'=>$taskAssignListByLanguage->id, 'topic_id'=>$directedTaskTopic->topic->id] )}}" class="text-success"> {{ $spontaneousWord->spontaneous->word}}</a>
                                            </div>
                                        </div>

                                    @endforeach
                                </td> --}}
                                <td class=" bold">
                                    <a href="{{route('admin.spontaneous.language.tasks.list', $taskAssignListByLanguage->id)}}" class="badge rounded-pill bg-info text-white"  style="padding:0.375rem 0.5625rem;">
                                        {{$taskAssignListByLanguage->spontaneous_tasks_count}}
                                    </a>
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

