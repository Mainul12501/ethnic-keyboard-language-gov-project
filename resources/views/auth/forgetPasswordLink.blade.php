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

                            <form action="{{ route('reset.password.post') }}" method="POST">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">
                                      <svg class="icon">
                                        <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-envelope-open')}}"></use>
                                      </svg>
                                    </span>
                                    <input type="text" id="email_address" class="form-control @error('email') is-invalid @enderror" name="email" readonly value="{{$user->email}}" placeholder="ইমেইল" required autofocus>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="input-group mb-3">
                                    <span class="input-group-text">
                                      <svg class="icon">
                                        <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-lock-locked')}}"></use>
                                      </svg>
                                    </span>
                                    <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="পাসওয়ার্ড" required autofocus>
                                    <button class="btn btn-outline-secondary" id="button-addon1" type="button"><i class="far fa-eye" id="togglePassword" style=" cursor: pointer;"></i></button>

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">
                                      <svg class="icon">
                                        <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-lock-locked')}}"></use>
                                      </svg>
                                    </span>
                                    <input type="password" id="password-confirm" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" placeholder="পুনরায় পাসওয়ার্ড দিন" required autofocus>
                                    <button class="btn btn-outline-secondary" id="button-addon2" type="button">
                                        <i class="far fa-eye" id="toggleConPassword" style=" cursor: pointer;"></i>
                                    </button>
                                    @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-6 ">

                                    </div>
                                    <div class="col-6 text-end">
                                        <button class="btn btn-success text-white" type="submit">
                                            <svg class="icon me-2">
                                                <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-arrow-circle-right')}}"></use>
                                            </svg>{{ __('জমা দিন') }}
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
@section('show-hide-js')
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        togglePassword.addEventListener('click', function (e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });


        const toggleConPassword = document.querySelector('#toggleConPassword');
        const password_confirmation = document.querySelector('#password-confirm');
        toggleConPassword.addEventListener('click', function (e) {
            const type = password_confirmation.getAttribute('type') === 'password' ? 'text' : 'password';
            password_confirmation.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });
    </script>
@endsection
