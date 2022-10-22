@extends('layouts.app')

@section('content')
    <div class="container-fluid pl-0 px-0">
        <div class="card mb-3">
            <div class="card-header">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">{{__('messages.দায়িত্বপ্রাপ্ত ব্যক্তিবর্গ ')}}</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.data_collectors.index')}}">{{__('messages.ডাটা কালেক্টর তালিকা')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('messages.নতুন')}}</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                <form action="{{route('admin.data_collectors.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="row mb-3">
                                <label for="name">{{__('messages.নাম')}}  <span class="text-danger">*</span></label>
                                <div class="input-group ">
                                    <input class="form-control @error('name') is-invalid @enderror" name="name" id="name" type="text" placeholder="{{__('messages.নাম')}}" value="{{old('name')}}" required>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="phone">{{__('messages.মোবাইল')}} <span class="text-danger">*</span></label>
                                <div class="input-group ">
                                    <input class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" type="number" placeholder="{{__('messages.মোবাইল')}}" value="{{old('phone')}}" required>
                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email">{{__('messages.ইমেইল')}}<span class="text-danger">*</span></label>
                                <div class="input-group ">
                                    <input class="form-control @error('email') is-invalid @enderror" name="email" id="email" type="email" placeholder="{{__('messages.ইমেইল')}}" value="{{old('email')}}" required>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label  for="password">{{__('messages.পাসওয়ার্ড')}} <span class="text-danger">*</span></label>
                                <div class="input-group ">
                                    <input class="form-control @error('password') is-invalid @enderror" name="password" id="password" type="password" placeholder="{{__('messages.পাসওয়ার্ড')}}" required autocomplete="new-password" >
                                    <button class="btn btn-outline-secondary" id="button-addon2" type="button"><i class="far fa-eye" id="togglePassword" style=" cursor: pointer;"></i></button>

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="password_confirmation">{{__('messages.পাসওয়ার্ড নিশ্চিত করুন')}} <span class="text-danger">*</span></label>
                                <div class="input-group  ">
                                    <input class="form-control" name="password_confirmation" id="password_confirmation" placeholder="{{__('messages.পাসওয়ার্ড নিশ্চিত করুন')}}" type="password" required>
                                    <button class="btn btn-outline-secondary" id="button-addon2" type="button">
                                        <i class="far fa-eye" id="toggleConPassword" style=" cursor: pointer;"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="nid">{{__('messages.এনআইডি')}} <span class="text-danger">*</span></label>
                                <div class="input-group ">
                                    <input class="form-control @error('nid') is-invalid @enderror" name="nid" id="nid" placeholder="{{__('messages.এনআইডি')}}" type="number" value="{{old('nid')}}">
                                    @error('nid')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="row mb-3">
                                <label  for="avatar">{{__('messages.ছবি')}} <span class="text-danger">*</span></label>
                                <div class="input-group ">
                                    <input class="form-control @error('avatar') is-invalid @enderror" name="avatar" id="avatar" type="file" >
                                    @error('avatar')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label  for="join_date">{{__('messages.যোগদান তারিখ')}} <span class="text-danger">*</span></label>
                                <div class="input-group ">
                                    <input class="form-control @error('join_date') is-invalid @enderror" name="join_date" id="join_date" type="date" placeholder="{{__('messages.যোগদান তারিখ')}}" value="{{old('join_date')}}" required>
                                    @error('join_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label  for="education">{{__('messages.সর্বোচ্চ শিক্ষা')}}</label>
                                <div class="input-group ">
                                    <input class="form-control @error('education') is-invalid @enderror" name="education" id="education" type="text" placeholder="{{__('messages.সর্বোচ্চ শিক্ষা')}}" value="{{old('education')}}">
                                    @error('education')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label  for="short_bio">{{__('messages.বায়োগ্রাফি')}}</label>
                                <div class="input-group ">
                                    <textarea class="form-control @error('short_bio') is-invalid @enderror" name="short_bio" id="short_bio" cols="30" rows="3" placeholder="{{__('messages.বায়োগ্রাফি')}}"></textarea>
                                    @error('short_bio')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label  for="address">{{__('messages.ঠিকানা')}}</label>
                                <div class="input-group ">
                                    <textarea class="form-control @error('address') is-invalid @enderror" name="address" id="address" cols="30" rows="3" placeholder="{{__('messages.ঠিকানা')}}"></textarea>
                                    @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
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
