@extends('layouts.app')

@section('title', ' তালিকা')

@section('content')
    <div class="container-fluid px-0">
        <div class="card mb-3">
            <div class="card-header">
                <ul class="nav nav-pills card-header-pills justify-content-between">
                    <li class="nav-item">পারমিশন তালিকা</li>
                    <li class="nav-item"><a class="btn btn-success text-white btn-sm" href="{{route('admin.permissions.create')}}">
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
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ Session::get('success') }}
                        <button class="btn-close" type="button" data-coreui-dismiss="alert" aria-label="Close"></button>
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
                    <table class="table table-hover table-bordered">
                        <thead class="table-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">নাম</th>
                            <th scope="col" class="text-center">অ্যাকশন</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($permissions as $key=>$permission)
                            <tr>
                                <td>{{ $permissions->firstItem() + $key }}</td>
                                <td class="align-middle">{{$permission->name}}</td>
                                <td class="text-center">
                                    <div class="d-grid gap-2 d-md-flex justify-content-center">
                                        <a class="btn btn-purple btn-sm" href="{{route('admin.permissions.edit', $permission->id)}}">
                                            <svg class="icon  text-white">
                                                <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-color-border')}}"></use>
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.permissions.destroy', $permission->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">
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
                {{ $permissions->links('vendor.pagination.custom') }}
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

