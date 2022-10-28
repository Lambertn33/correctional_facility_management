@extends('meetings.visitors.layouts')

@section('content')
<h2 class="font-weight-bold" style="text-align: center"><b>{{__('Join a meeting')}}</b></h2>
<form action="{{route('provideNationalId')}}" method="post">
    @if (Session::has('error'))
        <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show">
            <div class="text-white"><b>{{ __(Session::get('error') )}}</b></div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif  
    @csrf
    <div class="border border-3 p-4 rounded">
        <div class="row g-3">
            <div class="col-md-12">
              <label for="inputNationalID" class="form-label">{{__('Meeting Code')}}</label>
              <input 
              type="number"
              class="form-control" 
              required id="inputNationalId" 
              name="code"
              value="{{old('code')}}"
              >
            </div>
            <div class="col-md-12">
                <label for="inputType" class="form-label">{{__('Join as..')}}</label>
                <select class="form-select" id="inputType" required name="userType">
                  <option selected disabled value="">{{__('Select')}}</option>
                  <option value="VISITOR" {{old('userType') === 'VISITOR' ? 'selected' : ''}}>{{__('VISITOR')}}</option>
                  <option value="INMATE" {{old('userType') === 'INMATE' ? 'selected' : ''}}>{{__('INMATE')}}</option>
                </select>
            </div>
            <div class="col-12">
                <div class="d-grid">
                   <button type="submit" class="btn btn-primary btn-lg px-md-5 radius-30 btn-text">{{__('Proceed')}}</button>
                </div>
            </div>
        </div> 
    </div>
</form>
@endsection 