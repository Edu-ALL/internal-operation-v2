<?php

namespace App\Imports;

use App\Http\Traits\MergeDataTrait;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;

class MergeData implements ToCollection, WithHeadingRow, WithValidation
{
    /**
     * @param Collection $collection
     */

    use Importable;
    use MergeDataTrait;

    public function collection(Collection $rows)
    {
        
        foreach ($rows as $row) {
                
            $this->merge($row['type'], $row['action'], $row['from'], $row['to']);
               
        }
    }
          
    public function prepareForValidation($data)
    {
        $arrayFrom = explode(", ", $data['from']);
        $data = [
            'type' => $data['type'],
            'action' => $data['action'],
            // 'from' => $data['from'],
            'from' => $arrayFrom,
            'to' => $data['to'],
        ];

        return $data;
    }

    public function rules(): array
    {
        return [
            '*.type' => ['required', 'in:School'],
            '*.action' => ['required', 'in:Merge,Delete'],
            // '*.from' => ['required'],
            '*.from.*' => ['required','exists:tbl_sch,sch_id'],
            '*.to' => ['required_if:action,Merge', 'exists:tbl_sch,sch_id', 'nullable'],
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.from.*.exists' => 'Data :attribute not exist.',
        ];
    }

}
