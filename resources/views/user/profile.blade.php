@extends('layouts.app')

@section('title', 'প্রোফাইল')

@section('content')
    <div class="container-fluid pl-0 px-0">
        <div class="card mb-3">
            <div class="card-header">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.profile')}}">{{__('messages.প্রোফাইল')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('messages.এডিট')}}</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                {{--@if(Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ Session::get('success') }}
                        <button class="btn-close" type="button" data-coreui-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif--}}
                <div class="row">
                    <div class="col-md-7 col-sm-12">
                        <div class="card">
                            <div class="text-center mt-3 " >
                                <img style="width: 5rem;" class="rounded-circle" src="{{(!empty($user->avatar))? asset($user->avatar) : asset('assets/coreui/assets/img/avatars/8.jpg')}}" alt="user Image">
                            </div>
                            <div class="text-center mt-3">
                                <h4 class="text-center">{{$user->name}}</h4>
                                <p class="text-medium-emphasis text-center">
                                    @if(!empty($user->getRoleNames()))
                                        @foreach($user->getRoleNames() as $v)
                                            <span class="small">{{ $v }}</span>
                                        @endforeach
                                    @endif
                                </p>
                            </div>
                            <div class="card-body">
                                <form action="{{route('admin.update.profile', $user->id)}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="row mb-3">
                                            <label  for="name">{{__('messages.নাম')}} <span class="text-danger">*</span></label>
                                            <div class=" input-group">
                                                <input class="form-control @error('name') is-invalid @enderror" name="name" id="name" type="text" value="{{$user->name}}" required>
                                                @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label  for="email">{{__('messages.ইমেইল')}} <span class="text-danger">*</span></label>
                                            <div class=" input-group">
                                                <input class="form-control @error('email') is-invalid @enderror" name="email" id="email" type="email" value="{{$user->email}}" required>
                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label  for="phone">{{__('messages.মোবাইল')}} <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" type="number" value="{{$user->phone}}" required>
                                                @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label  for="avatar">{{__('messages.প্রোফাইল ছবি')}}</label>
                                            <div class=" input-group">
                                                <input class="form-control" name="avatar" id="avatar" type="file">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row me-2">
                                        <div class="col-12 text-end">
                                            <button class="btn btn-success text-white" type="submit">{{__('messages.জমা দিন')}}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 col-sm-12">
                        <div class="card">
                            <div class="card-header">{{__('messages.পাসওয়ার্ড পরিবর্তন করুন')}}</div>
                            <div class="card-body">
                                <form action="{{route('admin.updatePassword', $user->id)}}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class=" row mb-3">
                                            <label class="col-md-4 col-sm-4 col-form-label" for="password">{{__('messages.পাসওয়ার্ড')}}<span class="text-danger">*</span></label>
                                            <div class="input-group col-md-8 col-sm-8">
                                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                                <button class="btn btn-outline-secondary" id="button-addon2" type="button"><i class="far fa-eye" id="togglePassword" style=" cursor: pointer;"></i></button>
                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-md-4 col-sm-4 col-form-label" for="password_confirmation">{{__('messages.পাসওয়ার্ড নিশ্চিত করুন')}}<span class="text-danger">*</span></label>
                                            <div class="input-group col-md-8 col-sm-8">
                                                <input class="form-control" name="password_confirmation" id="password_confirmation" type="password" required>
                                                <button class="btn btn-outline-secondary" id="button-addon2" type="button"><i class="far fa-eye" id="toggleConPassword" style=" cursor: pointer;"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row me-2">
                                        <div class="col-12 text-end">
                                            <button class="btn btn-success text-white" type="submit">{{__('messages.জমা দিন')}}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection
@section('language-filter-js')
    <script>

        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        togglePassword.addEventListener('click', function (e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });

        const toggleConPassword = document.querySelector('#toggleConPassword');
        const password_confirmation = document.querySelector('#password_confirmation');
        toggleConPassword.addEventListener('click', function (e) {
            const type = password_confirmation.getAttribute('type') === 'password' ? 'text' : 'password';
            password_confirmation.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });


    </script>
@endsection
