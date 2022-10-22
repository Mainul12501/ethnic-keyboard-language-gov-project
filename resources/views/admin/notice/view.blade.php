@extends('layouts.app')

@section('content')
    <div class="container-fluid pl-0 px-0">
        <div class="card mb-3">
            <div class="card-header">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"></a>{{__('messages.বিজ্ঞপ্তি')}}</li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('messages.নতুন')}}</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                <div class="card">
                    <div class="card-header">{{__('messages.বিজ্ঞপ্তি')}}</div>
                    <div class="card-body">
                        <h5 class="card-title">{{$notice->title}}</h5>
                        <p class="card-text">{{$notice->body}}</p>
                    </div>
                    <div class="card-footer text-medium-emphasis">{{$notice->created_at->diffForHumans()}}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
