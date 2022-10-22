<div class="modal fade" id="speakerForm" tabindex="-1" aria-labelledby="speakerTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{route('admin.speakers.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('messages.নতুন')}}</h5>
                    <button class="btn-close" type="button" data-coreui-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            {{-- <input type="hidden" id="task_assign_id" name="task_assign_id"> --}}
                            {{-- <input type="hidden" id="spontaneousID" name="spontaneous_id">
                            <input type="hidden" id="topicID" name="topic_id">
                            <input type="hidden" id="directedID" name="directed_id"> --}}
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
                                <label class="" for="language_id">{{__('messages.ভাষার নাম')}}<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <select class="form-select  @error('language_id') is-invalid @enderror"  id="language_id" name="language_id">
                                        <option value="">{{__('messages.ভাষা নির্বাচন করুন')}}</option>
                                        @foreach($languages as $value)
                                            <option value="{{$value->language_id}}">{{$value->language->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('language_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="" for="district">{{__('messages.জেলা')}}<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <select class="form-select @error('district') is-invalid @enderror" id="district"  name="district_id">
                                        {{--<option value="">জেলা নির্বাচন করুন</option>
                                        @foreach($districts as $key => $district)
                                            <option value="{{$key}}">{{$district}}</option>
                                        @endforeach--}}
                                    </select>
                                    @error('district')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            {{-- <input type="hidden" id="language_district_id" name="language_district_id"> --}}
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
                            {{-- <div class="row mb-3">
                                <label class="" for="district">{{__('messages.জেলা')}}</label>
                                <div class="input-group">
                                    <select class="form-select" id="district"  name="district">
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
                            </div> --}}
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


@section('language-filter-js')
    <script>
        // filter search
        function searchBox() {
            var x = document.getElementById("filterSearch");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        }

        @if (count($errors) > 0)
        $( document ).ready(function() {
            $('#speakerForm').modal('show');
        });
        @endif
        $(document).ready(function (){
            $(document).on('click', '.speaker-create', function (){
                var taskAssignID = $(this).val();
                var topicID = $("#topic_id").val();
                var directedID = $("#directed_id").val();

                $('#speakerForm').modal('show');
                $.ajax({
                    type: "GET",
                    url: "{{ route('admin.speakers.create')}}" + '/',
                    dataType: 'json',
                    // data: {taskAssignID:taskAssignID},
                    success:function (response){
                        console.log(response)
                        // $('#task_assign_id').val(taskAssignID);
                        $('#topicID').val(topicID);
                        $('#directedID').val(directedID);
                    }
                })
            })
        });
        // select Districts
        $('select[name="language_id"]').on('change', function() {
                var languageID = $(this).val();
                console.log(languageID);
                if(languageID) {
                    $.ajax({
                        url:"{{url('admin/getLangDistrict')}}?language_id="+languageID,
                        type: "GET",
                        dataType: "json",
                        // console.log(district)
                        success:function(data) {
                            $('select[name="district_id"]').empty();
                            // $('select[name="upazila"]').empty()
                            // $('select[name="union"]').empty();
                            // $('select[name="village"]').empty();
                            $('#district').append('<option value="">{{__('messages.জেলা নির্বাচন করুন')}}</option>');
                            $.each(data, function(key, value) {
                                $('select[name="district_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                            });
                            console.log(district)
                        }
                    });
                }else{
                    $('select[name="district_id"]').empty();
                    // $('select[name="upazila"]').empty()
                    // $('select[name="union"]').empty();
                    // $('select[name="village"]').empty();
                }
            });
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
            dropdownParent: $("#speakerForm"),
            width: '100%',
            placeholder: "{{__('messages.জেলা নির্বাচন করুন')}}",
            allowClear: true
        });
        $('#upazila_id').select2({
            dropdownParent: $("#speakerForm"),
            width: '100%',
            placeholder: "{{__('messages.উপজেলা নির্বাচন করুন')}}",
            allowClear: true
        });
        $('#union_id').select2({
            dropdownParent: $("#speakerForm"),
            width: '100%',
            placeholder: "{{__('messages.ইউনিয়ন নির্বাচন করুন')}}",
            allowClear: true
        });

    </script>
@endsection
