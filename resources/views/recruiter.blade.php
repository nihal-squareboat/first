@push("styles")
    <link href=" {{ asset('css/autoIncrementSerial.css') }} " rel="stylesheet">
    <link href=" {{ asset('css/snackbar.css') }} " rel="stylesheet">
    <script src="{{ asset('js/other.js') }}" type="text/javascript"></script>
@endpush

@section('recruiter')

    {{-- Snackbar Start --}}
    

    <div id="snackbar" class="{{ Session::has('success') ? ' show' : '' }}"><div style="text-align:right"><button type="button" id="snackbarButton" class="close " style="color: #fff">&times;</button></div>Job Added Successfully</div>
    <div id="snackbar1" class="{{ Session::has('deleted') ? ' show' : '' }}"><div style="text-align:right"><button type="button" id="closeSnackbarButton" class="close" style="color: #fff">&times;</button></div>Job Deleted Successfully</div>
    @if(Session::has('success'))
        {{ Session::forget('success') }}
    @endif
    @if(Session::has('deleted'))
        {{ Session::forget('deleted') }}
    @endif

    {{-- Snackbar End --}}

    {{-- Recruiter Section Start --}}

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Recruiter Dashboard</div>
                    <div class="card-body" id="cardBody">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if ($jobs->isNotEmpty())
                            <table class="auto-index table table-hover" class="auto-index">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Serial Number</th>
                                        <th>Job Title</th>
                                        <th>Job Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jobs as $job)
                                        <tr data-toggle="modal" data-target="#viewJob-{{ $job->id }}">
                                            <td id="serial_num" style="word-break: break-all;"></td>
					    <td style="word-break: break-all;">{{ substr($job->jobTitle, 0, 30)}} 
                                                @if(strlen($job->jobTitle)>30)...@endif
                                            </td>
                                            <td style="word-break: break-all;">{{ substr($job->jobDescription , 0, 50)}} 
                                                @if(strlen($job->jobDescription)>50)...@endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    
                                </tbody>
                            </table>
                            {{ $jobs->links() }}
                        @else
                            <h5>You don't have any job. Kindly add one!</h5>
                        @endif
                        <br><button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#newJob">New Job</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- View Job Modal Start --}}

    @foreach ($jobs as $job)
        <div class="modal fade" id="viewJob-{{ $job->id }}" role="dialog" data-backdrop="static"  data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal-title-view-{{ $job->id }}" style="display: block;">View Job</h4>
                        <h4 class="modal-title" id="modal-title-edit-{{ $job->id }}" style="display: none;">Edit Job</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <form id="editJob-{{ $job->id }}" method="POST" action="{{ route('jobs.update', $job->id)}}">
                    <div class="modal-body" style="word-wrap: break-word;">
                        <div id="view-{{ $job->id }}" style="display: block;">
                            <h5 id="viewTitle">Title: {{ $job->jobTitle }}</h5>
                            <h5 id="viewDescription">Description: {{ $job->jobDescription }} </h5>
                        </div>

                        <div id="form-{{ $job->id }}" style="display: none;">
                                @csrf
                                <div class="form-group">
                                    <label for="jobTitle">Job Title</label>
                                    <input type="text" name="jobTitle" class="form-control{{ $errors->has('jobTitle') ? ' is-invalid' : '' }}" id="jobTitle-{{ $job->id }}" placeholder="Job Title" value="{{ $job->jobTitle }}" autofocus required>
                                    @if ($errors->has('jobTitle'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('jobTitle') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="jobDescription">Job Description</label>
                                    <textarea class="form-control{{ $errors->has('jobDescription') ? ' is-invalid' : '' }}" name="jobDescription" id="jobDescription-{{ $job->id }}" rows="6" placeholder="Job Description" required>{{ $job->jobDescription }}</textarea>
                                    @if ($errors->has('jobDescription'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('jobDescription') }}</strong>
                                        </span>
                                    @endif
                                </div>
                        </div>

                    </div>
                    <div class="modal-footer" id="editFooter-{{ $job->id }}" style="display: none;">
                        <button type="button" class="btn btn-danger" onclick="view_{{ $job->id }}()">Cancel</button>
                        <button type="submit" class="btn btn-success">Done</button>
                    </div>
                    </form>
                    <div class="modal-footer" id="viewFooter-{{ $job->id }}" style="display: block;">
                        <div class="form-inline" style="position: relative; margin-right:5%;">
                            <button type="button" class="btn btn-primary" onclick="edit_{{ $job->id }}()">Edit</button>
                            <div style="margin-left:3%;">
                                <form method="POST" action="{{ route('jobs.delete', $job->id)}}">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                            <div style="margin-right:3%; margin-left:3%;">
                                    <form method="POST" action="{{ route('jobs.applicants', $job->id)}}">
                                        @csrf
                                        <button type="submit" class="btn btn-info">View Applicants</button>
                                    </form>
                                </div>
                            <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function edit_{{ $job->id }}() {
                document.getElementById("form-{{ $job->id }}").style.display = "block";
                document.getElementById("view-{{ $job->id }}").style.display = "none";
                document.getElementById("modal-title-edit-{{ $job->id }}").style.display = "block";
                document.getElementById("modal-title-view-{{ $job->id }}").style.display = "none";
                document.getElementById("editFooter-{{ $job->id }}").style.display = "block";
                document.getElementById("viewFooter-{{ $job->id }}").style.display = "none";
            }
        </script>
        <script>
            function view_{{ $job->id }}() {
                document.getElementById("form-{{ $job->id }}").style.display = "none";
                document.getElementById("view-{{ $job->id }}").style.display = "block";
                document.getElementById("modal-title-edit-{{ $job->id }}").style.display = "none";
                document.getElementById("modal-title-view-{{ $job->id }}").style.display = "block";
                document.getElementById("editFooter-{{ $job->id }}").style.display = "none";
                document.getElementById("viewFooter-{{ $job->id }}").style.display = "block";
            }
        </script>
    @endforeach

    {{-- View Job Modal End --}}

    {{-- New Job Modal Start --}}
    <div class="modal fade" id="newJob" role="dialog" data-backdrop="static"  data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Job</h4>
                    <button type="button" class="close" data-dismiss="modal" onclick="eraseText()">&times;</button>
                </div>
                <form id="jobForm" method="POST" action="{{ route('job') }}">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="jobTitle">Job Title</label>
                            <input type="text" maxlength="191" name="jobTitle" class="form-control{{ $errors->has('jobTitle') ? ' is-invalid' : '' }}" id="jobTitle" placeholder="Job Title" autofocus reqiured>
                            @if ($errors->has('jobTitle'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('jobTitle') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="jobDescription">Job Description</label>
                            <textarea class="form-control{{ $errors->has('jobDescription') ? ' is-invalid' : '' }}" name="jobDescription" id="jobDescription" rows="6" placeholder="Job Description" required></textarea>
                            @if ($errors->has('jobDescription'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('jobDescription') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer" style="position: relative; float:left; margin-right:3%;">
                        <button type="button" class="btn btn-danger" data-dismiss="modal" sonclick="eraseText()">Cancel</button>
                        <button type="submit" class="btn btn-success">Add Job</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- New Job Modal End --}}
    <script>
    document.getElementById("body").onload = function(){
        @if($errors->any())
            @if(Session::has('edit'))
                $("#viewJob-{{ Session::get('edit') }}").modal('show');
                edit_{{ $job->id }}();
                $('#newJob').modal('hide');
                {{ Session::forget('edit') }}
            @else
                $('#newJob').modal('show');
            @endif
        @endif
    };
    </script>
    {{-- Recruiter Section End --}}
@endsection
