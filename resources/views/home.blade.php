@extends('layouts.app')
@section('content')
@if(Auth::user()->usertype=='admin')
    
    <script>window.location = "/nova";</script>
    @endsection
@else
    @include(Auth::user()->usertype)
    @section('content')
            @yield(Auth::user()->usertype)
    @endsection
@endif
