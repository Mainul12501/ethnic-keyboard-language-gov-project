<div class="modal fade" id="validatorForm" tabindex="-1" aria-labelledby="speakerTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{route('admin.speakers.validatorStore')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('messages.নতুন')}}</h5>
                    <button class="btn-close" type="button" data-coreui-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="taskAssignID" name="task_assign_id">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">

                            <div class="row mb-3">
                                <label class="" for="name">{{__('messages.নাম')}}<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="{{__('messages.নাম')}}" type="text" value="{{old('name')}}">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="" for="gender">{{__('messages.লিঙ্গ')}} <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
                                        <option value="">{{__('messages.লিঙ্গ নির্বাচন করুন')}}</option>
                                        <option value="0">{{__('messages.পুরুষ')}}</option>
                                        <option value="1">{{__('messages.মহিলা')}}</option>
                                        <option value="2">{{__('messages.অন্যান্য')}}</option>
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
                                    <input class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" placeholder="{{__('messages.মোবাইল')}}" type="number" value="{{old('phone')}}">
                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="" for="district_id">{{__('messages.জেলা')}}</label>
                                <div class="input-group">
                                    <select class="form-select" id="district_id"  name="district_id">
                                        <option value="">{{__('messages.জেলা নির্বাচন করুন')}}</option>
                                        @foreach($districts as $key => $district)
                                            <option value="{{$key}}">{{$district}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="" for="upazila_id">{{__('messages.উপজেলা')}}</label>
                                <div class="input-group">
                                    <select class="form-select @error('upazila_id') is-invalid @enderror" id="upazila_id" name="upazila_id">
                                    </select>

                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="" for="union_id">{{__('messages.ইউনিয়ন')}}</label>
                                <div class="input-group">
                                    <select class="form-select @error('union_id') is-invalid @enderror" id="union_id" name="union_id">
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="" for="area">{{__('messages.গ্রাম/পাড়া/মহল্লা')}}</label>
                                <div class="input-group">
                                    <input class="form-control" name="area" id="area" placeholder="{{__('messages.গ্রাম/পাড়া/মহল্লা')}}" type="text" value="{{old('area')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="row mb-3">
                                <label class="" for="image">{{__('messages.ছবি')}}</label>
                                <div class="input-group">
                                    <input class="form-control" name="image" id="image" type="file" >
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="" for="email">{{__('messages.ইমেইল')}}</label>
                                <div class="input-group">
                                    <input class="form-control" name="email" id="email" placeholder="{{__('messages.ইমেইল')}}" type="email" value="{{old('email')}}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="" for="age">{{__('messages.বয়স')}}</label>
                                <div class="input-group">
                                    <input class="form-control" name="age" id="age" placeholder="{{__('messages.বয়স')}}" type="number" value="{{old('age')}}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="" for="occupation">{{__('messages.পেশা')}}</label>
                                <div class="input-group">
                                    <input class="form-control" name="occupation" id="occupation" placeholder="{{__('messages.পেশা')}}" type="text" value="{{old('occupation')}}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="" for="education">{{__('messages.সর্বোচ্চ শিক্ষা')}}</label>
                                <div class="input-group">
                                    <input class="form-control" name="education" id="education" placeholder="{{__('messages.সর্বোচ্চ শিক্ষা')}}" type="text" value="{{old('education')}}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="" for="address">{{__('messages.ঠিকানা')}}</label>
                                <div class="input-group">
                                    <textarea class="form-control" name="address" id="address" placeholder="{{__('messages.ঠিকানা')}}" cols="30" rows="4"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger btn-sm text-white" type="button" data-coreui-dismiss="modal">{{__('messages.বন্ধ করুন')}}</button>
                    <button class="btn btn-success btn-sm text-white" type="submit">{{__('messages.জমা দিন')}}</button>
                </div>
            </div>
        </form>
    </div>
</div>

