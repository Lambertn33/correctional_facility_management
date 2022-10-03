@extends('admin.layouts')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Inmates</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('getAdminDashboardOverview')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page"><a href="{{route('getPrisonInmates')}}">Inmates</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create New Inmate</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-7 mx-auto">
                <h6 class="mb-0 text-uppercase">New Inmate</h6>
				<hr/>
                <div class="card border-top border-0 border-4 border-primary">
                    <div class="card-body p-5">
                        <div class="card-title d-flex align-items-center">
                            <div><i class="bx bxs-user me-1 font-22 text-primary"></i>
                            </div>
                            <h5 class="mb-0 text-primary">Add New Inmate</h5>
                        </div>
                        <hr>
                        <form class="row g-3" action="{{route('saveNewPrisonInmate')}}" method="POST">
                            @if (Session::has('error'))
                                <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show">
                                    <div class="text-white"><b>{{ Session::get('error') }}</b></div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            @csrf
                            <div class="col-md-6">
                                <label for="inputFirstName" class="form-label">Inmate Names</label>
                                <input type="text" name="names" required class="form-control" id="inputFirstName" value="{{old('names')}}">
                            </div>
                            <div class="col-md-6">
                                <label for="inputLastName" class="form-label">Inmate National ID</label>
                                <input type="number"
                                maxlength="16"
                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength)"
                                minlength="16" 
                                required 
                                value="{{old('national_id')}}"
                                class="form-control"
                                name="national_id" 
                                id="inputLastName">
                            </div>
                            <div class="col-md-6">
                                <label for="inputFirstName" class="form-label">Inmate Code</label>
                                <input type="text" name="code"  value="{{old('code')}}" required class="form-control" id="inputFirstName">
                            </div>
                            <div class="col-md-6">
                                <label for="inputLastName" class="form-label">In Date</label>
                                <input type="date" name="date"  value="{{old('date')}}" required max="<?php echo date('Y-m-d')?>" class="form-control" id="inputLastName">
                            </div>
                            <div class="col-12">
                                <label for="inputAddress" class="form-label">Reason</label>
                                <textarea required name="reason" class="form-control" id="inputAddress" placeholder="Reason..." rows="3">
                                    {{old('reason')}}
                                </textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary px-5">Save Inmate</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection