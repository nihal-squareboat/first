@push("styles")
    <link href=" {{ asset('css/autoIncrementSerial.css') }} " rel="stylesheet">
    <link href=" {{ asset('css/snackbar.css') }} " rel="stylesheet">
    <script src="{{ asset('js/other.js') }}" type="text/javascript"></script>
@endpush

@section('candidate')

    {{-- Snackbar Start --}}
            
    <div id="snackbar" class="{{ Session::has('applied') ? ' show' : '' }}"><div style="text-align:right"><button type="button" id="snackbarButton" class="close " style="color: #fff">&times;</button></div>Applied Successfully</div>
    <div id="snackbar1" class="{{ Session::has('cancelled') ? ' show' : '' }}"><div style="text-align:right"><button type="button" id="closeSnackbarButton" class="close" style="color: #fff">&times;</button></div>Cancelled Application Successfully</div>
    @if(Session::has('applied'))
        {{ Session::forget('applied') }}
    @endif
    @if(Session::has('cancelled'))
        {{ Session::forget('cancelled') }}
    @endif
    {{-- Snackbar End --}}

    {{-- candidate Section Start --}}
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Candidate Dashboard</div>
                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <h5>Applied Jobs</h5>
                            @if ($appliedJobs->isNotEmpty())
                                <table class="auto-index table table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Serial Number</th>
                                            <th>Company Name</th>
                                            <th>Job Title</th>
                                            <th>Job Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($appliedJobs as $job)
                                            <tr data-toggle="modal" data-target="#viewAppliedJob-{{ $job->id }}">
                                                <td id="serial_num" style="word-break: break-all;"></td>
                                                <td style="word-break: break-all;">{{ $job->companyName }}</td>
                                                <td style="word-break: break-all;">{{ substr($job->jobTitle , 0, 30)}} 
                                                    @if(strlen($job->jobTitle)>30)
                                                        ...
                                                    @endif</td>
                                                <td style="word-break: break-all;">{{ substr($job->jobDescription , 0, 30)}} 
                                                    @if(strlen($job->jobDescription)>30)
                                                        ...
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <h5><em> You have not applied to any job!</em></h5><br>
                            @endif
                            <hr style="border: 1px dashed black;" />
                            <h5>Available Jobs</h5>
                            @if ($jobs->isNotEmpty())
                                <table class="auto-index table table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Serial Number</th>
                                            <th>Company Name</th>
                                            <th>Job Title</th>
                                            <th>Job Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($jobs as $job)
                                            <tr data-toggle="modal" data-target="#viewJob-{{ $job->id }}">
                                                <td id="serial_num" style="word-break: break-all;"></td>
                                                <td style="word-break: break-all;">{{ $job->companyName }}</td>
                                                <td style="word-break: break-all;">{{ substr($job->jobTitle , 0, 30) }}
						    @if(strlen($job->jobTitle)>30)...@endif</td>
                                                <td style="word-break: break-all;">{{ substr($job->jobDescription , 0, 30)}} 
                                                    @if(strlen($job->jobDescription)>30)
                                                        ...
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <h5><em>No jobs available!</em></h5><br>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Applied job modal start --}}

        @foreach ($appliedJobs as $job)
        <div class="modal fade" id="viewAppliedJob-{{ $job->id }}" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-title-view-{{ $job->id }}">View Job</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body" style="word-wrap: break-word;">
                        <div id="view-{{ $job->id }}">
                            <h5 id="viewCompany">Company: {{ $job->companyName }}</h5>
                            <h5 id="viewTitle">Job Title: {{ $job->jobTitle }}</h5>
                            <h5 id="viewDescription">Description: {{ $job->jobDescription }} </h5>
                            <h5 id="viewStatus">Status: <span style="color:green;"> <strong> Applied </strong></span></h5>
                        </div>
                    </div>
                    </form>
                    <div class="modal-footer" id="viewFooter-{{ $job->id }}">
                                <form method="POST" action="{{ route('jobs.cancel', $job->id)}}">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Cancel Application</button>
                                </form>
                            
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                        
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        {{-- Applied job modal end --}}

        

        {{-- All jobs modal Start --}}
        @foreach ($jobs as $job)
        <div class="modal fade" id="viewJob-{{ $job->id }}" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-title-view-{{ $job->id }}">View Job</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body" style="word-wrap: break-word;">
                        <div id="view-{{ $job->id }}">
                            <h5 id="viewCompany">Company: {{ $job->companyName }}</h5>
                            <h5 id="viewTitle">Job Title: {{ $job->jobTitle }}</h5>
                            <h5 id="viewDescription">Description: {{ $job->jobDescription }} </h5>
                            <h5 id="viewStatus">Status: <span style="color:red;"> <strong> Not Applied </strong></span></h5>
                        </div>
                    </div>
                    </form>
                    <div class="modal-footer" id="viewFooter-{{ $job->id }}">
                                <form method="POST" action="{{ route('jobs.apply', $job->id)}}">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Apply</button>
                                </form>
                            
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                        
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        {{-- All jobs modal end --}}

    {{-- candidate Section End --}}
@endsection
