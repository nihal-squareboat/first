@extends('layouts.app')
@if(Auth::user()->usertype==null)
    @section('content')
    <script>window.location = "/nova";</script>
    @endsection
@else
    @include(Auth::user()->usertype)
    @section('content')
            @yield(Auth::user()->usertype)
    @endsection
@endif