@extends('layouts.app')

@section('content')
    <div class="container-fluid pl-0 px-0">
        <div class="card mb-3">
            <div class="card-header">
                <h6>{{__('messages.অডিও ট্রিমিং এর তালিকা')}} </h6>
                {{-- <a href="{{ url('admin/data_collections') }}" class="btn btn-success text-white" style="float: right">Audio Files</a> --}}
            </div>
            <div class="card-body">
                <div>
                    <div class="table-responsive">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <table class="table table-hover table-bordered" >
                                    <thead class="table-dark">
                                    <tr>
                                        <th scope="col">{{__('messages.ক্রমিক নং')}}</th>
                                        <th scope="col">{{__('messages.অডিও ট্রিম')}} </th>
                                        {{-- <th scope="col">Trim Audio</th> --}}
                                        <th scope="col">{{__('messages.বাংলা')}} </th>
                                        <th scope="col">{{__('messages.ইংরেজী')}}</th>
                                        <th scope="col">{{__('messages.উচ্চারণ')}} </th>
                                        <th scope="col" class="text-center">{{__('messages.অ্যাকশন')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($audios as $audio)
                                        <tr>

                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <audio src="{{ asset($audio->audio) }}" controls>
                                                        <source src="{{ asset($audio->audio) }}" type="audio/*">
                                                    </audio>
                                                </td>
                                                {{-- <td>
                                                    @if($audio->bangla != '')
                                                        <audio src="{{ asset($audio->bangla) }}" controls>
                                                            <source src="{{ asset($audio->bangla) }}" type="audio/*">
                                                        </audio>
                                                    @endif
                                                    @if($audio->english != '')
                                                        <audio src="{{ asset($audio->english) }}" controls>
                                                            <source src="{{ asset($audio->english) }}" type="audio/*">
                                                        </audio>
                                                    @endif
                                                    @if($audio->transcription != '')
                                                        <audio src="{{ asset($audio->transcription) }}" controls>
                                                            <source src="{{ asset($audio->transcription) }}" type="audio/*">
                                                        </audio>
                                                    @endif
                                                </td> --}}
                                                <td>{{ $audio->bangla }}</td>
                                                <td>{{ $audio->english }}</td>
                                                <td>{{ $audio->transcription }}</td>

                                            <td>
                                                <a href="{{ route('del-trim-audio', ['id' => $audio->id]) }}" onclick="return confirm('Are you sure you want to Delete?')" class="btn btn-sm btn-success trim text-white">{{__('messages.বাদ দিন')}} </a>
                                            </td>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('language-js')

@endsection
