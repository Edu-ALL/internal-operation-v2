<?php

namespace App\Jobs\Event\EduAll;

use App\Models\ClientEventLogMail;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ProcessEmailReminderReg implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $timeout = 600;

    protected $mailDetails;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $mailDetails)
    {
        $this->mailDetails = $mailDetails;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {

            Mail::send('mail-template.reminder.event.reminder-reg', $this->mailDetails, function ($message) {
                $message
                    ->to($this->mailDetails['email'], $this->mailDetails['recipient'])
                    ->subject($this->mailDetails['subject']);
            });
            $sent_status = 1;

        } catch (Exception $e) {
            
            $sent_status = 0;
            Log::error('Failed to send mail reminder reg: ' . $e->getMessage() .' on file ' .$e->getFile().' line '. $e->getLine());

        }

        # put store to client event log mail here

        Log::debug('Send mail reminder fullname: ' . $this->mailDetails['recipient'] . ' status: ' . $sent_status, ['fullname' => $this->mailDetails['recipient'], 'email' => $this->mailDetails['email'], 'sent_status' => $sent_status]);

    }
}