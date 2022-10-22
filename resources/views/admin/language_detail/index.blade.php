@extends('layouts.app')

@section('title', 'ভাষার তালিকা')

@section('content')
    <div class="container-fluid px-0">
        <div class="card mb-3">
            <div class="card-header">
                <ul class="nav nav-pills card-header-pills justify-content-between">
                    <li class="nav-item">ভাষার তালিকা</li>
                    <li class="nav-item"><a class="btn btn-primary btn-sm" href="{{route('admin.language_details.create')}}">
                            <svg class="icon me-2">
                                <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-plus')}}"></use>
                            </svg>নতুন</a>
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
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                @endif
                <div class="d-flex justify-content-between">
                    <div  class="col-md-4">
                        <div class="row" id="filterSearch" style="display: none">
                            <form>
                                <div class="input-group d-flex">
                                    <input type="text" class="form-control" placeholder="ভাষার নাম খুঁজুন">
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary" type="submit">
                                            <svg class="icon me-2">
                                                <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-search')}}"></use>
                                            </svg>খুঁজুন
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
                    <table class="table table-hover">
                        <thead class="table-dark">
                        <tr>
                            <th scope="col">ক্রমিক নং</th>
                            <th scope="col">ভাষার নাম</th>
                            <th scope="col">অবস্থান</th>
                            <th scope="col" class="text-center">নির্দেশিত</th>
                            <th scope="col" class="text-center">সংগৃহীত</th>
                            <th scope="col" class="text-center">স্বতঃস্ফূর্ত</th>
                            <th scope="col" class="text-center">সংগৃহীত</th>
                            <th scope="col" class="text-center">অ্যাকশন</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($languages as $key=> $language)
                            <tr>
                                <th scope="row">{{ $languages->firstItem() + $key }}</th>
                                <td class="text-primary">{{$language->name}}</td>
                                <td>{{$language->location}}</td>
                                <td class="text-primary text-center text-decoration-underline"><a href="{{route('admin.directed.languages.list', $language->id)}}">{{$language->directed_language_count}}</a></td>
                                <td class="text-primary text-center text-decoration-underline">২৩</td>
                                <td class="text-primary text-center text-decoration-underline">{{$language->spontaneous_language_count}}</td>
                                <td class="text-primary text-center text-decoration-underline">২৩</td>
                                <td class="text-center">
                                    <div class="d-grid gap-2 d-md-block">
                                        <a class="btn btn-info btn-sm" href="#">
                                            <svg class="icon me-2 text-white">
                                                <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-low-vision')}}"></use>
                                            </svg>
                                        </a>
                                        <a class="btn btn-primary btn-sm" href="{{route('admin.language_details.edit', $language->id)}}">
                                            <svg class="icon me-2 text-white">
                                                <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-color-border')}}"></use>
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $languages->links('vendor.pagination.custom') }}
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

    </script>
@endsection

