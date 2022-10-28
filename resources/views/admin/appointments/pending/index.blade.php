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
                            <li class="breadcrumb-item active" aria-current="page">{{__('Pending Appointments')}} <b class="text-info">({{$pendingAppointments->count()}})</b></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                @if (Session::has('success'))
                    <div class="alert alert-success border-0 bg-success alert-dismissible fade show">
                        <div class="text-white">{{__(Session::get('success'))}}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (Session::has('error'))
                    <div class="alert alert-success border-0 bg-success alert-dismissible fade show">
                        <div class="text-white">{{__(Session::get('error'))}}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="table-responsive align-middle">
                    <table class="table mb-0" id="table-responsive">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>{{__('Names')}}</th>
                                <th>{{__('National ID')}}</th>
                                <th>{{__('Inmate Names')}}</th>
                                <th>{{__('Inmate National ID')}}</th>
                                <th>{{__('Action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $counter=1?>
                            @foreach ($pendingAppointments as $item)
                                <tr>
                                    <td>{{$counter}}</td>
                                    <?php $counter++ ?>
                                    <td>{{$item->names}}</td>
                                    <td>{{$item->national_id}}</td>
                                    <td>{{$item->inmate->names}}</td>
                                    <td>{{$item->inmate->national_id}}</td>
                                    <td>
                                      <a href="{{route('getSinglePendingAppointment', $item->id)}}" class="text-danger"><b>{{__('View More')}}</b></a>
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