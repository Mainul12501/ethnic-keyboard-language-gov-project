<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title></title>
    <!-- Vendors styles-->
    <link rel="stylesheet" href="{{asset('assets/coreui/css/vendors/simplebar.css')}}">
    <link href="{{asset('assets/coreui/css/examples.css')}}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap4.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>
    <link href="{{asset('assets/player/jsRapAudio.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/alertify.min.css"/>
    @yield('front-css')
    <!-- We use those styles to show code examples, you should remove them in your application.-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.23.0/themes/prism.css">

    <!-- Main styles for this application-->
    <link href="{{asset('assets/coreui/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('assets/coreui/css/coreui-chartjs.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/5.1.3/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css"/>
    <style>
        .xx .list-group .list-group-item:hover {
            background-color: lightgray!important;
            cursor: pointer;
        }
        .cc {
            display: none;
        }
        #loader {
            display: none;
            position: fixed;
            top: 0px;
            left: 0px;
            right: 0px;
            bottom: 0px;
            width: 100%;
            height: 100%;
            background: rgba(249,249,249) url("{{ asset('assets/coreui/assets/img/pageLoader.gif') }}") no-repeat center center;
            z-index: 9999;
            opacity: .8;
        }
    </style>
</head>
<body>
@include('partials.sidebar')
<div class="wrapper d-flex flex-column min-vh-100 bg-light">
    @include('partials.header', [
    //   'nt_count'=>\App\Models\Notification::where('user_id', auth()->id())->latest()->get(),
    'notices'=>\App\Models\Notification::where('user_id', auth()->id())->latest()->get(),
     'unseens'=>\App\Models\Notification::where('user_id', auth()->id())->where('status', 0)->get()
      ])
    <div class="body flex-grow-1 ">
        @yield('content')
    </div>
    @include('partials.footer')
</div>
<div id='loader'></div>

<script src="https://cdn.jsdelivr.net/npm/@coreui/coreui@4.1.0/dist/js/coreui.bundle.min.js"></script>

<!-- Option 2: Separate Popper and CoreUI for Bootstrap JS -->
<!--
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/@coreui/coreui@4.1.0/dist/js/coreui.min.js" ></script>
-->
<!-- We use those scripts to show code examples, you should remove them in your application.-->
<script src="https://cdn.jsdelivr.net/npm/prismjs@1.24.1/prism.js"></script>
<script src="https://cdn.jsdelivr.net/npm/prismjs@1.24.1/plugins/autoloader/prism-autoloader.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/prismjs@1.24.1/plugins/unescaped-markup/prism-unescaped-markup.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/prismjs@1.24.1/plugins/normalize-whitespace/prism-normalize-whitespace.js"></script>
<!-- Plugins and scripts required by this view-->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>

<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.min.js"></script>

{{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
{{-- <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script> --}}
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>







<script src="{{asset('assets/coreui/js/chart.min.js')}}"></script>
<script src="{{asset('assets/coreui/js/coreui-chartjs.js')}}"></script>
<script src="{{asset('assets/coreui/js/coreui-utils.js')}}"></script>
<script src="{{asset('assets/player/jsRapAudio.js')}}"></script>
{{--<script src="{{asset('assets/coreui/js/charts.js')}}"></script>--}}
{{--<script src="{{asset('assets/coreui/js/main.js')}}"></script>--}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://unpkg.com/wavesurfer.js"></script>

<script>
    $.ajaxSetup({
        headers:
            { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });
</script>
@yield('pie-chart-js')
@yield('language-filter-js')
@yield('language-add-button-js')
@yield('staff-group-js')
@yield('group-task-assgin-js')
@yield('language-assign-js')
@yield('language-js')
@yield('show-hide-password-js')
@if(Session::has('message'))
    <script>
        toastr.success('{{ Session::get('message') }}');
    </script>
@endif

    <script>
        @if(Session::has('success'))
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true

            }
        toastr.success("{{ Session::get('success') }}");
        @endif

        @if(Session::has('error'))
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            }
        toastr.error('{{ Session::get('error') }}');
        @endif

    </script>

</body>
</html>
