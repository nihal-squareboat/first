@push("styles")
    <link href=" {{ asset('css/autoIncrementSerial.css') }} " rel="stylesheet">
@endpush
@extends('layouts.app')
@section('content')

    {{-- Applicants Section Start --}}

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Job Applicants</div>
                    <div class="card-body" id="cardBody">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if ($applicants->isNotEmpty())
                            <table class="auto-index table table-hover auto-index">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Serial Number</th>
                                        <th>Candidate Name</th>
                                        <th>Candidate Email ID</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($applicants as $applicant)
                                        <tr>
                                            <td id="serial_num"></td>
                                            <td>{{ $applicant->name }}</td>
                                            <td>{{ $applicant->email }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <h5>No applicants has applied to this job.</h5>
                        @endif
                        <br><a href="{{ route('home') }}"><button type="button" class="btn btn-primary btn-lg">Back</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Applicants Section End --}}
@endsection