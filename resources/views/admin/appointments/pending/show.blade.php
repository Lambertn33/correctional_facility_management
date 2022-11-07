@extends('admin.layouts')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">{{__('Appointments')}}</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('getAdminDashboardOverview')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page"><a href="{{route('getPendingAppointments')}}">{{__('Pending Appointments')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{__('Full details')}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="container">
                <div class="main-body">
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="card">
                                <div class="card-header">
                                    <h5><b>{{__('Appointment information')}}</b></h5>
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
                                            <h6 class="mb-0">{{__('Visitor Names')}}</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" class="form-control" disabled value="{{$pendingAppointment->names}}" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">{{__('National ID')}}</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" class="form-control" disabled value="{{$pendingAppointment->national_id}}" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">{{__('Telephone')}}</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" class="form-control" disabled value="{{$pendingAppointment->telephone}}" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">{{__('Inmate Names')}}</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" class="form-control" disabled value="{{$pendingAppointment->inmate->names}}" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">{{__('Inmate National ID')}}</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" class="form-control" disabled value="{{$pendingAppointment->inmate->national_id}}" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">{{__('Visit Date')}}</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="date" class="form-control" disabled value="{{date('Y-m-d', strtotime($pendingAppointment->date))}}" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">{{__('From')}}</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" class="form-control" disabled value="{{date('h:i:s', strtotime($pendingAppointment->from))}}" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">{{__('To')}}</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" class="form-control" disabled value="{{date('h:i:s', strtotime($pendingAppointment->to))}}" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">{{__('Requested on')}}</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="date" class="form-control" disabled value="{{date('Y-m-d', strtotime($pendingAppointment->created_at))}}" />
                                        </div>
                                    </div>
                                    @if (strtoupper($pendingAppointment->payment->status) == \App\Models\Payment::SUCCESSFULL)
                                        <div class="row">
                                            <div class="col-sm-3"></div>
                                            <div class="col-sm-9 text-secondary">
                                                <a href="#" class="btn btn-success" onclick="document.getElementById('{{$pendingAppointment}}-approve').submit();">{{__('Approve Appointment')}}</a>
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-reject">{{__('Reject Appointment')}}</button>

                                                <form action="{{route('approveSinglePendingAppointment', $pendingAppointment->id)}}" method="post" id="{{$pendingAppointment}}-approve" class="d-none">
                                                    <input type="hidden" name="_method" value="PUT">
                                                    @csrf
                                                </form>
                    
                                                <div class="modal fade" id="modal-reject" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <form action="{{route('rejectSinglePendingAppointment', $pendingAppointment->id)}}" method="POST">
                                                            @csrf
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">{{$pendingAppointment->names}}</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="_method" value="PUT">
                                                                    <div class="col-12">
                                                                        <label for="rejectionMessage" class="form-label"><b>{{__('Let the visitor knows why you rejected the appointment in not more than 50 words')}}</b>:</label>
                                                                        <textarea maxlength="50" name="rejectionMessage" required id="rejectionMessage" cols="20" rows="5" class="form-control"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-primary">{{__('Reject Appointment')}}</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="card">
                                <div class="card-header">
                                    <h5><b>{{__('Payment Information')}}</b></h5>
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
                                            <h6 class="mb-0">{{__('Amount')}}</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" class="form-control" disabled value="{{$pendingAppointment->tariff->amount}} FRWS" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">{{__('Duration')}}</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" class="form-control" disabled value="{{$pendingAppointment->tariff->time}} minutes" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">{{__('Payment Status')}}</h6>
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