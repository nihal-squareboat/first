@extends('layouts.app')
@include(Auth::user()->usertype)
@section('content')
    @yield(Auth::user()->usertype)
@endsection
