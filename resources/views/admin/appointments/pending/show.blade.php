@extends('admin.layouts')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Appointments</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('getAdminDashboardOverview')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page"><a href="{{route('getPendingAppointments')}}">Pending Appointments</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Appointment Details</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="container">
                <div class="main-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header">
                                    <h5><b>Appointment Information</b></h5>
                                </div>
                                <div class="card-body">
                                    @if (Session::has('error'))
                                        <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show">
                                            <div class="text-white">{{Session::get('error')}}</div>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    @endif
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Visitor Names</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" class="form-control" disabled value="{{$pendingAppointment->names}}" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Visitor National ID</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" class="form-control" disabled value="{{$pendingAppointment->national_id}}" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Visitor Telephone</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" class="form-control" disabled value="{{$pendingAppointment->telephone}}" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Inmate Names</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" class="form-control" disabled value="{{$pendingAppointment->inmate->names}}" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Inmate National ID</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" class="form-control" disabled value="{{$pendingAppointment->inmate->national_id}}" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Visit Date</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="date" class="form-control" disabled value="{{date('Y-m-d', strtotime($pendingAppointment->date))}}" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">From</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" class="form-control" disabled value="{{date('h:i:s', strtotime($pendingAppointment->from))}}" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">To</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" class="form-control" disabled value="{{date('h:i:s', strtotime($pendingAppointment->to))}}" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Requested on</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="date" class="form-control" disabled value="{{date('Y-m-d', strtotime($pendingAppointment->created_at))}}" />
                                        </div>
                                    </div>
                                    @if (strtoupper($pendingAppointment->payment->status) == \App\Models\Payment::SUCCESSFULL)
                                        <div class="row">
                                            <div class="col-sm-3"></div>
                                            <div class="col-sm-9 text-secondary">
                                                <a href="#" class="btn btn-success" onclick="document.getElementById('{{$pendingAppointment}}-approve').submit();">Approve Appointment</a>
                                                <a href="#" class="btn btn-danger"  onclick="document.getElementById('{{$pendingAppointment}}-reject').submit();">Reject Appointment</a>

                                                <form action="{{route('approveSinglePendingAppointment', $pendingAppointment->id)}}" method="post" id="{{$pendingAppointment}}-approve" class="d-none">
                                                    <input type="hidden" name="_method" value="PUT">
                                                    @csrf
                                                </form>
                                                <form action="{{route('rejectSinglePendingAppointment', $pendingAppointment->id)}}" method="post" id="{{$pendingAppointment}}-reject" class="d-none">
                                                    <input type="hidden" name="_method" value="PUT">
                                                    @csrf
                                                </form>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5><b>Payment Information</b></h5>
                                </div>
                                <div class="card-body">
                                    @if (Session::has('error'))
                                        <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show">
                                            <div class="text-white">{{Session::get('error')}}</div>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    @endif
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Amount</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" class="form-control" disabled value="{{$pendingAppointment->tariff->amount}} FRWS" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Duration</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" class="form-control" disabled value="{{$pendingAppointment->tariff->time}} minutes" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Payment Status</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            @if (strtoupper($pendingAppointment->payment->status) == \App\Models\Payment::PENDING)
                                                <input type="text" class="form-control warning" disabled value="{{$pendingAppointment->payment->status}}" />                                           
                                            @elseif(strtoupper($pendingAppointment->payment->status) == \App\Models\Payment::FAILED)
                                                <input type="text" class="form-control danger" disabled value="{{$pendingAppointment->payment->status}}" /> 
                                            @else
                                                <input type="text" class="form-control success" disabled value="{{$pendingAppointment->payment->status}}" /> 
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection