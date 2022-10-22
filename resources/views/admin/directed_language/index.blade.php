@extends('layouts.app')

@section('title', '')

@section('content')
    <div class="container-fluid px-0">
        <div class="card mb-3">
            <div class="card-header">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.language_assigns.index')}}">{{__('messages.অ্যাসাইন নির্দেশিত ভাষার তালিকা')}}</a></li>
                        <li class="breadcrumb-item">
                            {{$firstItem->language->name}}
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="directedTopic">
                        <thead class="table-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{__('messages.বিষয়')}}</th>
                            <th scope="col" class="text-center">{{__('messages.অ্যাকশন')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($directedLanguages as $key=> $directedLanguage)
                            <tr>
                                <th scope="row">{{  ++ $key }}</th>
                                <td class="">{{$directedLanguage->topics->name}}</td>
                                <td class="text-center">
                                    <div class="d-grid gap-2 d-md-block">
                                        <a class="btn btn-info btn-sm" href="{{route('admin.directed.language.topic.sentence', ['topic_id'=>$directedLanguage->topics->id, 'language_id'=>$directedLanguage->language->id])}}">
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
    <script>
        $(document).ready(function() {
            $('#directedTopic').DataTable();
        } );
    </script>

@endsection

