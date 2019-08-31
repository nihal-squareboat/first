@section('student')
    {{-- Student Section Start --}}
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Student Dashboard</div>
                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            You are logged in as student!
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {{-- Student Section End --}}
@endsection