<?php

namespace App\Services;

use App\Interfaces\ClientRepositoryInterface;
use App\Interfaces\InitialProgramRepositoryInterface;
use App\Interfaces\LeadRepositoryInterface;
use App\Interfaces\ReasonRepositoryInterface;
use App\Interfaces\SchoolRepositoryInterface;

class ClientStudentService 
{
    protected ReasonRepositoryInterface $reasonRepository;
    protected SchoolRepositoryInterface $schoolRepository;
    protected ClientRepositoryInterface $clientRepository;
    protected LeadRepositoryInterface $leadRepository;
    protected InitialProgramRepositoryInterface $initialProgramRepository;

    public function __construct(
        ReasonRepositoryInterface $reasonRepository,
        SchoolRepositoryInterface $schoolRepository,
        ClientRepositoryInterface $clientRepository,
        LeadRepositoryInterface $leadRepository,
        InitialProgramRepositoryInterface $initialProgramRepository
        )
    {
        $this->reasonRepository = $reasonRepository;
        $this->schoolRepository = $schoolRepository;
        $this->clientRepository = $clientRepository;
        $this->leadRepository = $leadRepository;
        $this->initialProgramRepository = $initialProgramRepository;
    }

    public function getClientStudent()
    {
        $reasons = $this->reasonRepository->getReasonByType('Hot Lead');

        # for advance filter purpose
        $schools = $this->schoolRepository->getAllSchools();
        $parents = $this->clientRepository->getAllClientByRole('Parent');
        $max_graduation_year = $this->clientRepository->getMaxGraduationYearFromClient();
        $main_leads = $this->leadRepository->getAllMainLead();
        $main_leads = $main_leads->map(function ($item) {
            return [
                'main_lead' => $item->main_lead
            ];
        });
        $sub_leads = $this->leadRepository->getAllKOLlead();
        $sub_leads = $sub_leads->map(function ($item) {
            return [
                'main_lead' => $item->sub_lead
            ];
        });
        $leads = $main_leads->merge($sub_leads);
        $initial_programs = $this->initialProgramRepository->getAllInitProg();

        return [
            'reasons' => $reasons,
            'advanced_filter' => [
                'schools' => $schools,
                'parents' => $parents,
                'leads' => $leads,
                'max_graduation_year' => $max_graduation_year,
                'initial_programs' => $initial_programs
            ]
        ];
    }
}