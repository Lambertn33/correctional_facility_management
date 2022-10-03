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
                            <li class="breadcrumb-item active" aria-current="page">Approved Appointments <b class="text-success">({{$approvedAppointments->count()}})</b></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                @if (Session::has('success'))
                    <div class="alert alert-success border-0 bg-success alert-dismissible fade show">
                        <div class="text-white">{{Session::get('success')}}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="table-responsive table-striped">
                    <table class="table mb-0 align-middle" id="table-responsive">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Visitor Names</th>
                                <th>Inmate Names</th>
                                <th>Inmate Code</th>
                                <th>Visit Date</th>
                                <th>Payment Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $counter=1?>
                            @foreach ($approvedAppointments as $item)
                                <tr>
                                    <td>{{$counter}}</td>
                                    <?php $counter++ ?>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="recent-product-img">
                                                <i class="bx bx-user"></i>
                                            </div>
                                            <div class="ms-2">
                                                <h6 class="mb-1 font-14">{{$item->names}}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{$item->inmate->names}}</td>
                                    <td>{{$item->inmate->inmate_code}}</td>
                                    <td>{{$item->date}}</td>
                                    <td>
                                        @if ($item->payment)
                                            <div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3"><i class="bx bxs-circle me-1"></i>Paid</div>
                                        @else
                                            <div class="badge rounded-pill text-warning bg-light-warning p-2 text-uppercase px-3"><i class="bx bxs-circle align-middle me-1"></i>Unpaid</div>
                                        @endif
                                    </td>
                                    <td>
                                      <a href="#" class="text-danger"  data-bs-toggle="modal" data-bs-target=".bs-{{$item->id}}-details"><b>View More</b></a>
                                      <div class="modal fade bs-{{$item->id}}-details" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Appointment Full Details</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="col">

                                                        <hr/>
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <h5>Appointment Information</h5>
                                                                <ul class="list-group">
                                                                    <li class="list-group-item">Visitor Names: <b>{{$item->names}}</b></li>
                                                                    <li class="list-group-item">Visitor Telephone: <b>{{$item->telephone}}</b></li>
                                                                    <li class="list-group-item">Visitor National ID: <b>{{$item->national_id}}</b></li>
                                                                    <li class="list-group-item">Inmate Names: <b>{{$item->inmate->names}}</b></li>
                                                                    <li class="list-group-item">Inmate National ID: <b>{{$item->inmate->national_id}}</b></li>
                                                                    <li class="list-group-item">Requested Date: <b>{{$item->date}}</b></li>
                                                                </ul>
                                                                <hr>
                                                                <h5>Payment Information</h5>
                                                               <ul class="list-group">
                                                                   <li class="list-group-item">Appointment Plan: <b>{{$item->tariff->amount}} RWFS -{{$item->tariff->time}} minutes</b></li>
                                                                   <li class="list-group-item">Payment Status :
                                                                    <!--TODO CHECK PAYMENT STATUS-->
                                                                        @if ($item->payment)
                                                                           <div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3"><i class="bx bxs-circle me-1"></i>Paid</div>
                                                                        @else
                                                                            <div class="badge rounded-pill text-warning bg-light-warning p-2 text-uppercase px-3"><i class="bx bxs-circle align-middle me-1"></i>Unpaid</div>
                                                                        @endif
                                                                   </li>
                                                               </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready( function () {
        $('#table-responsive').DataTable();
    });
</script>