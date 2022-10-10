<?php

namespace App\Jobs\Admin;

use App\Http\Services\Common\SendMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class OutgoingAppointment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $inmate;
    private $visitor;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($inmate, $visitor)
    {
        $this->inmate = $inmate;
        $this->visitor = $visitor;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $message = 'Dear '. $this->visitor->names . ' you have a visit request from '. $this->inmate->names .' imprisoned in '. $this->inmate->prison->name . ' ';
        (new SendMessage)->sendMessage($this->visitor->telephone, $message);
    }
}
