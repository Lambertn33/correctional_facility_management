<?php
    namespace App\Http\Services\Common;

    class ValidateInputs {
        
        public function validatePhoneNumber($input, $format, $digits)
        {
            return ((substr($input, 0, 4) != $format) || strlen($input) != $digits) ? false : true;
        }
    }
?>