<?php 
 namespace App\Http\Services\Common\Payment;
 use Illuminate\Support\Facades\Http;

 class RequestPayment {

    private $timestamp = 20161231115242;

    public function generatePaymentPassword() {
        $username = env('MOMO_USERNAME');
        $partnerPassword = env('MOMO_PARTNER_PASSWORD');
        $account = env('MOMO_ACCOUNT_ID');
        $timestamp = $this->timestamp;
        $password = $username.$account.$partnerPassword.$timestamp;
        return hash('sha256', $password);
    }
    
    public function requestPayment($telephone, $amount) {
        $requestTransactionId = substr(md5(mt_rand()), 0, 50); 
        $data = [
            'username' => env('MOMO_USERNAME'),
            'amount' => $amount,
            'timestamp' => $this->timestamp,
            'mobilephone' => $telephone,
            'requesttransactionid' => $requestTransactionId,
            'password' => $this->generatePaymentPassword()
        ];
        $paymentRequest =  Http::acceptJson()->post(''.env('MOMO_APP_URL').'/requestpayment'.'/', $data); 
        return json_decode($paymentRequest, TRUE);  
    }


    public function getPaymentStatus($requestTransactionId, $transactionId) {
        return $requestTransactionId;
    }
}

?>