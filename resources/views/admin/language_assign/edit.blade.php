@extends('layouts.app')

@section('content')
    <div class="container-fluid pl-0 px-0">
        <div class="card mb-3">
            <div class="card-header">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.language_assigns.index')}}">{{__('messages.অ্যাসাইন ভাষার তালিকা')}}</a></li>
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
                <form action="{{route('admin.language_assigns.update', $languageAssign->id)}}" method="post">
                    @csrf
                    @method("PUT")
                    <div class="row">
                        <div class="col-md-10 col-sm-12">
                            <div class="row mb-3">
                                <label  for="language_id">{{__('messages.ভাষার নাম')}}</label>
                                <div class=" input-group">
                                    <select class="form-select @error('language_id') is-invalid @enderror" id="language_id" name="language_id">
                                            <option value="{{$languageAssign->id}}" selected>{{$languageAssign->name}}</option>
                                    </select>
                                    @error('language_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class=" input-group" >
                                    <div class="form-check form-check-inline" style="width: 14rem;">
                                        <input class="form-check-input" name="directed" id="directed" type="checkbox" onclick="checkAll(document.getElementsByClassName('directed'),this)">
                                        <label class="form-check-label" for="directed">{{__('messages.নির্দেশিত')}}</label>
                                    </div>
                                </div>
                                <div class=" input-group directed">
                                    @foreach($directedTopics as $key => $directedTopic)
                                        <div class="form-check form-check-inline" style="width: 10rem;">
                                            {{ Form::checkbox('topic[]', $key, in_array($key, $directedAssign) ? true : false, array('class' => 'form-check-input')) }}
                                            <label class="form-check-label" for="topic"><small>{{ $directedTopic }}</small></label>
                                        </div>
                                    @endforeach
                                    @error('topic')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class=" input-group" >
                                    <div class="form-check form-check-inline" style="width: 14rem;">
                                        <input class="form-check-input" name="spontaneous" id="spontaneous" type="checkbox" onclick="checkAll(document.getElementsByClassName('spontaneous'),this)">
                                        <label class="form-check-label" for="spontaneous">{{__('messages.স্বতঃস্ফূর্ত')}}</label>
                                    </div>
                                </div>
                                <div class=" input-group spontaneous">
                                    @foreach($spontaneouses as $key =>$spontaneous)
                                        <div class="form-check form-check-inline" style="width: 10rem;">
                                            {{ Form::checkbox('spontaneous[]', $key, in_array($key, $spontaneousesAssign) ? true : false, array('class' => 'form-check-input')) }}
                                            <label class="form-check-label" for="spontaneous"><small>{{ $spontaneous }}</small></label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-12 text-end">
                                    <button class="btn btn-success text-white" type="submit">{{__('messages.জমা দিন')}}</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
@section('language-assign-js')
    <script>
        function checkAll(cname, bx) {
            for (var tbls = cname,i=tbls.length; i--; )
                for (var bxs=tbls[i].getElementsByTagName("input"),j=bxs.length; j--; )
                    if (bxs[j].type=="checkbox")
                        bxs[j].checked = bx.checked;
        }

       /* $('#directed-all-select').click(function () {
            $('input[type=checkbox]').not(this).prop('checked', this.checked);
        });
        $("#spontaneous-all-select").click(function(){
            $('input[id=spontaneous]').prop('checked', this.checked);

        });*/

    </script>
@endsection
