@push("styles")
    <link href=" {{ asset('css/autoIncrementSerial.css') }} " rel="stylesheet">
    <link href=" {{ asset('css/snackbar.css') }} " rel="stylesheet">
@endpush

@section('candidate')

    {{-- Snackbar Start --}}
            
    <div id="snackbar"><div style="text-align:right"><button type="button" id="snackbarButton" class="close " style="color: #fff">&times;</button></div>Applied Successfully</div>
    <div id="snackbar1"><div style="text-align:right"><button type="button" id="closeSnackbarButton" class="close" style="color: #fff">&times;</button></div>Cancelled Application Successfully</div>

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
                            @if ($appliedjobs->isNotEmpty())
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
                                        @foreach ($appliedjobs as $job)
                                            <tr data-toggle="modal" data-target="#viewAppliedJob-{{ $job->id }}">
                                                <td id="serial_num"></td>
                                                <td>{{ $job->companyName }}</td>
                                                <td>{{ $job->jobTitle }}</td>
                                                <td>{{ substr($job->jobDescription , 0, 50)}} 
                                                    @if(strlen($job->jobDescription)>50)
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
                                                <td id="serial_num"></td>
                                                <td>{{ $job->companyName }}</td>
                                                <td>{{ $job->jobTitle }}</td>
                                                <td>{{ substr($job->jobDescription , 0, 50)}} 
                                                    @if(strlen($job->jobDescription)>50)
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

        @foreach ($appliedjobs as $job)
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

        <script>

            $(document).ready(function(){
                $('#snackbarButton').click(function(){
                    $('#snackbar').removeClass();
                });
            });

            $(document).ready(function(){
                $('#closeSnackbarButton').click(function(){
                    $('#snackbar1').removeClass();
                });
            });

        </script>

        @if(Session::has('applied'))
            <script>
                var x = document.getElementById("snackbar");
                x.classList.add("show");
            </script>
            {{ Session::forget('applied') }}
        @else
            @if(Session::has('cancelled'))
                <script>
                    var x = document.getElementById("snackbar1");
                    x.classList.add("show");
                </script>
                {{ Session::forget('cancelled') }}
            @endif
        @endif

    {{-- candidate Section End --}}
@endsection