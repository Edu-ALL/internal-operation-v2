<?php

namespace App\Imports;

use App\Models\Lead;
use App\Models\UserClient;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use App\Http\Traits\StandardizePhoneNumberTrait;
use App\Models\Role;
use App\Models\School;
use Maatwebsite\Excel\Concerns\Importable;
use App\Http\Traits\CreateCustomPrimaryKeyTrait;


class TeacherImport implements ToCollection, WithHeadingRow, WithValidation
{
    /**
     * @param Collection $collection
     */

    use Importable;
    use StandardizePhoneNumberTrait;
    use CreateCustomPrimaryKeyTrait;

    public function collection(Collection $rows)
    {

        DB::beginTransaction();
        try {

            foreach ($rows as $row) {
                $teacher = null;
                $phoneNumber = $this->setPhoneNumber($row['phone_number']);

                $teacherName = $this->explodeName($row['full_name']);

                // Check existing school
                $school = School::where('sch_name', $row['school'])->get()->pluck('sch_id')->first();

                if (!isset($school)) {
                    $newSchool = $this->createSchoolIfNotExists($row['school']);
                }

                $teacherFromDB = UserClient::select('id', 'mail', 'phone')->get();
                $mapTeacher = $teacherFromDB->map(function ($item, int $key) {
                    return [
                        'id' => $item['id'],
                        'mail' => $item['mail'],
                        'phone' => $this->setPhoneNumber($item['phone'])
                    ];
                });

                $teacher = $mapTeacher->where('mail', $row['email'])
                    ->where('phone', $phoneNumber)
                    ->first();

                if (!isset($teacher)) {
                    $teacherDetails = [
                        'first_name' => $teacherName['firstname'],
                        'last_name' => isset($teacherName['lastname']) ? $teacherName['lastname'] : null,
                        'mail' => $row['email'],
                        'phone' => $phoneNumber,
                        'insta' => isset($row['instagram']) ? $row['instagram'] : null,
                        'state' => isset($row['state']) ? $row['state'] : null,
                        'city' => isset($row['city']) ? $row['city'] : null,
                        'address' => isset($row['address']) ? $row['address'] : null,
                        'sch_id' => isset($school) ? $school : $newSchool->sch_id,
                        'lead_id' => $row['lead'],
                        'st_levelinterest' => $row['level_of_interest'],
                    ];
                    $roleId = Role::whereRaw('LOWER(role_name) = (?)', ['teacher/counselor'])->first();

                    $teacher = UserClient::create($teacherDetails);
                    $teacher->roles()->attach($roleId);
                }
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Import parent failed : ' . $e->getMessage());
        }
    }

    public function prepareForValidation($data)
    {

        DB::beginTransaction();
        try {

            if ($data['lead'] == 'School' || $data['lead'] == 'Counselor') {
                $data['lead'] = 'School/Counselor';
            }
            $lead = Lead::where('main_lead', $data['lead'])->get()->pluck('lead_id')->first();

            DB::commit();
        } catch (Exception $e) {

            DB::rollBack();
            Log::error('Import parent failed : ' . $e->getMessage());
        }

        $data = [
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'instagram' => $data['instagram'],
            'state' => $data['state'],
            'city' => $data['city'],
            'address' => $data['address'],
            'school' => $data['school'],
            'lead' => isset($lead) ? $lead : $data['lead'],
            'level_of_interest' => $data['level_of_interest'],
        ];

        return $data;
    }

    public function rules(): array
    {
        return [
            '*.full_name' => ['required'],
            '*.email' => ['required', 'email', 'unique:tbl_client,mail'],
            '*.phone_number' => ['required', 'min:10', 'max:15'],
            '*.instagram' => ['nullable', 'unique:tbl_client,insta'],
            '*.state' => ['nullable'],
            '*.city' => ['nullable'],
            '*.address' => ['nullable'],
            '*.school' => ['required'],
            '*.lead' => ['required', 'exists:tbl_lead,lead_id'],
            '*.level_of_interest' => ['required', 'in:High,Medium,Low'],
        ];
    }

    private function explodeName($name)
    {

        $fullname = explode(' ', $name);
        $limit = count($fullname);

        $data = [];

        if ($limit > 1) {
            $data['lastname'] = $fullname[$limit - 1];
            unset($fullname[$limit - 1]);
            $data['firstname'] = implode(" ", $fullname);
        } else {
            $data['firstname'] = implode(" ", $fullname);
        }

        return $data;
    }

    private function createSchoolIfNotExists($sch_name)
    {
        $last_id = School::max('sch_id');
        $school_id_without_label = $this->remove_primarykey_label($last_id, 4);
        $school_id_with_label = 'SCH-' . $this->add_digit($school_id_without_label + 1, 4);

        $newSchool = School::create(['sch_id' => $school_id_with_label, 'sch_name' => $sch_name]);

        return $newSchool;
    }
}