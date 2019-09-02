@section('candidate')
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
                            You are logged in as candidate!
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {{-- candidate Section End --}}
@endsection