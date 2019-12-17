    @extends('layout')

    @section('content')
    <h1>Contact Information</h1>
    <p>Contacts Here</p>

    @can('home.secret')
        <p>
            <a href="{{ route('secret') }}">Go To Special Contact Page</a>
           
        </p>
    @endcan

    @endsection
