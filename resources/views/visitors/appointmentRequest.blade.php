@extends('visitors.layouts')

<style>
    form {
        max-height: 60vh;
        overflow: auto;
    }
    ::-webkit-scrollbar {
        width: 0.4375rem;
        border: 0.0625rem solid transparent;
    }
    
    ::-webkit-scrollbar-thumb {
        background: gray; 
        border-radius: 3.125rem;
    }
</style>

@section('content')
<form action="{{route('requestAppointment')}}" method="post">
    <h4 class="text-center pb-4">Make Appointment</h4>
    @if (Session::has('error'))
        <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show">
            <div class="text-white"><b>{{ Session::get('error') }}</b></div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif(Session::has('success'))
        <div class="alert alert-success border-0 bg-success alert-dismissible fade show">
            <div class="text-white"><b>{{ Session::get('success') }}</b></div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif  
    @csrf
    <div class="border border-3 p-4 rounded">
        <div class="row g-3">
            <div class="col-md-6">
              <label for="inputNames" class="form-label">Names</label>
              <input
              type="text" 
              class="form-control" 
              required id="inputNames" 
              placeholder="Enter your names" 
              name="names"
              value="{{old('names')}}"
              >
            </div>

            <div class="col-md-6">
              <label for="inputTelephone" class="form-label">Telephone(format 250...)</label>
              <input 
              type="tel" 
              class="form-control" 
              required maxlength="12" 
              minlength="12" 
              id="inputTelephone" 
              name="telephone" 
              placeholder="Enter your telephone"
              value="{{old('telephone')}}"
              >
            </div>

            <div class="col-md-6">
                <label for="inputNationalId" class="form-label">Your National ID</label>
                <input 
                type="number"
                maxlength="16"
                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength)"
                minlength="16" 
                class="form-control" 
                required id="inputNationalId" 
                placeholder="Enter your national ID" 
                name="nationalId"
                value="{{old('nationalId')}}"
                >
              </div>

              <div class="col-md-6">
                <label for="inputNames" class="form-label">Inmate Names</label>
                <input
                type="text" 
                class="form-control" 
                required id="inputNames" 
                placeholder="Enter Inmate names" 
                name="inmate_names"
                value="{{old('inmate_names')}}"
                >
            </div>

            <div class="col-md-6">
                <label for="inputNames" class="form-label">Inmate Father Names</label>
                <input
                type="text" 
                class="form-control"  id="inputNames" 
                placeholder="Enter Inmate Father names" 
                name="father_names"
                value="{{old('father_names')}}"
                >
            </div>
            <div class="col-md-6">
                <label for="inputNames" class="form-label">Inmate Mother Names</label>
                <input
                type="text" 
                class="form-control" id="inputNames" 
                placeholder="Enter Inmate Mother names" 
                name="mother_names"
                value="{{old('mother_names')}}"
                >
            </div>

            <div class="col-md-6">
                <label for="inputPrison" class="form-label">Select Prison</label>
                <select class="form-select" id="inputPrison" required name="prison">
                  <option selected disabled value="">Select Prison</option>
                  @foreach ($allPrisons as $item)
                      <option {{$item->id === old('prison') ? 'selected': ''}} value="{{$item->id}}">{{$item->name}}</option>
                  @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label for="inputInmateId" class="form-label">Inmate National ID</label>
                <input type="number"
                 maxlength="16"
                 oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                 class="form-control" maxlength="16" minlength="16" 
                 id="inputInmateId" 
                 name="inmateNationalId" 
                 value="{{old('inmateNationalId')}}"
                 placeholder="Enter Inmate National ID">
            </div>
            <div class="col-md-6">
                <label for="" class="form-label">Visit Date</label>
                <input type="date"
                class="form-control"
                name="visitDate"
                min="<?php echo date('Y-m-d')?>"
                value="{{old('visitDate')}}"
                required
                >
            </div>
            <div class="col-md-6">
                <label for="inputPrison" class="form-label">Select Tariff</label>
                <select class="form-select" id="inputPrison" required name="tariff">
                  <option selected disabled value="">Select Tariff</option>
                  @foreach ($allTariffs as $item)
                      <option {{$item->id === old('tariff') ? 'selected': ''}} value="{{$item->id}}">{{$item->time}}mins ({{$item->amount}}FRWS)</option>
                  @endforeach
                </select>
            </div>

            <div class="col-12">
                <div class="d-grid">
                   <button type="submit" class="btn btn-primary btn-lg px-md-5 radius-30 btn-text">Request appointment</button>
                   <br>
                   <a href="{{route('getMeetingPage')}}" class="btn btn-success btn-lg px-md-5 radius-30 btn-text">Join Video</a>
                </div>
            </div>
        </div> 
    </div>
</form>
@endsection