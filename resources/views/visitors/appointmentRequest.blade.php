@extends('visitors.layouts')

<style>
    form {
        max-height: 60vh;
        overflow: auto;
    }
    form label {
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    form label span {
        color: red;
        font-weight: 500;
        font-size: 1rem;
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
    <h4 class="text-center pb-4">{{__('Make an appointment')}}</h4>
    @if (Session::has('error'))
        <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show">
            <div class="text-white"><b>{{ __(Session::get('error') )}}</b></div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif(Session::has('success'))
        <div class="alert alert-success border-0 bg-success alert-dismissible fade show">
            <div class="text-white"><b>{{ __(Session::get('success') )}}</b></div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif  
    @csrf
    <div class="border border-3 p-4 rounded">
        <div class="row g-3">
            <div class="col-md-6">
              <label for="inputNames" class="form-label">{{__('Names')}} <span>*</span></label>
              <input
              type="text" 
              class="form-control" 
              required id="inputNames"  
              name="names"
              value="{{old('names')}}"
              >
            </div>

            <div class="col-md-6">
              <label for="inputTelephone" class="form-label">{{__('Telephone(format 250...)')}} <span>*</span></label>
              <input 
              type="tel" 
              class="form-control" 
              required maxlength="12" 
              minlength="12" 
              id="inputTelephone" 
              name="telephone" 
              value="{{old('telephone')}}"
              >
            </div>

            <div class="col-md-6">
                <label for="inputNationalId" class="form-label">{{__('Your National ID')}} <span>*</span></label>
                <input 
                type="number"
                maxlength="16"
                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength)"
                minlength="16" 
                class="form-control" 
                required id="inputNationalId" 
                name="nationalId"
                value="{{old('nationalId')}}"
                >
              </div>

              <div class="col-md-6">
                <label for="inputNames" class="form-label">{{__('Inmate Names')}} <span>*</span></label>
                <input
                type="text" 
                class="form-control" 
                required id="inputNames" " 
                name="inmate_names"
                value="{{old('inmate_names')}}"
                >
            </div>

            <div class="col-md-6">
                <label for="inputNames" class="form-label">{{__('Inmate Father Names')}}</label>
                <input
                type="text" 
                class="form-control"  id="inputNames"  
                name="father_names"
                value="{{old('father_names')}}"
                >
            </div>
            <div class="col-md-6">
                <label for="inputNames" class="form-label">{{__('Inmate Mother Names')}}</label>
                <input
                type="text" 
                class="form-control" id="inputNames" 
                name="mother_names"
                value="{{old('mother_names')}}"
                >
            </div>

            <div class="col-md-6">
                <label for="inputPrison" class="form-label">{{__('Select Prison')}} <span>*</span></label>
                <select class="form-select" id="inputPrison" required name="prison">
                  <option selected disabled value="">{{__('Select Prison')}}</option>
                  @foreach ($allPrisons as $item)
                      <option {{$item->id === old('prison') ? 'selected': ''}} value="{{$item->id}}">{{$item->name}}</option>
                  @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label for="inputInmateId" class="form-label">{{__('Inmate National ID')}}</label>
                <input type="number"
                 maxlength="16"
                 oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                 class="form-control" maxlength="16" minlength="16" 
                 id="inputInmateId" 
                 name="inmateNationalId" 
                 value="{{old('inmateNationalId')}}"
            >
            </div>
            <div class="col-md-4">
                <label for="" class="form-label">{{__('Visit Date')}} <span>*</span></label>
                <input type="date"
                class="form-control"
                name="visitDate"
                id="visitDate"
                value="{{old('visitDate')}}"
                required
                >
            </div>
            <div class="col-md-4">
                <label for="" class="form-label">{{__('Visit Time')}} <span>*</span></label>
                <select class="form-select" name="visitTime" id="visitTime" required>
                    <option selected disabled value="">{{__('Select time')}}</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="inputPrison" class="form-label">{{__('Select Tariff')}} <span>*</span></label>
                <select class="form-select" id="inputPrison" required name="tariff">
                  <option selected disabled value="">{{__('Select Tariff')}}</option>
                  @foreach ($allTariffs as $item)
                      <option {{$item->id === old('tariff') ? 'selected': ''}} value="{{$item->id}}">{{$item->time}}mins ({{$item->amount}}FRWS)</option>
                  @endforeach
                </select>
            </div>

            <div class="col-12">
                <div class="d-grid">
                   <button type="submit" class="btn btn-primary btn-lg px-md-5 radius-30 btn-text">{{__('Request Appointment')}}</button>
                   <br>
                   <a href="{{route('getMeetingPage')}}" class="btn btn-success btn-lg px-md-5 radius-30 btn-text">{{__('Join Video')}}</a>
                </div>
            </div>
        </div> 
    </div>
</form>
@endsection
<script>
    window.onload = function() {
        //TODO SET MIN AND MAX TO TIME INPUT
        let allowedTimes = [
            '08:30', '08:40', '08:50', '09:00', '09:10', '09:20',
            '09:30', '09:40', '09:50', '10:00', '10:10', '10:20',
            '10:30', '10:40', '10:50', '11:00', '11:10', '11:20',
            '11:30', '11:40', '11:50', '12:00', '12:10', '12:20',
            '12:30', '12:40', '12:50', '13:00', '13:10', '13:20',
            '13:30', '13:40', '13:50', '14:00', '14:10', '14:20',
            '14:30', '14:40', '14:50', '15:00', '15:10', '15:20', 
            '15:30', '15:40', '15:50', '16:00', '16:10', '16:20',
            '16:30'
        ];

        function timeformat(date) {
            var h = date.getHours();
            var m = date.getMinutes();
            h = h % 12;
            h = h ? h : 12;
            h = h < 10 ? '0'+h: h;
            m = m < 10 ? '0'+m: m;
            var mytime= h + ':' + m + ' ';
            return mytime;
        }

        var selectInput = document.getElementById('visitTime');
        for ( let i = 0; i <= allowedTimes.length; i++ ) {
            if (allowedTimes[i] !== undefined && allowedTimes[i] > timeformat(new Date())) {
                let option = document.createElement( 'option' );
                option.value = option.text = allowedTimes[i];
                selectInput.appendChild( option );            
            }
        }

        let today = new Date();
        let minDate = new Date(today.setDate(today.getDate() + 1)).toISOString().split("T")[0];
        document.getElementById("visitDate").setAttribute('min', minDate);
    }
</script>