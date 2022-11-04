<?php

namespace App\Console\Commands;

use App\Http\Services\Common\Payment\RequestPayment;
use App\Http\Services\Common\SendMessage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Payment;

class OnlinePaymentStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to check callback payment status';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            DB::beginTransaction();
            $allPendingPayments = Payment::with('appointment')->where('status', Payment::PENDING)->get();
            if (count($allPendingPayments) > 0) {
                foreach ($allPendingPayments as $pendingPayment) {
                    $transactionId = $pendingPayment->transaction_id;
                    $requestTransactionId = $pendingPayment->request_transaction_id;
                    $onlineStatusResponse = (new RequestPayment)->getPaymentStatus($requestTransactionId, $transactionId);

                    if (strtoupper($onlineStatusResponse['status']) != Payment::PENDING) {
                        $appointment = $pendingPayment->appointment;
                        $names = $appointment->names;
                        $telephone = $appointment->telephone;
                         // if user has paid, send success message and change payment status
                        if ((strtoupper($onlineStatusResponse['status']) == Payment::SUCCESSFULL)) {
                            $message = 'Dear '.$names.' Your payment has been received successully... you will be informed the next steps very soon....';
                            $pendingPayment->update([
                                'status' => strtoupper($onlineStatusResponse['status'])
                            ]);
                            (new SendMessage)->sendMessage($telephone, $message);
                        } else {
                            // if user doesn't pay and payment fails, send failed message and delete pending appointment and payment
                            $message = 'Dear '.$names.' Your payment has failed.... please re-request your appointment';
                            $pendingPayment->delete();
                            $pendingPayment->appointment->delete();
                            (new SendMessage)->sendMessage($telephone, $message);
                        }
                    }
                }
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
}
