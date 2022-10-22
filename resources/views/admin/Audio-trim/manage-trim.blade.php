@extends('layouts.app')

@section('content')
    <div class="container-fluid pl-0 px-0">
        <div class="card mb-3">
            <div class="card-header">
                <h4 class="card-header">Manage Audio</h4>
            </div>
            <div class="card-body">
                <div>
                    <div class="table-responsive">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <table class="table table-hover table-bordered" >
                                    <thead class="table-dark">
                                    <tr>
                                        <th scope="col">Serial no</th>
                                        <th scope="col">Audio</th>
                                        <th scope="col">Start Time</th>
                                        <th scope="col">End Time</th>
                                        {{-- <th scope="col">language</th> --}}
                                        <th scope="col" class="text-center">trim</th>
                                        {{-- <th scope="col" class="text-center">Action</th> --}}
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($audios as $audio)
                                        <tr>
                                            <form action="{{ route('trim-audio') }}" method="post" id="trimAudio{{ $audio->id }}">
                                                @csrf
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <audio src="{{ asset($audio->audio) }}" controls>
                                                        <source src="{{ asset($audio->audio) }}" type="audio/*">
                                                    </audio>
                                                    <input type="hidden" name="audio_id" value="{{ $audio->id }}" />
                                                    <input type="hidden" name="directed_id" value="{{ $audio->directed_id }}" />
                                                    <input type="hidden" name="spontaneous_id" value="{{ $audio->spontaneous_id }}" />
                                                </td>
                                                <td><input type="number"  name="skip_time" class="form-control"/></td>
                                                <td><input type="number"  name="audio_duration" class="form-control"/></td>
                                                <td>
                                                    <select name="language" id="" class="form-control">
                                                        <option value="" selected disabled>Select a audio language</option>
                                                        <option value="bangla">Bangla</option>
                                                        <option value="english">English</option>
                                                        <option value="transcription">Transcription</option>
                                                    </select>
                                                </td>
                                                <td><input type="submit" class="btn btn-sm btn-success trim text-white" data-id="{{ $audio->id }}" value="trim"></td>
                                                {{-- <td><a href="{{ route('del-trim-audio', ['id' => $audio->id]) }}" class="btn btn-sm btn-success trim text-white">Delete</a></td> --}}
                                            </form>
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
    <script>
        $(document).on('click', '.trim', function (){
            event.preventDefault();
            var audioId = $(this).data('id');
            document.getElementById('trimAudio'+audioId).submit();
        })
    </script>
@endsection
