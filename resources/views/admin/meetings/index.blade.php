@extends('admin.layouts')

@section('content')

<div class="page-wrapper">
    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Meetings</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{route('getAdminDashboardOverview')}}"><i class="bx bx-home-alt"></i></a>
                        </li>
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
                            <th>Inmate Names</th>
                            <th>Inmate Code</th>
                            <th>Visitor Names</th>
                            <th>Visitor Code</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $counter=1?>
                        @foreach ($allMeetings as $item)
                            <tr>
                                <td>{{$counter}}</td>
                                <?php $counter++ ?>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="recent-product-img">
                                            <i class="bx bx-user"></i>
                                        </div>
                                        <div class="ms-2">
                                            <h6 class="mb-1 font-14">{{$item->appointment->inmate->names}}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>{{$item->meetingCodes->inmate_code}}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="recent-product-img">
                                            <i class="bx bx-user"></i>
                                        </div>
                                        <div class="ms-2">
                                            <h6 class="mb-1 font-14">{{$item->appointment->names}}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>{{$item->meetingCodes->visitor_code}}</td>
                                <td>{{$item->appointment->from}}</td>
                                <td>{{$item->appointment->to}}</td>
                                <td>
                                    <a href="#" class="btn btn-primary btn-sm">Join</a>
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