@push("styles")
    <link href=" {{ asset('css/autoIncrementSerial.css') }} " rel="stylesheet">
    <link href=" {{ asset('css/snackbar.css') }} " rel="stylesheet">
@endpush

@section('recruiter')

    {{-- Snackbar Start --}}
        
    <div id="snackbar"><div style="text-align:right"><button type="button" id="snackbarButton" class="close" style="color: #fff">&times;</button></div>Job Added Successfully</div>

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
                            You are logged in as recruiter!<br><br>
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
                                            <td id="serial_num"></td>
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
                        <form id="editJob-{{ $job->id }}" method="POST" action="/job/{{ $job->id }}">
                        <div class="modal-body" style="word-wrap: break-word;">
                            <div id="view-{{ $job->id }}" style="display: block;">
                                <h5 id="viewTitle">Title: {{ $job->jobTitle }}</h5>
                                <h5 id="viewDescription">Description: {{ $job->jobDescription }} </h5>
                            </div>

                            <div id="form-{{ $job->id }}" style="display: none;">
                                    @csrf
                                    <div class="form-group">
                                        <label for="jobTitle">Job Title</label>
                                        <input type="text" name="jobTitle" class="form-control" id="jobTitle-{{ $job->id }}" placeholder="Job Title" value="{{ $job->jobTitle }}"autofocus required>
                                    </div>
                                    <div class="form-group">
                                        <label for="jobDescription">Job Description</label>
                                        <textarea class="form-control" name="jobDescription" id="jobDescription-{{ $job->id }}" rows="6" placeholder="Job Description" required >{{ $job->jobDescription }}</textarea>
                                    </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                                <div id="viewFooter-{{ $job->id }}" style="display: block;">
                                    <button type="button" class="btn btn-primary" onclick="edit_{{ $job->id }}()">Edit</button>
                                    <form method="POST" action="/deletejob/{{ $job->id }}">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                    <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
                                </div>
                                <div id="editFooter-{{ $job->id }}" style="display: none;">
                                    <button type="button" class="btn btn-danger" onclick="view_{{ $job->id }}()">Cancel</button>
                                    <button type="submit" class="btn btn-success">Done</button>
                                </div>
                            </div>
                        </form>
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
                                <input type="text" name="jobTitle" class="form-control" id="jobTitle" placeholder="Job Title" autofocus required>
                            </div>
                            <div class="form-group">
                                <label for="jobDescription">Job Description</label>
                                <textarea class="form-control" name="jobDescription" id="jobDescription" rows="6" placeholder="Job Description" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" onclick="eraseText()">Cancel</button>
                            <button type="submit" class="btn btn-success">Add Job</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- New Job Modal End --}}

        {{-- javaScripts Start --}}

        <script>
            function eraseText() {
                document.getElementById("jobTitle").value = "";
                document.getElementById("jobDescription").value = "";
            }

            function close() {
                document.getElementById("snackbar").className = "hide";

            }
        </script>
        <script>
            $(document).ready(function(){
                $('#snackbarButton').click(function(){
                    $('#snackbar').removeClass();
                    
                });
            });
        </script>

        @if(Session::has('success'))
            <script>
                var x = document.getElementById("snackbar");
                x.classList.add("show");
            </script>
            {{ Session::forget('success') }}
        @endif

        {{-- javaScripts End --}}

    {{-- Recruiter Section End --}}
@endsection