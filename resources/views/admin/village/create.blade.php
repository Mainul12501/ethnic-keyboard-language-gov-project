@extends('layouts.app')

@section('content')
    <div class="container-fluid pl-0 px-0">
        <div class="card mb-3">
            <div class="card-header">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.villages.index')}}">{{__('messages.গ্রামের তালিকা')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('messages.নতুন')}}</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                <form action="{{route('admin.villages.store')}}" method="post">
                    @csrf
                    <div class="col-md-6 row mb-2">
                        <div class="row mb-3">
                            <label  for="name">{{__('messages.গ্রামের নাম')}}{{__('')}}<span class="text-danger">*</span></label>
                            <div class=" input-group">
                                <input class="form-control @error('name') is-invalid @enderror" name="name" id="name" type="text" value="{{old('name')}}">
                                @error('name')
                                <span class="invalid-feedback">
                                    <strong>{{$message}}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label  for="union_id">{{__('messages.ইউনিয়ন')}} <span class="text-danger">*</span></label>
                            <div class=" input-group">
                                <select class="form-select @error('union_id') is-invalid @enderror" id="union_id" name="union_id">
                                    <option value="">{{__('messages.ইউনিয়ন নির্বাচন করুন')}}</option>
                                    @foreach($unions as $union)
                                    <option value="{{$union->id}}">{{$union->name}}</option>
                                    @endforeach
                                </select>
                                @error('union_id')
                                <span class="invalid-feedback">
                                    <strong>{{$message}}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 text-end">
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
        $('#union_id').select2({
            width: '100%',
            placeholder: "{{__('messages.ইউনিয়ন নির্বাচন করুন')}}",
            allowClear: true
        });

    </script>
@endsection
