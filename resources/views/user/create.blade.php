@extends('layouts.app')

@section('content')
    <div class="container-fluid pl-0 px-0">
        <div class="card mb-3">
            <div class="card-header">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.users.index')}}">{{__('messages.ইউজার তালিকা')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('messages.নতুন')}}</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                <form action="{{route('admin.users.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="row mb-3">
                                <label  for="name">{{__('messages.নাম')}} <span class="text-danger">*</span></label>
                                <div class=" input-group">
                                    <input class="form-control @error('name') is-invalid @enderror" name="name" id="name" type="text" placeholder="{{__('messages.নাম')}}" value="{{old('name')}}" required>
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
                                    <input class="form-control @error('email') is-invalid @enderror" name="email" id="email" type="email" placeholder="{{__('messages.ইমেইল')}}" value="{{old('email')}}" required>
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
                                    <input class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" type="number" placeholder="{{__('messages.মোবাইল')}}" value="{{old('phone')}}" required>
                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label  for="role">{{__('messages.রোল')}} <span class="text-danger">*</span></label>
                                <div class=" input-group">
                                    <select class="form-select @error('role') is-invalid @enderror" id="role" name="role">
                                        <option value="">{{__('messages.রোল নির্বাচন করুন')}}</option>
                                         @foreach($roles as $role)
                                            <option value="{{$role}}">{{$role}}</option>
                                         @endforeach
                                    </select>
                                    @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="row mb-3">
                                <label  for="avatar">{{__('messages.প্রোফাইল ছবি')}} <span class="text-danger">*</span></label>
                                <div class=" input-group">
                                    <input class="form-control @error('avatar') is-invalid @enderror" name="avatar" id="avatar" type="file" value="{{old('avatar')}}" required>
                                    @error('avatar')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label  for="password">{{__('messages.পাসওয়ার্ড')}} <span class="text-danger">*</span></label>
                                <div class=" input-group">
                                    <input class="form-control @error('password') is-invalid @enderror" name="password" id="password" type="password" placeholder="{{__('messages.পাসওয়ার্ড')}}" required>
                                    <button class="btn btn-outline-secondary" id="button-addon2" type="button">
                                        <i class="far fa-eye" id="togglePassword" style=" cursor: pointer;"></i>
                                    </button>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label  for="password_confirmation">{{__('messages.পাসওয়ার্ড নিশ্চিত করুন')}} <span class="text-danger">*</span></label>
                                <div class=" input-group">
                                    <input class="form-control" name="password_confirmation" id="password_confirmation" type="password" placeholder="{{__('messages.পাসওয়ার্ড নিশ্চিত করুন')}}" required>
                                    <button class="btn btn-outline-secondary" id="button-addon2" type="button">
                                        <i class="far fa-eye" id="toggleConPassword" style=" cursor: pointer;"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-12 text-end">
                            <button class="btn btn-success text-white" type="submit">{{__('messages.জমা দিন')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('show-hide-password-js')
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
