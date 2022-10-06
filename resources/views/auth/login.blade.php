@extends('visitors.layouts')

@section('content')
<div class="card shadow-none">
    <div class="card-body">
        <div class="border p-4 rounded">
            <div class="text-center mb-4">
                <h4 class="">Welcome To Inmates Appointment Request</h4>
                <p class="mb-0">Login to your account</p>
            </div>
            <div class="form-body">
                @if (Session::has('error'))
                    <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show">
                        <div class="text-white"><b>{{ Session::get('error') }}</b></div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <form class="row g-4" action="{{route('authenticate')}}" method="POST">
                    @csrf

                    <div class="col-12">
                        <label for="inputUsername" class="form-label">Enter email/Telephone</label>
                        <input type="text" name="username" required value="{{old('username')}}" class="form-control" id="inputUsername" placeholder="Enter Telephone or Email">
                    </div>

                    <div class="col-12">
                        <label for="inputChoosePassword" class="form-label">Enter Password</label>
                        <div class="input-group" id="show_hide_password">
                            <input type="password" required name="password" class="form-control border-end-0" id="inputChoosePassword" placeholder="Enter Password"> 
                        </div>
                    </div>

                    <div class="col-md-6">
                        <a href="#">Forgot Password ?</a>
                    </div>

                    <div class="col-12">
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary"><i class="bx bxs-lock-open"></i>Sign in</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection