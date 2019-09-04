@extends('layouts.app')
@if(Auth::user()->usertype == null)
    @include('partials/user')
@else
    @include(Auth::user()->usertype)
@endif
@section('content')
    @if(Auth::user()->usertype == null)
        @yield('partials/user')
    @else
        @yield(Auth::user()->usertype)
@endif
@endsection
