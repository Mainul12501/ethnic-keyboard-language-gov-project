@extends('layouts.app')

@section('title', 'ভাষার তালিকা')

@section('content')
    <div class="container-fluid px-0">
        <div class="card mb-3">
            <div class="card-header">
                <ul class="nav nav-pills card-header-pills justify-content-between">
                    <li class="nav-item">{{__('messages.ভাষার তালিকা')}}</li>
                    <li class="nav-item"><a class="btn btn-success btn-sm text-white" href="{{route('admin.languages.create')}}">
                            <svg class="icon me-2 text-white">
                                <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-plus')}}"></use>
                            </svg>{{__('messages.নতুন')}}</a>
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
                {{--@if(Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ Session::get('success') }}
                        <button class="btn-close" type="button" data-coreui-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif--}}
                {{--<div class="d-flex justify-content-between">
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
                </div>--}}
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="language">
                        <thead class="table-dark">
                        <tr>
                            <th scope="col" style="width: 7rem;">{{__('messages.ক্রমিক নং')}}</th>
                            <th scope="col">{{__('messages.ভাষার নাম')}}</th>
                            <th scope="col">{{__('messages.উপভাষার নাম')}}</th>
                            <th scope="col">{{__('messages.অবস্থান')}}</th>
                            <th scope="col" class="text-center">{{__('messages.অ্যাকশন')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($languages as $key=>$language)
                            <tr>
                                <td>{{ /*$languages->firstItem()*/ ++ $key }}</td>
                                <td>{{$language->name}}</td>
                                <td>
                                    @foreach($language->subLanguages as $subLanuage)
                                    <span class="badge bg-secondary">{{$subLanuage->sub_name}}</span>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($language->languageDistricts as $languageDistrict)
                                    <span class="badge rounded-pill bg-success ">{{$languageDistrict->name}}</span>
                                    @endforeach
                                </td>
                                <td class="text-center">
                                    <div class="d-grid gap-2 d-md-flex justify-content-center">
                                        <a class="btn btn-purple btn-sm" href="{{route('admin.languages.edit', $language->id)}}">
                                            <i class="fas fa-edit"></i>
                                            {{--<svg class="icon  text-white">
                                                <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-color-border')}}"></use>
                                            </svg>--}}
                                        </a>
                                        <form action="{{ route('admin.languages.destroy', $language->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm show_confirm">
                                                <svg class="icon  text-white">
                                                    <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-trash')}}"></use>
                                                </svg>
                                            </button>
                                        </form>
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
        $(document).ready(function() {
            $('#language').DataTable();
        } );

        // alertify delete
        $('.show_confirm').click(function(event) {
            var form =  $(this).closest("form");
            event.preventDefault();
            alertify.confirm('Whoops!', 'Are you sure you want to Delete?',
                function(){
                    form.submit();
                    // alertify.success('Ok')
                },
                function(){
                    // alertify.error('Cancel')
                });
        });
    </script>
@endsection

