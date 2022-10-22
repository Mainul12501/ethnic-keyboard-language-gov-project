@extends('layouts.app')

@section('content')
    <div class="container-fluid pl-0 px-0">
        <div class="card mb-3">
            <div class="card-header">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"></a>{{__('messages.বিজ্ঞপ্তি')}} </li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('messages.নতুন')}}</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                {{-- @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif --}}
                <form action="{{route('admin.notices.store')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-7 col-sm-12">
                            <div class="row">
                                <div class=" input-group">
                                    <div class="form-check form-check-inline" style="width: 14rem;">
                                        <input class="form-check-input" name="all-users" id="all-users" onclick="checkPage(this)" type="checkbox">
                                        <label class="form-check-label" for="all-users"><strong>{{__('messages.সব নির্বাচন করুন')}}</strong></label>
                                    </div>
                                </div>
                                <hr>
                            </div>

                            <div class="row mb-3">
                                <div class=" input-group" >
                                    <div class="form-check form-check-inline" style="width: 14rem;">
                                        <input class="form-check-input" name="collectors" id="collectors" type="checkbox" onclick="checkAll(document.getElementsByClassName('collectors'),this)">
                                        <label class="form-check-label" for="collectors"><strong>{{__('messages.ডাটা কালেক্টর')}}</strong></label>
                                    </div>
                                </div>
                                <hr>
                                <div class=" input-group collectors">
                                    @foreach($collectors as $key =>$collector)
                                    <div class="form-check form-check-inline" style="width: 14rem;">
                                        <input class="form-check-input" name="user_id[]" id="{{$key}}" type="checkbox" value="{{$key}}">
                                        <label class="form-check-label" for="user_id"><small>{{$collector}}</small></label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class=" input-group">
                                    <div class="form-check form-check-inline" style="width: 14rem;">
                                        <input class="form-check-input" name="managers" id="managers" type="checkbox" onclick="checkAll(document.getElementsByClassName('managers'),this)">
                                        <label class="form-check-label" for="managers"><strong>{{__('messages.ম্যানেজার')}}</strong></label>
                                    </div>
                                </div>
                                <hr>
                                <div class=" input-group managers">
                                    @foreach($dataCollectors as $key =>$dataCollector)
                                        <div class="form-check form-check-inline" style="width: 14rem;">
                                            <input class="form-check-input" name="user_id[]" id="{{$key}}" type="checkbox" value="{{$key}}">
                                            <label class="form-check-label" for="user_id"><small>{{$dataCollector}}</small></label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class=" input-group">
                                    <div class="form-check form-check-inline" style="width: 14rem;">
                                        <input class="form-check-input" name="supervisors" id="supervisors" type="checkbox" onclick="checkAll(document.getElementsByClassName('supervisors'),this)">
                                        <label class="form-check-label" for="supervisors"><strong>{{__('messages.সুপারভাইজর')}}</strong></label>
                                    </div>
                                </div>
                                <hr>
                                <div class=" input-group supervisors">
                                    @foreach($linguists as $key =>$linguist)
                                        <div class="form-check form-check-inline" style="width: 14rem;">
                                            <input class="form-check-input" name="user_id[]" id="{{$key}}" type="checkbox" value="{{$key}}">
                                            <label class="form-check-label" for="user_id"><small>{{$linguist}}</small></label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class=" input-group">
                                    <div class="form-check form-check-inline" style="width: 14rem;">
                                        <input class="form-check-input" name="linguists" id="linguists" type="checkbox" onclick="checkAll(document.getElementsByClassName('linguists'),this)">
                                        <label class="form-check-label" for="linguists"><strong>{{__('messages.ভাষাবিদ')}}</strong></label>
                                    </div>
                                </div>
                                <hr>
                                <div class=" input-group linguists">
                                    @foreach($linguists as $key =>$validator)
                                        <div class="form-check form-check-inline" style="width: 14rem;">
                                            <input class="form-check-input" name="user_id[]" id="{{$key}}" type="checkbox" value="{{$key}}">
                                            <label class="form-check-label" for="user_id"><small>{{$validator}}</small></label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row ">
                                        <label class="" for="title">{{__('messages.সাবজেক্ট')}}</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control {{--@error('title') is-invalid @enderror--}}" name="title" id="title" value="{{old('title')}}" placeholder="{{__('messages.সাবজেক্ট')}}" required>
                                            @error('title')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="row ">
                                        <label class="" for="body" >{{__('messages.মেসেজ')}}</label>
                                        <div class="input-group">
                                            <textarea class="form-control @error('body') is-invalid @enderror" name="body" id="body" cols="30" rows="10"  placeholder="{{__('messages.মেসেজ')}}">{{old('body')}}</textarea>
                                            @error('body')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="row ">
                                       
                                        <div class="input-group">
                                            <textarea class="form-control @error('body') is-invalid @enderror" name="body" id="body" cols="30" rows="10"  placeholder="{{__('messages.মেসেজ')}}">{{old('body')}}</textarea>
                                            @error('body')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12 text-end">
                                <button class="btn btn-success text-white" type="submit">{{__('messages.জমা দিন')}}</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
@section('language-filter-js')
    <script>

        function checkAll(cname, bx) {
            for (var tbls = cname,i=tbls.length; i--; )
                for (var bxs=tbls[i].getElementsByTagName("input"),j=bxs.length; j--; )
                    if (bxs[j].type=="checkbox")
                        bxs[j].checked = bx.checked;
        }

        function checkPage(bx){
            for (var tbls = document.getElementsByTagName("div"),i=tbls.length; i--; )
                for (var bxs=tbls[i].getElementsByTagName("input"),j=bxs.length; j--; )
                    if (bxs[j].type=="checkbox")
                        bxs[j].checked = bx.checked;
        }

        //loader
        $(function() {
            $( "form" ).submit(function() {
                $('#loader').show();
            });
        });

    </script>
@endsection
