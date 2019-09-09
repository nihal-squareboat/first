@extends('layouts.app')
@if(Auth::user()->usertype==null)
    @section('content')
        <h2>Some error occured.</h2>
    @endsection
@else
    @include(Auth::user()->usertype)
    @section('content')
            @yield(Auth::user()->usertype)
    @endsection
@endif