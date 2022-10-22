@extends('layouts.app')

@section('title', 'উপজেলার তালিকা')

@section('content')
    <div class="container-fluid px-0">
        <div class="card mb-3">
            <div class="card-header">
                <ul class="nav nav-pills card-header-pills justify-content-between">
                    <li class="nav-item">{{__('messages.উপজেলার তালিকা')}}</li>
                    <li class="nav-item"><a class="btn btn-success text-white btn-sm" href="{{route('admin.upazilas.create')}}">
                            <svg class="icon me-2">
                                <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-plus')}}"></use>
                            </svg>{{__('messages.নতুন')}}</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                {{--@if(Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ Session::get('success') }}
                        <button class="btn-close" type="button" data-coreui-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif--}}

                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="upazila">
                        <thead class="table-dark">
                        <tr>
                            <th scope="col">{{__('messages.ক্রমিক নং')}}</th>
                            <th scope="col">{{__('messages.উপজেলার নাম')}}</th>
                            <th scope="col">{{__('messages.জেলার নাম')}}</th>
                            <th scope="col" class="text-center">{{__('messages.অ্যাকশন')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($upazilas as $key=>$upazila)
                            <tr>
                                <td>{{ ++ $key }}</td>
                                @if(App::getLocale() == 'bn')
                                    <td>{{$upazila->bn_name}}</td>
                                    <td>{{$upazila->district->bn_name}}</td>
                                @else
                                    <td>{{$upazila->name}}</td>
                                    <td>{{$upazila->district->name}}</td>
                                @endif
                                <td class="text-center">
                                    <div class="d-grid gap-2 d-md-flex justify-content-center">
                                        <a class="btn btn-purple btn-sm" href="{{route('admin.upazilas.edit', $upazila->id)}}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.upazilas.destroy', $upazila->id) }}" method="post">
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
                {{--{{ $upazilas->links('vendor.pagination.custom') }}--}}
            </div>
        </div>


    </div>
@endsection

@section('language-filter-js')
    <script>
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


        $(document).ready(function() {
            $('#upazila').DataTable();
        } );

    </script>
@endsection

