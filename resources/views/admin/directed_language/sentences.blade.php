@extends('layouts.app')

@section('title', '')

@section('content')
    <div class="container-fluid px-0">
        <div class="card mb-3">
            <div class="card-header">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item" data-toggle="tooltip" data-placement="top" title="Back">
                            <a class="btn btn-sm btn-success" href="{{route('admin.directed.languages.list', $language->language_id)}}">
                                <i class="fas fa-arrow-left text-white"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            {{$language->language->name}}
                        </li>
                        <li class="breadcrumb-item">
                            {{$firstItem->topics->name}}
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
                            <th scope="col">{{__('messages.বাক্য')}}</th>
                            <th scope="col">{{__('messages.অনুবাদ')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sentences as $key=> $sentence)
                            <tr>
                                <th scope="row">{{  ++ $key }}</th>
                                <td class="">{{$sentence->sentence}}</td>
                                <td class="">{{$sentence->english}}</td>
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

