@extends('layouts.app')

@section('title', 'ভাষার তালিকা')

@section('content')
    <div class="container-fluid px-0">
        <div class="card mb-3">
            <div class="card-header">
                <ul class="nav nav-pills card-header-pills justify-content-between">
                    <li class="nav-item">{{__('messages.অ্যাসাইন ভাষার তালিকা')}}</li>
                    {{--<li class="nav-item"><a class="btn btn-success btn-sm text-white" href="{{route('admin.language_assigns.create')}}">
                            <svg class="icon me-2 text-white">
                                <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-plus')}}"></use>
                            </svg>নতুন</a>
                    </li>--}}
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
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                @endif--}}
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="language-assign">
                        <thead class="table-dark">
                        <tr>
                            <th scope="col" style="width: 5rem;">{{__('messages.ক্রমিক নং')}}</th>
                            <th scope="col">{{__('messages.ভাষার নাম')}}</th>
                            <th scope="col" class="text-center">{{__('messages.নির্দেশিত')}}</th>
                            <th scope="col" class="text-center">{{__('messages.স্বতঃস্ফূর্ত')}}</th>
                            <th scope="col" class="text-center">{{__('messages.অ্যাকশন')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($languages as $key=> $language)
                            <tr>
                                <th scope="row">{{ ++ $key }}</th>
                                <td class="">{{$language->name}}</td>
                                <td class="text-center text-decoration-underline">
                                    <a href="{{route('admin.directed.languages.list', $language->id)}}">{{$language->directed_language_count}}</a>
                                </td>
                                <td class="text-center text-decoration-underline">
                                    <a href="{{route('admin.spontaneous.languages.list', $language->id)}}">{{$language->spontaneous_language_count}}</a>
                                </td>
                                <td class="text-center">
                                    <div class="d-grid gap-2 d-md-block">
                                        {{--<a class="btn btn-info btn-sm" href="#">
                                            <svg class="icon me-2 text-white">
                                                <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-low-vision')}}"></use>
                                            </svg>
                                        </a>--}}
                                        <a class="btn btn-purple btn-sm" href="{{route('admin.language_assigns.edit', $language->id)}}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{--{{ $languages->links('vendor.pagination.custom') }}--}}
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
        $(document).ready(function() {
            $('#language-assign').DataTable();
        } );

    </script>
@endsection

