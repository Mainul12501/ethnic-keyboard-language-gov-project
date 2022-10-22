@extends('layouts.app')

@section('title', '')

@section('content')
    <div class="container-fluid px-0">
        <div class="card mb-3">
            <div class="card-header">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.language_assigns.index')}}">{{__('messages.অ্যাসাইন স্বতঃস্ফূর্ত ভাষার তালিকা')}}</a></li>
                        <li class="breadcrumb-item">
                            {{$firstItem->language->name}}
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="spontaneous">
                        <thead class="table-dark">
                        <tr>
                            <th scope="col">{{__('messages.ক্রমিক নং')}}</th>
                            {{--<th scope="col">{{__('messages.ভাষা')}}</th>--}}
                            <th scope="col">{{__('messages.কীওয়ার্ড')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($spontaneousLanguages as $key=> $spontaneousLanguage)
                            <tr>
                                <th scope="row">{{ ++ $key }}</th>
                                {{--<td class="text-primary">{{$spontaneousLanguage->language->name}}</td>--}}
                                <td>{{$spontaneousLanguage->spontaneous->word}}</td>
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
            $('#spontaneous').DataTable();
        } );
    </script>

@endsection

