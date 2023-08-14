<?php

namespace App\Http\Controllers\Module;

use App\Http\Controllers\Controller;
use App\Http\Traits\Modules\GetClientStatusTrait;
use App\Interfaces\ClientRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class DigitalDashboardController extends Controller
{
    use GetClientStatusTrait;

    public function __construct($repositories)
    {
        $this->clientRepository = $repositories->clientRepository;
        $this->userRepository = $repositories->userRepository;
        $this->clientProgramRepository = $repositories->clientProgramRepository;
        $this->salesTargetRepository = $repositories->salesTargetRepository;
        $this->clientLeadTrackingRepository = $repositories->clientLeadTrackingRepository;
        $this->targetTrackingRepository = $repositories->targetTrackingRepository;
        $this->targetSignalRepository = $repositories->targetSignalRepository;
        $this->eventRepository = $repositories->eventRepository;
        $this->leadTargetRepository = $repositories->leadTargetRepository;
        $this->leadRepository = $repositories->leadRepository;
    }

    public function get($request)
    {

        $fullDay = Carbon::now()->daysInMonth;
        $midOfMonth = floor($fullDay / 2);
        // $alarm = new Collection();

        $today = date('Y-m-d');
        $currMonth = date('m');
        
        # List Lead Source 
        $leads = $this->leadRepository->getActiveLead();
        $dataLeadSource = $this->leadTargetRepository->getLeadSourceDigital($today);
        $dataConversionLead = $this->leadTargetRepository->getConversionLeadDigital($today);


        $response = [
            'leadsDigital' => $this->mappingDataLead($leads->where('department_id', 7), $dataLeadSource),
            'leadsAllDepart' => $this->mappingDataLead($leads, $dataConversionLead),
            'dataLeadSource' => $dataLeadSource,
            'dataConversionLead' => $dataConversionLead,
        ];

        return $response;
    }

    private function mappingDataLead($leads, $dataLead)
    {
        $data = new Collection();
        foreach ($leads as $lead) {
            $count = $dataLead->where('lead_id', $lead->lead_id)->count();

            $data->push([
                'lead_id' => $lead->lead_id,
                'lead_name' => $lead->main_lead . ($lead->sub_lead  != null ? ' - ' . $lead->sub_lead : ''),
                'count' => $count,

            ]);
        }

        return $data;
    }

    
}
