@extends('layouts.app')
    @if(Auth::user()->usertype != 'admin')
        @include(Auth::user()->usertype)
        @section('content')
                @yield(Auth::user()->usertype)
        @endsection
    @else
    <script>window.location = "/nova/dashboards/main";</script>
    @endif