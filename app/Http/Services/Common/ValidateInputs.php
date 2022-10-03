<?php
    namespace App\Http\Services\Common;

use App\Models\Inmate;

    class ValidateInputs {
        
        public function validatePhoneNumber($input, $format, $digits)
        {
            return ((substr($input, 0, 4) != $format) || strlen($input) != $digits) ? false : true;
        }

        public function validateNationalIDLength($input)
        {
            return strlen($input) == 16 ? true : false;
        }

        public function validateInmateCode($input)
        {
            return Inmate::where('inmate_code', $input)->exists();
        }
        public function validateInmateNationalIDExistence($input, $prison)
        {
            return Inmate::where('national_id', $input)->where('prison_id', $prison)->exists();
        }
    }
?>