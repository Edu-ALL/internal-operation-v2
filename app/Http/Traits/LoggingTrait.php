<?php

namespace App\Http\Traits;

use App\Enums\LoggerModuleEnum;
use Illuminate\Support\Facades\Log;
use App\Enums\LogTypeEnum;
use Illuminate\Support\Carbon;

trait LoggingTrait
{

    public function logError()
    {
        
    }

    public function logAlert(LoggerModuleEnum $type, array $logDetails)
    {
        switch ($type) {

            case LoggerModuleEnum::Auth:
                $current_time = Carbon::now()->format('Y-m-d H:i:s');
                $user_email = $logDetails['user']->email;

                $message = 'Someone is trying to log into his/her account that using ('.$user_email.') at '.$current_time;
                return Log::alert($message);
                break;

        }
    }
}
