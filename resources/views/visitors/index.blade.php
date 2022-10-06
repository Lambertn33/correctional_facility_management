@extends('visitors.layouts')

@section('content')
<div class="error-404 d-flex align-items-center justify-content-center">
    <div class="container">
        <div class="card py-5">
            <div class="row g-0">
                <div class="col col-xl-5">
                    <div class="card-body p-4">
                        <h6 class="font-weight-bold display-6">Inmates Appointment Request</h6>
                        <marquee direction="up" scrollamount="2">
                            <p>Establishing relationships with one's family, friends, and various service providers.</p>
                            <p>Contributing to both the emotional and physical wellness of inmates.</p>
                            <p>Increasing access to resources and counsel in both the civil and criminal judicial systems.</p>
                            <p>Making it possible for government processes to be more user-friendly, and productive.</p>
                        </marquee>
                    </div>
                </div>
                <div class="col-xl-6">
                    <video controls autoplay loop style="width: 90vh">
                        <source src="/assets/video/e-huza.mp4" type="video/mp4">
                            Your browser does not support the video tag.
                    </video>
                </div>
            </div>
        </div>
            <!--end row-->
    </div>
    </div>
@endsection