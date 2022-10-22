@extends('layouts.auth')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card-group d-block d-md-flex row">
                    <div class="card col-md-5 py-5 mb-0" >
                    </div>
                    <div class="card col-md-7 p-4 mb-0">
                        <div class="text-center">
                           
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="input-group mb-3">
                                        <span class="input-group-text">
                                          <svg class="icon">
                                            <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-user')}}"></use>
                                          </svg>
                                        </span>
                                    <input class="form-control @error('email') is-invalid @enderror" id="email" type="email" name="email" value="{{ old('email') }}" placeholder="ইমেইল/মোবাইল" required>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="input-group">
                                <span class="input-group-text">
                                  <svg class="icon">
                                    <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-lock-locked')}}"></use>
                                  </svg>
                                </span>
                                    <input class="form-control  @error('password') is-invalid @enderror" id="password" name="password" type="password" placeholder="পাসওয়ার্ড" required>
                                    <button class="btn btn-outline-secondary" id="button-addon2" type="button"><i class="far fa-eye" id="togglePassword" style=" cursor: pointer;"></i></button>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="btn-group">
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link px-0 text-decoration-none" href="{{ route('forget.password.get') }}">
                                            {{ __('পাসওয়ার্ড ভুলে গেছেন?') }}
                                        </a>
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-6 ">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="remember">
                                                {{ __('মনে রাখুন') }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6 text-end">
                                        <button class="btn btn-success text-white" id="submit" type="submit">
                                            <svg class="icon me-2">
                                                <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-arrow-circle-right')}}"></use>
                                            </svg>{{ __('প্রবেশ করুন') }}
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
    </script>
@endsection
