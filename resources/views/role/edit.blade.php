@extends('layouts.app')

@section('content')
    <div class="container-fluid pl-0 px-0">
        <div class="card mb-3">
            <div class="card-header">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.roles.index')}}">{{__('messages.রোলের তালিকা')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('messages.নতুন')}}</li>
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
                <form action="{{route('admin.roles.update', $role->id)}}" method="post">
                    @csrf
                    @method("PUT")
                    <div class="row">
                        <div class="col-md-10 col-sm-12">
                            <div class="row mb-3">
                                <label  for="name">{{__('messages.রোলের নাম')}}<span class="text-danger">*</span> </label>
                                <div class=" input-group">
                                    <input class="form-control @error('name') is-invalid @enderror" name="name" id="name" type="text" value="{{$role->name}}" required>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class=" input-group">
                                    <div class="form-check form-check-inline" style="width: 14rem;">
                                        <input class="form-check-input" name="all-permission" id="all-permission" onclick="checkPage(this)" type="checkbox">
                                        <label  for="name">{{__('messages.পারমিশন')}} <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class=" input-group">
                                    @foreach($permissions as $value)
                                        <div class="form-check form-check-inline" style="width: 14rem;">
                                            {{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'form-check-input')) }}
                                            <label class="form-check-label" for="spontaneous"><small>{{ $value->name }}</small></label>
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
@section('language-filter-js')
    <script>
        function checkPage(bx){
            for (var tbls = document.getElementsByTagName("div"),i=tbls.length; i--; )
                for (var bxs=tbls[i].getElementsByTagName("input"),j=bxs.length; j--; )
                    if (bxs[j].type=="checkbox")
                        bxs[j].checked = bx.checked;
        }
    </script>
@endsection
