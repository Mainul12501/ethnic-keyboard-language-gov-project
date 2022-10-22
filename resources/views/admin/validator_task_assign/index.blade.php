@extends('layouts.app')

@section('title', 'টাস্ক অ্যাসাইন তালিকা')

@section('content')
    <div class="container-fluid px-0">
        <div class="card mb-3">
            <div class="card-header">
                <ul class="nav nav-pills card-header-pills justify-content-between">
                    <li class="nav-item">{{__('messages.টাস্ক অ্যাসাইন')}}</li>
                    <ul class="nav nav-pills card-header-pills me-2">

                        <li class="nav-item"><a class="btn btn-success text-white btn-sm" href="{{route('admin.validator_task_assigns.create')}}">
                                <svg class="icon me-2">
                                    <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-plus')}}"></use>
                                </svg>{{__('messages.নতুন টাস্ক')}}</a>
                        </li>
                    </ul>
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

                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="task-assign">
                        <thead class="table-dark">
                        <tr>
                            <th scope="col">{{__('messages.ক্রমিক নং')}}</th>
                            <th scope="col">{{__('messages.যাচাইকারী')}}</th>
                            <th scope="col">{{__('messages.ভাষার নাম')}}</th>
                            {{-- <th scope="col">{{__('messages.উপভাষা')}}</th> --}}
                            <th scope="col" class="text-center">{{__('messages.অ্যাকশন')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($taskAssigns as $key=>$taskAssign)
                            <tr>
                                <td>{{ ++ $key }}</td>
                                @if(!empty($taskAssign->user_id))
                                    <td class="">{{isset($taskAssign->collector->name)? $taskAssign->collector->name: ''}}</td>
                                @else
                                    <td class=""></td>
                                @endif
                                <td class="">{{isset($taskAssign->language->name)? $taskAssign->language->name:''}}</td>
                                {{-- <td class="">{{isset($taskAssign->sub_language->name)? $taskAssign->sub_language->name:''}}</td> --}}
                                <td class="text-center">
                                    <div class="d-grid gap-2 d-md-flex justify-content-center">
                                        <form action="{{ route('admin.validator_task_assigns.destroy', $taskAssign->id) }}" method="post">
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
        // alertify delete
        $('.show_confirm').click(function(event) {
            var form =  $(this).closest("form");
            event.preventDefault();
            alertify.confirm('Whoops!', 'Are you sure you want to Delete? This task and related data will be deleted.',
                function(){
                    form.submit();
                },
                function(){

                });
        });

        $(document).ready(function() {
            $('#task-assign').DataTable();
        } );

    </script>
@endsection


