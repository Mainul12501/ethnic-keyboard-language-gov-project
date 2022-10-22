@extends('layouts.app')

@section('content')
    <div class="container-fluid pl-0 px-0">
        <div class="card mb-3">
            <div class="card-header">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">{{__('messages.এডিট')}}</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                @if(Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ Session::get('success') }}
                        <button class="btn-close" type="button" data-coreui-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <form action="{{route('admin.speakers.update', $speaker->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="row mb-3">
                                <label class="" for="name">{{__('messages.নাম')}}<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="{{__('messages.নাম')}}" type="text" value="{{$speaker->name}}">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="" for="gender">{{__('messages.লিঙ্গ')}} <span class="text-danger">*</span></label>
                                <div class=" input-group">
                                    <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
                                        <option value="">{{__('messages.লিঙ্গ নির্বাচন করুন')}}</option>
                                        @foreach($genders as $key => $gender)
                                            <option value="{{$key}}" {{($key == $speaker->gender)? 'selected': ''}}>{{$gender}}</option>
                                        @endforeach
                                    </select>
                                    @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="" for="phone">{{__('messages.মোবাইল')}}</label>
                                <div class="input-group">
                                    <input class="form-control" name="phone" id="phone" placeholder="{{__('messages.মোবাইল')}}" type="number" value="{{$speaker->phone}}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="" for="district_id">{{__('messages.জেলা')}}</label>
                                <div class="input-group">
                                    <select class="form-select" id="district_id"  name="district_id">
                                        <option value="">{{__('messages.জেলা নির্বাচন করুন')}}</option>
                                        @foreach($districts as $key => $district)
                                            <option value="{{$key}}" {{($key == $speaker->district_id)? 'selected': ''}}>{{$district}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="" for="upazila_id">{{__('messages.উপজেলা')}}</label>
                                <div class="input-group">
                                    <select class="form-select" id="upazila_id" name="upazila_id">
                                        <option value="">উপজেলা নির্বাচন করুন</option>
                                        @foreach($upazilas as $key => $upazila)
                                            <option value="{{$key}}" {{($key == $speaker->upazila_id)? 'selected': ''}}>{{$upazila}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="" for="union_id">{{__('messages.ইউনিয়ন')}}</label>
                                <div class="input-group">
                                    <select class="form-select" id="union_id" name="union_id">
                                        <option value="">ইউনিয়ন নির্বাচন করুন</option>
                                        @foreach($unions as $key => $union)
                                            <option value="{{$key}}" {{($key == $speaker->union_id)? 'selected': ''}}>{{$union}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="" for="area">{{__('messages.গ্রাম/পাড়া/মহল্লা')}}</label>
                                <div class=" input-group">
                                    <input class="form-control @error('area') is-invalid @enderror" name="area" id="area" type="text" value="{{$speaker->area}}" >
                                    @error('area')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="row mb-3">
                                <label class="" for="image">{{__('messages.ছবি')}}</label>
                                <div class="col-md-2 col-sm-4">
                                    <div class="avatar avatar-md">
                                        <img  style="height: 40px;" class="avatar-img rounded" src="{{(!empty($speaker->image))? asset($speaker->image) : ''}}" alt="image">
                                    </div>
                                </div>
                                <div class=" col-md-10 col-sm-8">
                                    <input class="form-control" name="image" id="image" type="file" >
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="" for="email">{{__('messages.ইমেইল')}}</label>
                                <div class=" input-group">
                                    <input class="form-control @error('email') is-invalid @enderror" name="email" id="email" type="email" value="{{$speaker->email}}">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="" for="age">{{__('messages.বয়স')}}</label>
                                <div class=" input-group">
                                    <input class="form-control" name="age" id="age" type="number" value="{{$speaker->age}}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="" for="occupation">{{__('messages.পেশা')}}</label>
                                <div class=" input-group">
                                    <input class="form-control" name="occupation" id="occupation" type="text" value="{{$speaker->occupation}}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="" for="education">{{__('messages.সর্বোচ্চ শিক্ষা')}}</label>
                                <div class=" input-group">
                                    <input class="form-control" name="education" id="education" type="text" value="{{$speaker->education}}" >
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="" for="address">{{__('messages.ঠিকানা')}}</label>
                                <div class="input-group">
                                    <textarea class="form-control" name="address" id="address" cols="30" rows="4">{{$speaker->address}}</textarea>
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
@section('language-js')
    <script>
        $('select[name="district_id"]').on('change', function() {
            var disID = $(this).val();
            console.log(disID);
            if(disID) {
                $.ajax({
                    url:"{{url('admin/getUpazila')}}?district_id="+disID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $('select[name="upazila_id"]').empty();
                        $('#upazila_id').append('<option value="">{{__('messages.উপজেলা নির্বাচন করুন')}}</option>');
                        $.each(data, function(key, value) {
                            $('select[name="upazila_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                    }
                });
            }else{
                $('select[name="upazila_id"]').empty();
                $('select[name="union_id"]').empty();
            }
        });

        // select Union
        $('select[name="upazila_id"]').on('change', function() {
            var upazilaID = $(this).val();
            console.log(upazilaID);
            if(upazilaID) {
                $.ajax({
                    url: "{{url('admin/getUnion')}}?upazila_id="+upazilaID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $('select[name="union_id"]').empty();
                        $('#union_id').append('<option value="">{{__('messages.ইউনিয়ন নির্বাচন করুন')}}</option>');
                        $.each(data, function(key, value) {
                            $('select[name="union_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                    }
                });
            }else{
                $('select[name="union_id"]').empty();
            }
        });

        $('#district_id').select2({
            width: '100%',
            placeholder: "{{__('messages.জেলা নির্বাচন করুন')}}",
            allowClear: true
        });
        $('#upazila_id').select2({
            width: '100%',
            placeholder: "{{__('messages.উপজেলা নির্বাচন করুন')}}",
            allowClear: true
        });
        $('#union_id').select2({
            width: '100%',
            placeholder: "{{__('messages.ইউনিয়ন নির্বাচন করুন')}}",
            allowClear: true
        });

    </script>

@endsection
