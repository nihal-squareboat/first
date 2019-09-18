@extends('layouts.app')

@if(Auth::user()->usertype=='admin')
    @section('content')
        <script>window.location = "/nova";</script>
    @endsection
@else
    @include(Auth::user()->usertype)
    @section('content')
        @if(Auth::user()->email_verified_at==null)
            <h2 style="text-align: center;">Kindly verify mail to continue</h2>
        @else
            @yield(Auth::user()->usertype)
        @endif
    @endsection
@endif
