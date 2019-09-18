@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">

                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" minlength="3"  maxlength="150" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" autocomplete="off" value="" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" minlength="6"  maxlength="150" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <input type="hidden" id="jobId" name="jobId">

                        <input type="hidden" id="userType" name="userType">

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Company Name Modal Start --}}
<div class="modal fade" id="company" role="dialog" data-backdrop="static"  data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Enter company name</h4>
                    <a href = "{{ route('login') }}">
                        <button type="button" class="close">&times;</button>
                    </a>
                </div>
                <form method="POST" onsubmit="return validateForm()" action="{{ route('comapnies.add') }}">
                    @csrf
                    <div class="modal-body">
                        <select class="form-control company" id="companyNameForm" name="companyId">
                            <option value="Select">--Select Company--</option>
                            @foreach ($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->companyName }}</option>
                            @endforeach
                            <option id="other">Other</option>
                        </select>
                        <span class="invalid-feedback" id="notSelected" role="alert" style="display: none;">
                            <strong>Select a company</strong>
                        </span>
                        <div id="companyForm" class="form-group" style="display:none;">
                            <br>
                            @csrf
                            <label for="companyTitle">Company Name</label>
                            <input minlength="3"  maxlength="150" type="text" name="companyName" id="companyName" class="form-control{{ $errors->has('companyName') ? ' is-invalid' : '' }}" id="companyName" placeholder="Enter Company Name">
                            @if ($errors->has('companyName'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('companyName') }}</strong>
                                </span>
                            @endif
                            <input type="hidden" id="hiddenValue" name="hiddenValue" >
                        </div>
                        <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Done</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function(){
            $("select.company").change(function(){
                $("#companyNameForm option[value='Select']").remove();
                document.getElementById("notSelected").style.display = "none";
                var selectedCompany = $(this).children("option:selected").val();
                if( selectedCompany == 'Other'){
                    document.getElementById("companyForm").style.display = "block";
                    document.getElementById("companyName").required = true;
                    document.getElementById("hiddenValue").value = "other";
                } 
                else
                {
                    document.getElementById("companyForm").style.display = "none";
                    document.getElementById("companyName").required = false;
                    document.getElementById("hiddenValue").value = "previous";
                }
            });
        });
    </script>
    {{-- Company College Name Modal End --}}

    {{-- User Type Modal Start --}}
<div class="modal fade" id="userTy" role="dialog" data-backdrop="static"  data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Select user Type</h4>
                <a href=" {{ route('login') }} ">
                    <button type="button" class="close">&times;</button>
                </a>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card" onclick="candidate()">
                                <img class="card-img-top" src="{{ asset('image/candidate.png') }}" alt="Card image cap">
                            <div class="card-body" style="text-align:center;">
                                <h5 class="card-title">Candidate</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card" onclick="recruiter()">
                            <img class="card-img-top" src="{{ asset('image/recruiter.png') }}" alt="Card image cap">
                            <div class="card-body" style="text-align:center;">
                                <h5 class="card-title">Recruiter</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    {{-- User Type Name Modal End --}}

<script type="text/javascript">
    document.getElementById("body").onload = function(){
        @if(session()->has('recruiter'))
            document.getElementById("userType").value="recruiter";
            document.getElementById("jobId").value="{{session()->get('recruiter')}}";
            $('#userTy').modal('hide');
        @else
        document.getElementById("userType").value="candidate";
            @if($errors->any())
                @if ($errors->has('companyName'))
                    $('#company').modal('show');
                    document.getElementById("other").selected = true;
                    document.getElementById("companyForm").style.display = "block";
                    document.getElementById("hiddenValue").value = "other";
                @else
                    $('#userTy').modal('hide');
                @endif
            @else
                $('#userTy').modal('show');
            @endif
        @endif
        
    };

    function validateForm() {
        var selectedCompany = $('#companyNameForm').children("option:selected").val();
        if (selectedCompany == "Select") {
            document.getElementById("notSelected").style.display = "block";
            return false;
        }
        
    }

    function recruiter() {
        $('#userTy').modal('hide');
        $('#company').modal('show');
    };

    function candidate() {
        $('#userTy').modal('hide');
        document.getElementById("userType").value="candidate";
        document.getElementById("jobId").value="-1";
    };
</script>

@endsection
