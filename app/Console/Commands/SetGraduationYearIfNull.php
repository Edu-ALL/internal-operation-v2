<?php

namespace App\Console\Commands;

use App\Interfaces\ClientRepositoryInterface;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SetGraduationYearIfNull extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'set:graduation_year';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically set graduation year to client table if the graudation year field is null';


    private ClientRepositoryInterface $clientRepository;

    public function __construct(ClientRepositoryInterface $clientRepository)
    {
        parent::__construct();
        $this->clientRepository = $clientRepository;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $students = $this->clientRepository->getAllClientByRole('Student');
        $progressBar = $this->output->createProgressBar($students->count());
        $progressBar->start();

        DB::beginTransaction();
        try {

            foreach ($students as $student) {
                $progressBar->advance();                
                if ($student->graduation_year == NULL && $student->st_grade !== NULL) {
    
                    $student->graduation_year = $this->getGraduationYearByGrade($student->st_grade, $student->created_at);
                    $student->save();
    
                }
            }
            DB::commit();
            $progressBar->finish();

        } catch (Exception $e) {
            
            DB::rollBack();
            Log::info('Failed to set graduation year : '.$e->getMessage().' on line '.$e->getLine());
        }

        return Command::SUCCESS;
    }

    public function getGraduationYearByGrade($grade, $register_date)
    {
        $max_grade = 12;

        # calculate
        $diff = $max_grade-$grade;
        return date('Y', strtotime('+'.$diff.' years', strtotime($register_date)));
    }
}