@extends('layouts.app')

@section('title', 'অ্যাক্টিভিটি লগ তালিকা')

@section('content')
    <div class="container-fluid px-0">
        <div class="card mb-3">
            <div class="card-header">
                <ul class="nav nav-pills card-header-pills justify-content-between">
                    <li class="nav-item">{{__('messages.অ্যাক্টিভিটি লগ')}}</li>
                </ul>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="task-assign">
                        <thead class="table-dark">
                        <tr>
                            <th scope="col">{{__('messages.ক্রমিক নং')}}</th>
                            <th scope="col">{{__('messages.বর্ণনা')}}</th>
                            {{-- <th scope="col">{{__('messages.মডেল')}}</th> --}}
                            <th scope="col">{{__('messages.ইউজার')}}</th>
                            <th scope="col">{{__('messages.তারিখ')}}</th>
                            {{-- <th scope="col" class="text-center">{{__('messages.অ্যাকশন')}}</th> --}}
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($activities as $key=>$activity)
                            <tr>
                                <td>{{ ++ $key }}</td>
                                <td class="align-middle">{{$activity->description}}</td>
                                {{-- <td class="align-middle">{{$activity->subject_type}}</td> --}}
                                {{--<td class="align-middle">
                                    @foreach($taskAssign->topics as $topic)
                                        <div class="row">
                                            <div class="col">
                                                <span class="small">{{$topic->name}}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </td>--}}
                                <td class="align-middle">{{isset($activity->causer->name)? $activity->causer->name: ''}}</td>
{{--                                <td class="align-middle">{{\Carbon\Carbon::parse($activity->created_at)->format('d/m/Y')}}</td>--}}
                                <td class="align-middle">{{$activity->created_at->diffForHumans()}}</td>
                                {{-- <td class="text-center"> --}}
                                    {{--<div class="d-grid gap-2 d-md-flex justify-content-center">
                                        <form action="#" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">
                                                <svg class="icon  text-white">
                                                    <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-trash')}}"></use>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>--}}
                                {{-- </td> --}}
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
            $('#activity-log').DataTable();
        } );

    </script>
@endsection

