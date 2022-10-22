@extends('layouts.app')

@section('title', 'বিজ্ঞপ্তি তালিকা')

@section('content')
    <div class="container-fluid px-0">
        <div class="card mb-3">
            <div class="card-header">
                <ul class="nav nav-pills card-header-pills justify-content-between">
                    <li class="nav-item">{{__('messages.বিজ্ঞপ্তি তালিকা')}}</li>
                    <li class="nav-item"><a class="btn btn-success btn-sm text-white" href="{{route('admin.notices.create')}}">
                            <svg class="icon me-2 text-white">
                                <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-plus')}}"></use>
                            </svg>{{__('messages.নতুন')}}</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="notification">
                        <thead class="table-dark">
                        <tr>
                            <th scope="col">{{__('messages.ক্রমিক নং')}}</th>
                            <th scope="col">{{__('messages.নাম')}}</th>
                            <th scope="col">{{__('messages.সাবজেক্ট')}}</th>
                            <th scope="col">view</th>
                            <th scope="col" class="text-center">{{__('messages.অ্যাকশন')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($notices as $key=>$notice)
                            <tr>
                                <td>{{ ++ $key }}</td>
                                <td>{{$notice->user->name}}</td>
                                <td>{{$notice->title}}</td>
                                <td>{{($notice->status== 0)? 'unseen': 'seen'}}</td>
                                <td class="text-center">
                                    <div class="d-grid gap-2 d-md-flex justify-content-center">
                                        {{--<a class="btn btn-purple btn-sm" href="{{route('admin.languages.edit', $notification->id)}}">
                                            <svg class="icon  text-white">
                                                <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-color-border')}}"></use>
                                            </svg>
                                        </a>--}}
                                        <form action="{{ route('admin.notices.destroy', $notice->id) }}" method="post">
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
            </div>
        </div>


    </div>
@endsection

@section('language-filter-js')
    <script>
        $(document).ready(function() {
            $('#notification').DataTable();
        } );

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

