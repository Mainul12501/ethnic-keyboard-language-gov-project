@extends('layouts.app')

@section('title', 'ভাষার তালিকা')

@section('content')
    <div class="container-fluid px-0">
        <div class="card mb-3">
            <div class="card-header">
                <ul class="nav nav-pills card-header-pills justify-content-between">
                    <ul class="nav nav-pills card-header-pills me-2">
                        <li class="nav-item"><a href="{{route('admin.directeds.index')}}">{{__('নির্দেশিত বাক্য তালিকা')}}</a></li>/
                        <li class="nav-item">{{isset($firstItem->topics)? $firstItem->topics->name:$topic->name}}</li>
                    </ul>

                    <ul class="nav nav-pills card-header-pills me-2">
                        <li class="nav-item">
                            <div class="row">
                                <div class="col-md-8">
                                    <form action="{{ route('admin.directed-file-import') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                          <div class="form-group mb-2" style="max-width: 500px; margin: 0 auto;">
                                               <div class="custom-file text-left">
                                                   <input type="file" name="file" class="custom-file-input" id="customFile">
                                                   {{-- <label class="custom-file-label" for="customFile">Choose file</label> --}}
                                               </div>
                                         </div>
                                         <button class="btn btn-primary btn-sm">Import data</button>
                                       </form>
                                </div>
                                <div class="col-md-4">
                                    <a class="btn btn-success btn-sm text-white" href="{{route('admin.directed_sentence.create', isset($firstItem->topic_id)? $firstItem->topic_id:$topic->id)}}">
                                        <svg class="icon me-2 text-white">
                                            <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-plus')}}"></use>
                                        </svg>{{__('messages.নতুন')}}</a>
                                </div>

                            </div>

                        </li>
                    </ul>
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
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="directedSentence">
                        <thead class="table-dark">
                        <tr>
                            <th scope="col" style="width: 7rem;">{{__('messages.ক্রমিক নং')}}</th>
                            <th scope="col">{{__('messages.বাংলা বাক্য')}}</th>
                            <th scope="col">{{__('messages.ইংরেজী বাক্য')}}</th>
                            <th scope="col" class="text-center">{{__('messages.অ্যাকশন')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($directedSentences as $key=>$directedSentence)
                            <tr>
                                <td>{{ ++ $key }}</td>
                                <td>
                                    {{$directedSentence->sentence}}
                                </td>
                                <td>
                                    {{$directedSentence->english}}
                                </td>
                                <td class="text-center">
                                    <div class="d-grid gap-2 d-md-flex justify-content-center">
                                        <a class="btn btn-purple btn-sm" href="{{route('admin.directed_sentence.edit', $directedSentence->id)}}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.directed_sentence.destroy', $directedSentence->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm show_confirm">
                                                <svg class="icon  text-white">
                                                    <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-trash')}}"></use>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                        @endforelse
                        </tbody>
                    </table>
                </div>
                {{--{{ $languages->links('vendor.pagination.custom') }}--}}
            </div>
        </div>


    </div>
@endsection

@section('language-filter-js')
    <script>
        // $(document).ready(function() {
        //     $('#directedSentence').DataTable();
        // } );

        // alertify delete
        $('.show_confirm').click(function(event) {
            var form =  $(this).closest("form");
            event.preventDefault();
            alertify.confirm('Whoops!', 'Are you sure you want to Delete?',
                function(){
                    form.submit();
                    // alertify.success('Ok')
                },
                function(){
                    // alertify.error('Cancel')
                });
        });
        $(document).ready(function() {
            $('#directedSentence').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    'print'
                ]
            } );
        } );
    </script>
@endsection

