@extends('layouts.app')

@section('title', '')

@section('content')
    <div class="container-fluid px-0">
        <div class="card mb-3">
            <div class="card-header">
                <ul class="nav nav-pills card-header-pills justify-content-between">
                    <li class="nav-item">{{__('messages.স্বতঃস্ফূর্ত তালিকা')}}</li>
                    <li class="nav-item">
                        <button class="btn btn-success  btn-sm text-white" type="button" data-coreui-toggle="modal" data-coreui-target="#spontaneousForm">
                            <svg class="icon me-2">
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
                {{--<div class="d-flex justify-content-between">
                    <div  class="col-md-4">
                        <div class="row" id="filterSearch" style="display: none">
                            <form>
                                <div class="input-group d-flex">
                                    <input type="text" class="form-control" placeholder="ভাষার নাম খুঁজুন">
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary" type="submit">
                                            <svg class="icon me-2">
                                                <use xlink:href="{{asset('assets/coreui/vendors/@coreui/icons/svg/free.svg#cil-search')}}"></use>
                                            </svg>খুঁজুন
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-check form-switch form-switch-xl mb-4">
                            <label class="form-check-label" for="flexSwitchCheckDefault">Filter</label>
                            <input class="form-check-input" onclick="searchBox()" id="flexSwitchCheckDefault" type="checkbox">
                        </div>
                    </div>
                </div>--}}
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="spontaneouDataTable">
                        <thead class="table-dark">
                        <tr>
                            <th scope="col" style="width: 8rem;">{{__('messages.ক্রমিক নং')}}</th>
                            <th scope="col">{{__('messages.কীওয়ার্ড')}}</th>
                            <th scope="col" class="text-center">{{__('messages.অ্যাকশন')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($spontaneouses as $key=> $spontaneous)
                            <tr>
                                <td>{{  ++ $key }}</td>
                                <td>{{$spontaneous->word}}</td>
                                <td class="text-center">
                                    <div class="d-grid gap-2 d-md-block">
                                        <a class="btn btn-info btn-sm" href="{{route('admin.spontaneouses.show', $spontaneous->id)}}">
                                            <i class="text-white far fa-eye"></i>
                                        </a>
                                        <button class="btn btn-purple btn-sm edit-btn" type="button" value="{{$spontaneous->id}}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </div>
                                </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{--{{ $spontaneouses->links('vendor.pagination.custom') }}--}}
            </div>
        </div>
    </div>


    <!-- spontaneous edit modal-->
    @include('admin.spontaneous.edit')

    <!-- spontaneous create modal-->
    @include('admin.spontaneous.create')


@endsection

@section('language-filter-js')
    <script>
        // filter search
        function searchBox() {
            var x = document.getElementById("filterSearch");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        }
        $(document).ready(function() {
            $('#spontaneouDataTable').DataTable();
        } );

        // add more input field
        $(document).ready(function () {
            var maxField = 10; // Total 5 product fields we add
            var addButton = $('.add_button'); // Add more button selector
            var wrapper = $('.field_wrapper'); // Input fields wrapper
            var fieldHTML = `<div class="row">
                                        <div class="col-md-10">
                                            <div class="mb-3 row">
                                                <label class="col-sm-3 col-form-label" for="word">{{__('messages.কীওয়ার্ড')}}</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control" id="word" name="word[]" type="text" placeholder="{{__('messages.বাংলা')}}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 remove_button">
                                            <a href="javascript:void(0);" class="btn btn-success btn-sm rounded-circle ">
                                                <svg class="icon text-white">
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
            $(document).on('click', '.edit-btn', function (){
                var spontaneousID = $(this).val();
                // alert(spontaneousID);

                $('#spontaneousEditForm').modal('show');

                $.ajax({
                    type: "GET",
                    url: "/admin/spontaneouses/"+spontaneousID+"/edit",
                    dataType: 'json',
                    success:function (response){
                        console.log(response)
                        $('#word').val(response.spontaneous.word);
                        $('#spontaneousID').val(spontaneousID);

                    }
                })
            })
        })


        {{--@if($errors->has('word'))
        $(function() {
            $('#spontaneousForm').modal({
                show: true
            });
        });
        @endif--}}

    </script>
@endsection

