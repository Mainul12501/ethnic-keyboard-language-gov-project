@extends('layouts.auth')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                {{--@if(Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ Session::get('success') }}
                        <button class="btn-close" type="button" data-coreui-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif--}}
                <div class="card-group d-block d-md-flex row">
                    
                    <div class="card col-md-7 p-4 mb-0">
                        <div class="text-center">
                            <img style="width: 5rem;" class="rounded-circle" src="{{asset('assets/coreui/assets/img/govt-logo.png')}}" alt="image">
                        </div>
                        <div class="card-body">

                            <form action="{{ route('forget.password.post') }}" method="POST">
                                @csrf
                                <div class="input-group mb-3">
                                    <span class="input-group-text">
                                      <svg class="icon">
                                        <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-envelope-open')}}"></use>
                                      </svg>
                                    </span>
                                    <input type="text" id="email_address" class="form-control @error('email') is-invalid @enderror " name="email" placeholder="ইমেইল" required autofocus>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="col-6 ">
                                        <a class="btn btn-link px-0 text-decoration-none" href="{{route('login')}}">
                                            লগইনে ফিরে যান
                                        </a>
                                    </div>
                                    <div class="col-6 text-end">
                                        <button class="btn btn-success text-white" type="submit">
                                            <svg class="icon me-2">
                                                <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-arrow-circle-right')}}"></use>
                                            </svg>{{ __('সেন্ড করুন') }}
                                        </button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
