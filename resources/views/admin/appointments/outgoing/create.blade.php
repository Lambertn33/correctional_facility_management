@extends('admin.layouts')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">{{__('Outgoing Appointments')}}</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('getAdminDashboardOverview')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{__('Add New')}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-7 mx-auto">
                <h6 class="mb-0 text-uppercase">{{__('New Appointment Request')}}</h6>
				<hr/>
                <div class="card border-top border-0 border-4 border-primary">
                    <div class="card-body p-5">
                        <hr>
                        <form class="row g-3" action="{{route('sendOutgoingAppointmentRequest')}}" method="POST">
                            @if (Session::has('error'))
                                <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show">
                                    <div class="text-white"><b>{{ __(Session::get('error')) }}</b></div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @elseif(Session::has('success'))
                                <div class="alert alert-success border-0 bg-success alert-dismissible fade show">
                                    <div class="text-white"><b>{{ __(Session::get('success')) }}</b></div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            @csrf
    
                            <div class="col-md-6">
                                <label for="inputFirstName" class="form-label">{{__('Inmate Code')}}</label>
                                <input type="text" name="code" placeholder="Enter inmate Code"  value="{{old('code')}}" required class="form-control" id="inputFirstName">
                            </div>
                            <div class="col-md-6">
                                <label for="inputFirstName" class="form-label">{{__('Visitor Names')}}</label>
                                <input type="text" name="names" placeholder="Enter Visitor Names"  value="{{old('names')}}" required class="form-control" id="inputFirstName">
                            </div>
                            <div class="col-md-6">
                                <label for="inputLastName" class="form-label">{{__('Telephone')}}</label>
                                <input 
                                type="tel" 
                                class="form-control" 
                                required maxlength="12" 
                                minlength="12" 
                                id="inputTelephone" 
                                name="telephone" 
                                placeholder="Enter visitor telephone"
                                value="{{old('telephone')}}"
                                >
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary px-5">{{__('Send')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection