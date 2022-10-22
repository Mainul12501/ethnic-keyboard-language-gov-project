@extends('layouts.app')

@section('content')
    <div class="sa-error">
        <div class="sa-error__background-text">Oops! Error 404</div>
        <div class="sa-error__content">
            <h1 class="sa-error__title">Page Not Found</h1>
            <p class="sa-error__text">
                We can&#x27;t seem to find the page you&#x27;re looking for.
                <br />
            </p>
            <p class="sa-error__text">Go to the home page to start over.</p>
            <a class="btn btn-success btn-lg" href="{{route('admin.dashboard')}}">Go To Home Page</a>
        </div>
    </div>
@endsection
