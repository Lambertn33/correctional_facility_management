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
                            <li class="breadcrumb-item active" aria-current="page">Inmates <b class="text-success">({{$currentPrisonInmates->count()}})</b></li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <a href="{{route('createNewPrisonInmate')}}" class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>Add New Inmate</a>
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
                                <th>Inmate National ID</th>
                                <th>Inmate Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $counter=1?>
                            @foreach ($currentPrisonInmates as $item)
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
                                    <td>{{$item->inmate_code}}</td>
                                    <td>{{$item->national_id}}</td>
                                    <td>
                                        @if ($item->status == \App\Models\Inmate::ACTIVE)
                                            <div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3"><i class="bx bxs-circle me-1"></i>Active</div>
                                        @else
                                            <div class="badge rounded-pill text-warning bg-light-warning p-2 text-uppercase px-3"><i class="bx bxs-circle align-middle me-1"></i>Inactive</div>
                                        @endif
                                    </td>
                                    <td class="">
                                      <a href="#" class="text-danger"  data-bs-toggle="modal" data-bs-target=".bs-{{$item->id}}-details"><b>View More</b></a>
                                      <a href="{{route('editPrisonInmate', $item->id)}}" class="text-info" style="margin-left: 0.25rem"><b>Edit</b></a>
                                    </td>
                                    <div class="modal fade bs-{{$item->id}}-details" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                      <div class="modal-dialog">
                                          <div class="modal-content">
                                              <div class="modal-header">
                                                  <h5 class="modal-title" id="exampleModalLabel">Inmate More Details</h5>
                                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                              </div>
                                              <div class="modal-body">
                                                  <div class="col">

                                                      <hr/>
                                                      <div class="card">
                                                          <div class="card-body">
                                                              <ul class="list-group">
                                                                  <li class="list-group-item">Reason: <b>{{$item->reason}}</b></li>
                                                                  <li class="list-group-item">In Date: <b>{{$item->in_date}}</b></li>
                                                              </ul>
                                                          </div>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
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