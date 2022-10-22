@extends('layouts.app')

@section('title', '')

@section('content')
    <div class="container-fluid px-0">
        <div class="card mb-3">
            <div class="card-header">
                <ul class="nav nav-pills card-header-pills justify-content-between">
                    <li class="nav-item">{{__('messages.নির্দেশিত তালিকা')}}</li>
                    <li class="nav-item">
                        <button class="btn btn-success btn-sm text-white" type="button" data-coreui-toggle="modal" data-coreui-target="#directedForm">
                            <svg class="icon me-2 text-white">
                                <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-plus')}}"></use>
                            </svg>{{__('messages.নতুন')}}
                        </button>
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
                <div class="d-flex justify-content-end mb-3">
                    <div  class="col-md-3">
                        <div class="row" id="filterSearch" style="display: block">
                            <form>
                                <div class="input-group">
                                    <input type="text" id="search" name="search" class="form-control" value="{{request('search')}}" placeholder="{{__('messages.খুঁজুন')}}">
                                    <a class="btn bg-transparent" id="remove" href="{{route('admin.directeds.index')}}"  data-toggle="tooltip" data-placement="top" title="Clear" style="display: none; margin-left: -40px; z-index: 100;">
                                        <svg class="icon text-dark">
                                            <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-x-circle')}}"></use>
                                        </svg>
                                    </a>
                                    <button class="btn btn-success text-white" type="submit">
                                        <svg class="icon me-2 text-white">
                                            <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-search')}}"></use>
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="directedDataTable">
                        <thead class="table-dark">
                        <tr>
                            <th scope="col"  style="width: 7rem;">{{__('messages.ক্রমিক নং')}}</th>
                            <th scope="col" style="width: 10rem;">{{__('messages.বিষয়')}}</th>
                            <th scope="col">{{__('messages.বাংলা বাক্য')}}</th>
                            <th scope="col">{{__('messages.ইংরেজী বাক্য')}}</th>
                            <th scope="col" class="text-center">{{__('messages.অ্যাকশন')}}</th>
                        </tr>
                        </thead>

                        <tbody>

                        @foreach($directeds as $key=> $directed)
                            <tr>
                                <td>{{  ++ $key }}</td>
                                <td class="d-flex justify-content-between">
                                    {{$directed->name}}
                                    <a onclick="clickItem({{$key}})" class="text-decoration-none" data-coreui-toggle="collapse" href="#collapseDirected{{$key}}" aria-expanded="false" aria-controls="collapseExample">
                                        <svg class="icon" id="hide{{$key}}">
                                            <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-chevron-circle-down-alt')}}"></use>
                                        </svg>
                                        <svg class="icon" id="show{{$key}}" style="display: none">
                                            <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-chevron-circle-up-alt')}}"></use>
                                        </svg>
                                    </a>
                                </td>
                                {{--<td>{{$directed->topic_assign_language_count}}</td>--}}
                                {{--<td>
                                    <div class="row row-cols-4">
                                        @foreach($directed->topicAssignLanguage as $lanItem)
                                            <div class="col-xl-auto">
                                                <div class="small">{{isset($lanItem->language->name)? $lanItem->language->name: ''}}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>--}}
                            @php
                                $char=1;
                                $albha = 'a'; $char < 'z';
                            @endphp
                            @foreach($directed->directeds as $k=>$item)
                                <tr class="collapse" id="collapseDirected{{$key}}">
                                    <td>-</td>
                                    <td>-</td>
                                    <td><span>{{ $albha++}})</span> {{$item->sentence}}</td>
                                    <td>{{$item->english}}</td>
                                    <td class="text-center">
                                        <div class="d-grid gap-2 d-md-flex justify-content-center">
                                            <a class="btn btn-info btn-sm" href="{{route('admin.directeds.show', $item->id)}}">
                                                <i class="text-white far fa-eye"></i>
                                            </a>
                                            <button class="btn btn-purple btn-sm editbtn" type="button" value="{{$item->id}}" data-coreui-toggle="modal" data-coreui-target="#directedEditForm">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="{{ route('admin.directeds.destroy', $item->id) }}" method="post">
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
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $directeds->links('vendor.pagination.custom') }}
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

        @if (count($errors) > 0)

           {{-- $( document ).ready(function() {
                $('#directedForm').modal('show');
            });--}}
            setTimeout(function() {
                $('.notification-object').css('display', 'none');
            }, 5000);
         @endif

        $( document ).ready(function() {
            var value =$("#search").val();
            var x = document.getElementById("remove");
            if(value){
                x.style.display = "block";
                $("tr").addClass("show");
            }
        });

        document.getElementById("search").addEventListener("input", removeIcon);
        function removeIcon(){
            var x = document.getElementById("remove");
            if (x.style.display === "none") {
                x.style.display = "block";
            }
        }


        function clickItem($id) {
            var y =document.getElementById("show"+$id);
            if (y.style.display === "none") {
                $("#hide"+$id).hide();
                $("#show"+$id).show();
            } else {
                $("#hide"+$id).show();
                $("#show"+$id).hide();
            }
        }


        // add more input field
        $(document).ready(function () {
            var maxField = 10; // Total 5 product fields we add
            var addButton = $('.add_button'); // Add more button selector
            var wrapper = $('.field_wrapper'); // Input fields wrapper
            var fieldHTML = `<div class="row">
                        <div class="col-md-11">
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label" for="sentence">{{__('messages.বাক্য')}}</label>
                                <div class="col-sm-9">
                                    <input class="form-control" id="sentence" name="sentence[]" type="text" placeholder="{{__('messages.বাংলা বাক্য')}}"  required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label" for="english">{{__('messages.ইংরেজী')}}</label>
                                <div class="col-sm-9">
                                    <input class="form-control" id="english" name="english[]" type="text"  placeholder="{{__('messages.ইংরেজী')}}" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1 mt-4 remove_button">
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
                var directedID = $(this).val();
                // alert(directedID);

                $('#directedEditForm').modal('show');

                $.ajax({
                    type: "GET",
                    url: "/admin/directeds/"+directedID+"/edit",
                    dataType: 'json',
                    success:function (response){
                        console.log(response)
                        $('#topic_id').val(response.topic[0].id);
                        $('#name').val(response.topic[0].name);
                        $('#sentence').val(response.directed.sentence);
                        $('#english').val(response.directed.english);
                        $('#directedID').val(directedID);

                    }
                })
            })
        })
    </script>
@endsection

