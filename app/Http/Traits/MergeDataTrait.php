<?php

namespace App\Http\Traits;

use App\Models\EdufLead;
use App\Models\School;
use App\Models\SchoolDetail;
use App\Models\SchoolProg;
use App\Models\UserClient;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

trait MergeDataTrait
{

    public function merge($type, $action, $arrayFrom, $to=null)
    {
        DB::beginTransaction();
        try {

            switch ($type) {
                case 'School':

                    switch ($action) {
                        case 'Merge':
                            
                            # Update school from user client
                            if(!$this->updateDataIfExist(UserClient::class, 'sch_id', $arrayFrom, $to))
                                throw new Exception('Failed update school from client');
                            
                            # Update school from eduf lead
                            if(!$this->updateDataIfExist(EdufLead::class, 'sch_id', $arrayFrom, $to))
                                throw new Exception('Failed update school from eduf lead');
        
                            # Update school from school detail
                            if(!$this->updateDataIfExist(SchoolDetail::class, 'sch_id', $arrayFrom, $to))
                                throw new Exception('Failed update school from school detail');
                            
                            # Update school from school program
                            if(!$this->updateDataIfExist(SchoolProg::class, 'sch_id', $arrayFrom, $to))
                                throw new Exception('Failed update school from school program');
        
                            # Delete duplicate school
                            if(!School::whereIn('sch_id', $arrayFrom)->delete())
                                throw new Exception('Failed delete duplicate school');
                            break;

                        case 'Delete':

                            # Update school from user client
                            if(!$this->updateDataIfExist(UserClient::class, 'sch_id', $arrayFrom, null))
                                throw new Exception('Failed update school from client');
                            
                            # Update school from eduf lead
                            if(!$this->updateDataIfExist(EdufLead::class, 'sch_id', $arrayFrom, null))
                                throw new Exception('Failed update school from eduf lead');
        
                            # Update school from school detail
                            if(!$this->updateDataIfExist(SchoolDetail::class, 'sch_id', $arrayFrom, null))
                                throw new Exception('Failed update school from school detail');
                            
                            # Update school from school program
                            if(!$this->updateDataIfExist(SchoolProg::class, 'sch_id', $arrayFrom, null))
                                throw new Exception('Failed update school from school program');
        
                            # Delete duplicate school
                            if(!School::whereIn('sch_id', $arrayFrom)->delete())
                                throw new Exception('Failed delete duplicate school');
                            break;
                    }
                    break;
            }
            
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Merge data ' . $type . ' failed : ' . $e->getMessage() . ' Line ' . $e->getLine());
        }
       
    }

    protected function updateDataIfExist($model, $field, $arrayFrom, $to)
    {
        $result = true;
        foreach ($arrayFrom as $from){ 
            $exists = $model::where($field, $from)
               ->pluck($field)->toArray();
              

            if (count($exists) > 0) {
                $result = $model::whereIn($field, $exists)
                       ->update([$field => $to]);
            }
        } 
        return $result;
        
    }

    
}
