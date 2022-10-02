@extends('admin.layouts')

@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 row-cols-xl-4">

            <div class="col">
                <div class="card radius-10 bg-primary">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-white">Inmates</p>
                                <h4 class="my-1 text-white">{{$activeInmates}}</h4>
                                <p class="mb-0 font-13 text-white">Total Active Inmates</p>
                            </div>
                            <div class="widgets-icons bg-light-transparent text-white ms-auto"><i class="bx bxs-user"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10 bg-info">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-white">Inmates</p>
                                <h4 class="my-1 text-white">{{$inactiveInmates}}</h4>
                                <p class="mb-0 font-13 text-white">Total Inactive Inmates</p>
                            </div>
                            <div class="widgets-icons bg-light-transparent text-white ms-auto"><i class="bx bxs-user-x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10 bg-danger">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-white">Appointments</p>
                                <h4 class="my-1 text-white">{{$currentMonthAppointments}}</h4>
                                <p class="mb-0 font-13 text-white">Total Appointments This Month</p>
                            </div>
                            <div class="widgets-icons bg-light-transparent text-white ms-auto"><i class="bx bxs-credit-card-front"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10 bg-success">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-white">Appointments</p>
                                <h4 class="my-1 text-white">{{$todayAppointments}}</h4>
                                <p class="mb-0 font-13 text-white">Total Appointments Today</p>
                            </div>
                            <div class="widgets-icons bg-light-transparent text-white ms-auto"><i class="bx bxs-credit-card-front"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end row-->
        
        <div class="row">
            <div class="col-12 col-lg-8 col-xl-8 d-flex">
                <div class="card radius-10 w-100">
					<div class="card-body">
						<div class="d-flex align-items-center">
							<div>
								<h5 class="mb-0">Latest Pending Appointments</h5>
							</div>
							<div class="font-22 ms-auto"><i class='bx bx-dots-horizontal-rounded'></i>
							</div>
						</div>
						<hr/>
						@if (count($currentPrisonAppointments) > 0)
                        <div class="table-responsive mb-4">
							<table class="table align-middle mb-0">
								<thead class="table-light">
									<tr>
										<th>Requester Names</th>
										<th>Requester Telephone</th>
										<th>Inmate Names</th>
										<th>Inmate National ID</th>
										<th>Requested Date</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($currentPrisonAppointments as $item)
                                    <tr>
										<td>{{$item->names}}</td>
										<td>{{$item->telephone}}</td>
										<td>{{$item->inmate->names}}</td>
										<td>{{$item->inmate->national_id}}</td>
										<td>{{$item->date}}</td>
									</tr>
                                    @endforeach
								</tbody>
							</table>
						</div>
                        <a href="" class="btn btn-primary">View More</a>
                        @else
                            <div class="d-flex">
                                <h5 class="text-danger">No Available Inmates</h5>
                            </div>
                        @endif
					</div>
				</div>
            </div>
            <div class="col-12 col-lg-4 col-xl-4">
              <div class="card radius-10 overflow-hidden">
                <div class="card-body">
                  <div class="mb-1">
                    <h5 class="mb-0">{{$currentPrison->name}} Chart Summary</h5>
                  <div class="chart-js-container2 mt-4">
                        {!!$inmatesChart->container()!!}
                  </div>
                </div>
              </div>
            </div>
           </div><!--end row-->
        <!--end row-->
    </div>
</div>
<script src="{{ $inmatesChart->cdn() }}"></script>
{{ $inmatesChart->script() }}
@endsection