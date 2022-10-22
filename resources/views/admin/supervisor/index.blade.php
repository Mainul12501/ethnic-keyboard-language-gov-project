@extends('layouts.app')

@section('title', 'ডাটা কালেক্টর তালিকা')

@section('content')
    <div class="container-fluid px-0">
        <div class="card mb-3">
            <div class="card-header">
                <ul class="nav nav-pills card-header-pills justify-content-between">
                    <li class="nav-item">{{__('messages.সুপারভাইজর তালিকা')}}</li>
                    <li class="nav-item"><a class="btn btn-success btn-sm text-white" href="{{route('admin.supervisors.create')}}">
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
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="supervisor">
                        <thead class="table-dark">
                        <tr>
                            <th scope="col">{{__('messages.ক্রমিক নং')}}</th>
                            <th scope="col">{{__('messages.নাম')}}</th>
                            <th scope="col">{{__('messages.যোগদান তারিখ')}}</th>
                            <th scope="col">{{__('messages.ফোন')}}</th>
                            <th scope="col">{{__('messages.ইমেইল')}}</th>
                            <th scope="col">{{__('messages.এনআইডি')}}</th>
                            <th scope="col">{{__('messages.সর্বোচ্চ শিক্ষা')}}</th>
                            <th scope="col" class="text-center">{{__('messages.অ্যাকশন')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($supervisors as $key=>$supervisor)
                            <tr>
                                <td>{{ ++ $key }}</td>
                                <td>
                                    <div class="d-grid gap-2 d-md-flex justify-content-start">
                                        <div class="avatar avatar-md">
                                            <img style="height: 40px;" class="avatar-img" src="{{(!empty($supervisor->avatar))? asset($supervisor->avatar) : asset('assets/coreui/assets/img/avatars/8.jpg')}}" alt="image">
                                        </div>
                                        <div class="align-middle mt-2">
                                            <span class="small">{{$supervisor->name}}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    @if(App::getLocale() == 'bn')
                                        {{ Converter::en2bn($supervisor->join_date? \Carbon\Carbon::parse($supervisor->join_date)->format('d/m/Y'):null)}}
                                    @else
                                        {{$supervisor->join_date? \Carbon\Carbon::parse($supervisor->join_date)->format('d/m/Y'): null}}
                                    @endif
                                </td>
                                <td class="align-middle"><a href="tel:{{$supervisor->phone}}">
                                        @if(App::getLocale() == 'bn')
                                            {{ Converter::en2bn($supervisor->phone)}}
                                        @else
                                            {{$supervisor->phone}}
                                        @endif
                                    </a></td>
                                <td class="align-middle"><a href="mailto:{{$supervisor->email}}">{{$supervisor->email}}</a></td>
                                <td class="align-middle">
                                    @if(App::getLocale() == 'bn')
                                        {{ Converter::en2bn($supervisor->nid)}}
                                    @else
                                        {{$supervisor->nid}}
                                    @endif
                                </td>
                                <td class="align-middle">{{$supervisor->education}}</td>
                                <td class="text-center">
                                    <div class="d-grid gap-2 d-md-flex justify-content-center">
                                        <a class="btn btn-info btn-sm" href="{{route('admin.supervisors.show', $supervisor->id)}}">
                                            <i class="text-white far fa-eye"></i>
                                        </a>
                                        <a class="btn btn-purple btn-sm" href="{{route('admin.supervisors.edit', $supervisor->id)}}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.supervisors.destroy', $supervisor->id) }}" method="post">
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
                {{--{{ $supervisors->links('vendor.pagination.custom') }}--}}
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
            $('#supervisor').DataTable();
        } );
    </script>
@endsection

