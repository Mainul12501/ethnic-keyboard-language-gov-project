<!DOCTYPE html>
<html lang="en">
<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title></title>
    <meta name="theme-color" content="#ffffff">
    <!-- Vendors styles-->
    <link rel="stylesheet" href="{{asset('assets/coreui/css/vendors/simplebar.css')}}">
    <!-- Main styles for this application-->
    <link href="{{asset('assets/coreui/css/style.css')}}" rel="stylesheet">
    <!-- We use those styles to show code examples, you should remove them in your application.-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.23.0/themes/prism.css">
    <link href="{{asset('assets/coreui/css/examples.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>
</head>
  <body>
<div class="bg-light min-vh-100 d-flex flex-row align-items-center">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/@coreui/coreui@4.1.0/dist/js/coreui.bundle.min.js"></script>
<!-- We use those scripts to show code examples, you should remove them in your application.-->
<script src="https://cdn.jsdelivr.net/npm/prismjs@1.24.1/prism.js"></script>
<script src="https://cdn.jsdelivr.net/npm/prismjs@1.24.1/plugins/autoloader/prism-autoloader.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/prismjs@1.24.1/plugins/unescaped-markup/prism-unescaped-markup.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/prismjs@1.24.1/plugins/normalize-whitespace/prism-normalize-whitespace.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="{{asset('assets/coreui/js/chart.min.js')}}"></script>
<script src="{{asset('assets/coreui/js/coreui-chartjs.js')}}"></script>
<script src="{{asset('assets/coreui/js/coreui-utils.js')}}"></script>
<script src="{{asset('assets/coreui/js/charts.js')}}"></script>
<script src="{{asset('assets/coreui/js/main.js')}}"></script>

<script>
</script>
@yield('show-hide-js')
    <script>
        @if(Session::has('success'))
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            }
        toastr.success("{{ Session::get('success') }}");
        @endif
    </script>
</body>
</html>
