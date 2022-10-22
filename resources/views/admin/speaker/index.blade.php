@extends('layouts.app')

@section('title', 'স্পিকার তালিকা')

@section('content')
    <div class="container-fluid px-0">
        <div class="card mb-3">
            <div class="card-header">
                <ul class="nav nav-pills card-header-pills justify-content-between">
                    <li class="nav-item">স্পিকার</li>
                    <li class="nav-item">
                        <button class="btn btn-sm btn-success text-white speaker-create" type="button" > {{__('messages.নতুন স্পিকার')}}</button>
                        {{-- <a class="btn btn-success text-white btn-sm" href="{{route('admin.speakers.create')}}">
                            <svg class="icon me-2 text-white">
                                <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-plus')}}"></use>
                            </svg>নতুন</a> --}}
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
                @if(Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ Session::get('success') }}
                        <button class="btn-close" type="button" data-coreui-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="d-flex justify-content-between">
                    <div  class="col-md-4">
                        <div class="row" id="filterSearch" style="display: none">
                            <form>
                                <div class="input-group d-flex">
                                    <input type="text" class="form-control" placeholder="ভাষার নাম খুঁজুন">
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary" type="submit">
                                            <svg class="icon me-2">
                                                <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-search')}}"></use>
                                            </svg>খুঁজুন
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-check form-switch form-switch-xl mb-4">
                            <label class="form-check-label" for="flexSwitchCheckDefault">Filter</label>
                            <input class="form-check-input" onclick="searchBox()" id="flexSwitchCheckDefault" type="checkbox">
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" >
                        <thead class="table-dark">
                        <tr>
                            <th scope="col">ক্রমিক নং</th>
                            <th scope="col">নাম</th>
                            {{-- <th scope="col">ফটো</th> --}}
                            <th scope="col">ফোন</th>
                            <th scope="col">ইমেইল</th>
                            <th scope="col">লিঙ্গ</th>
                            <th scope="col">বয়স</th>
                            <th scope="col">সর্বোচ্চ শিক্ষা</th>
                            <th scope="col" class="text-center">অ্যাকশন</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($speakers as $key=>$speaker)
                            <tr>
                                <td>{{ $speakers->firstItem() + $key }}</td>
                                <td class="align-middle">{{$speaker->name}}</td>
                                {{-- <td class="align-middle">
                                    <div class="avatar avatar-md">
                                        <img style="height: 40px;" class="avatar-img" src="{{(!empty($speaker->image))? asset($speaker->image) : asset('assets/coreui/assets/img/avatars/8.jpg')}}" alt="image">
                                    </div>
                                </td> --}}
                                <td class="align-middle"><a href="tel:{{$speaker->phone}}">{{$speaker->phone}}</a></td>
                                <td class="align-middle"><a href="mailto:{{$speaker->email}}">{{$speaker->email}}</a></td>
                                @if($speaker->sex == 0)
                                <td class="align-middle">পুরুষ</td>
                                @elseif($speaker->sex == 1)
                                    <td class="align-middle">মহিলা</td>
                                @else
                                    <td class="align-middle">অন্যান্য</td>
                                @endif
                                <td class="align-middle">{{$speaker->age}}</td>
                                <td class="align-middle">{{$speaker->education}}</td>
                                <td class="text-center">
                                    <div class="d-grid gap-2 d-md-flex justify-content-center">
                                        {{--<a class="btn btn-info btn-sm" href="{{route('admin.speakers.show', $speaker->id)}}">
                                            <svg class="icon  text-white">
                                                <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-low-vision')}}"></use>
                                            </svg>
                                        </a>--}}
                                        <a class="btn btn-purple btn-sm" href="{{route('admin.speakers.edit', $speaker->id)}}">
                                            <svg class="icon  text-white">
                                                <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-color-border')}}"></use>
                                            </svg>
                                        </a>
                                        @can('speaker-delete')
                                        <form action="{{ route('admin.speakers.destroy', $speaker->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">
                                                <svg class="icon  text-white">
                                                    <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-trash')}}"></use>
                                                </svg>
                                            </button>
                                        </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                {{ $speakers->links('vendor.pagination.custom') }}
            </div>
        </div>
    </div>
    <!-- Speaker create modal-->
    @include('admin.speaker.new_speaker_create')
@endsection

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
                // var topicID = $("#topic_id").val();
                // var directedID = $("#directed_id").val();

                $('#speakerForm').modal('show');
                $.ajax({
                    type: "GET",
                    url: "{{ route('admin.speakers.create')}}" + '/',
                    dataType: 'json',
                    // data: {taskAssignID:taskAssignID},
                    success:function (response){
                        console.log(response)
                        // $('#task_assign_id').val(taskAssignID);
                        // $('#topicID').val(topicID);
                        // $('#directedID').val(directedID);
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
                        url:"{{url('admin/getDistrict')}}?language_id="+languageID,
                        type: "GET",
                        dataType: "json",
                        success:function(data) {
                            $('select[name="district"]').empty();
                            $('select[name="upazila"]').empty()
                            $('select[name="union"]').empty();
                            $('select[name="village"]').empty();
                            $('#district').append('<option value="">{{__('messages.জেলা নির্বাচন করুন')}}</option>');
                            $.each(data, function(key, value) {
                                $('select[name="district"]').append('<option value="'+ key +'">'+ value +'</option>');
                            });
                        }
                    });
                }else{
                    $('select[name="district"]').empty()
                    $('select[name="upazila"]').empty()
                    $('select[name="union"]').empty();
                    $('select[name="village"]').empty();
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

