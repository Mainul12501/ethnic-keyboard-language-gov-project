@extends('layouts.app')

@section('title', '')

@section('content')
    <div class="container-fluid px-0">
        <div class="card mb-3">
            <div class="card-header">
                <ul class="nav nav-pills card-header-pills justify-content-between">
                    <li class="nav-item">{{__('নির্দেশিত বিষয় তালিকা')}}</li>
                    {{-- <li class="nav-item">
                        <button class="btn btn-success btn-sm text-white" type="button" data-coreui-toggle="modal" data-coreui-target="#directedForm">
                            <svg class="icon me-2 text-white">
                                <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-plus')}}"></use>
                            </svg>{{__('messages.নতুন')}}
                        </button>
                    </li> --}}
                    <li class="nav-item">
                        <div class="row">
                            <div class="col-md-8">
                                <form action="{{ route('admin.file-import') }}" method="POST" enctype="multipart/form-data">
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
                                <button class="btn btn-success btn-sm text-white" type="button" data-coreui-toggle="modal" data-coreui-target="#directedForm">
                                    <svg class="icon me-2 text-white">
                                        <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-plus')}}"></use>
                                    </svg>{{__('messages.নতুন')}}
                                </button>
                            </div>

                        </div>
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
                {{--@if(Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ Session::get('success') }}
                        <button class="btn-close" type="button" data-coreui-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif--}}
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="directedDataTable">
                        <thead class="table-dark">
                        <tr>
                            <th scope="col"  style="width: 7rem;">{{__('messages.ক্রমিক নং')}}</th>
                            <th scope="col">{{__('messages.বিষয়')}}</th>
                            <th scope="col">{{__('Created At')}}</th>
                            <th scope="col" class="text-center">{{__('messages.অ্যাকশন')}}</th>
                        </tr>
                        </thead>

                        <tbody>

                        @foreach($directedTopics as $key=> $directedTopic)
                            <tr>
                                <td>{{  ++ $key }}</td>
                                <td class="">
                                    {{$directedTopic->name}}
                                </td>
                                <td class="">
                                    {{$directedTopic->created_at}}
                                </td>
                                <td class="text-center">
                                    <div class="d-grid gap-2 d-md-flex justify-content-center">
                                        <a class="btn btn-success btn-sm" href="{{route('admin.directed_sentence.index', $directedTopic->id)}}">
                                            <i class="text-white far fa-plus"></i>
                                        </a>
                                        <button class="btn btn-purple btn-sm editbtn" type="button" value="{{$directedTopic->id}}" data-coreui-toggle="modal" data-coreui-target="#directedEditForm">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('admin.directeds.destroy', $directedTopic->id) }}" method="post">
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
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{--{{ $directeds->links('vendor.pagination.custom') }}--}}
            </div>
        </div>
    </div>


    {{--    edit modal --}}
    @include('admin.directed.edit')

    <!-- directed create modal-->
    @include('admin.directed.create')

@endsection

@section('language-filter-js')
    <script>
        $(document).ready(function() {
            $('#directedDataTable').DataTable();
        } );
        // alertify delete
        $('.show_confirm').click(function(event) {
            var form =  $(this).closest("form");
            event.preventDefault();
            alertify.confirm('Whoops!', 'Are you sure you want to Delete? All releated data will be deleted',
                function(){
                    form.submit();
                    // alertify.success('Ok')
                },
                function(){
                    // alertify.error('Cancel')
                });
        });

        @if (count($errors) > 0)

        {{-- $( document ).ready(function() {
             $('#directedForm').modal('show');
         });--}}
        setTimeout(function() {
            $('.notification-object').css('display', 'none');
        }, 5000);
        @endif


        // add more input field
        $(document).ready(function () {
            var maxField = 10; // Total 5 product fields we add
            var addButton = $('.add_button'); // Add more button selector
            var wrapper = $('.field_wrapper'); // Input fields wrapper
            var fieldHTML = `<div class="row">
                        <div class="col-md-11">
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label" for="name">{{__('messages.বিষয়')}}</label>
                                <div class="col-sm-9">
                                    <input class="form-control" id="name" name="name[]" type="text" placeholder="{{__('messages.বিষয়')}}"  required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1 remove_button">
                            <a href="javascript:void(0);" class="btn btn-success btn-sm rounded-circle ">
                                <svg class="icon" style="width:0.5rem">
                                    <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-minus')}}"></use>
                                </svg>
                            </a>
                        </div>
                    </div>`; //New input field html

            var x = 1; //Initial field counter is 1

            $(addButton).click(function () {
                //Check maximum number of input fields
                if (x < maxField) {
                    x++; //Increment field counter
                    $(wrapper).append(fieldHTML);
                }
            });
            //Once remove button is clicked
            $(wrapper).on('click', '.remove_button', function (e) {
                e.preventDefault();
                $(this).parent('div').remove();
                x--; //Decrement field counter
            });
        });



        $(document).ready(function (){
            $(document).on('click', '.editbtn', function (){
                var topicID = $(this).val();
                // alert(directedID);

                $('#directedEditForm').modal('show');

                $.ajax({
                    type: "GET",
                    url: "/admin/directeds/"+topicID+"/edit",
                    dataType: 'json',
                    success:function (response){
                        console.log(response)
                        $('#topic_id').val(response.topic.id);
                        $('#name').val(response.topic.name);
                    }
                })
            })
        })
    </script>
@endsection

