<?php

namespace App\Console\Commands;

use App\Interfaces\InvoiceB2bRepositoryInterface;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendReminderInvoiceProgramToSchool extends Command
{
    private InvoiceB2bRepositoryInterface $invoiceB2bRepository;

    public function __construct(InvoiceB2bRepositoryInterface $invoiceB2bRepository)
    {
        parent::__construct();
        $this->invoiceB2bRepository = $invoiceB2bRepository;
    }
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:reminder_invoiceschool_program';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder invoice school program. To remind the school to pay the invoice.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $school_have_no_pic = [];
        $invoice_master = $this->invoiceB2bRepository->getAllDueDateInvoiceSchoolProgram(7);
        $progressBar = $this->output->createProgressBar($invoice_master->count());
        $progressBar->start();
        foreach ($invoice_master as $data) {
            
            $invoiceB2bId = $data->invb2b_id;

            $program_name = ucwords(strtolower($data->program_name));
            
            $school_name = $data->school_name;
            $school_pics = $data->sch_prog->school->detail;
            if ($school_pics->count() == 0)
            {
                # collect data parents that have no email
                $school_have_no_pic[] = [
                    'school_name' => $school_name,
                ];
                continue;
            }
            $school_pic_name = $school_pics[0]->schdetail_fullname;
            $school_pic_mail = $school_pics[0]->schdetail_email;
            
            $school_pic_phone = $school_pics[0]->schdetail_phone;


            $subject = '7 Days Left until the Payment Deadline for '.$program_name;

            $params = [
                'school_pic_name' => $school_pic_name,
                'school_pic_mail' => $school_pic_mail,
                'program_name' => $program_name,
                'due_date' => date('d/m/Y', strtotime($data->invb2b_duedate)),
                'school_name' => $school_name,
                'total_payment' => $data->invoice_totalprice_idr,
            ];

            $mail_resources = 'pages.invoice.school-program.mail.reminder-payment';

            try {
                Mail::send($mail_resources, $params, function ($message) use ($params, $subject) {
                    $message->to($params['school_pic_mail'], $params['school_pic_name'])
                        ->subject($subject);
                });
            } catch (Exception $e) {

                Log::error('Failed to send invoice reminder to '.$school_pic_mail . ' caused by : '. $e->getMessage().' | Line '.$e->getLine());
                return $this->error($e->getMessage(). ' | Line '.$e->getLine());

            }

            $this->info('Invoice reminder has been sent to '.$school_pic_mail);

            # update reminded count to 1
            $data->reminded = 1;
            $data->save();

            $progressBar->advance();
        }

        if (count($school_have_no_pic) > 0)
        {
            $params = [
                'finance_name' => env('FINANCE_NAME'),
                'school_have_no_pic' => $school_have_no_pic,
            ];

            $mail_resources = 'pages.invoice.school-program.mail.reminder-finance';
            try {

                Mail::send($mail_resources, $params, function ($message) {
                    $message->to(env('FINANCE_CC'), env('FINANCE_NAME'))
                        ->subject('There are some school that can\'t be reminded');
                });
            } catch (Exception $e) {
                Log::error('Failed to send info to finance team cause by : '. $e->getMessage().' | Line '.$e->getLine());
                return $this->error($e->getMessage(). ' | Line '.$e->getLine());
            }

        }
        $progressBar->finish();
        return Command::SUCCESS;
    }
}
