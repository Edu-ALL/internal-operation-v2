<?php

namespace App\Models;

use App\Models\pivot\ClientAcceptance;
use App\Models\pivot\ClientLeadTracking;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class UserClient extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'tbl_client';
    protected $appends = ['lead_source'];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'st_id',
        'first_name',
        'last_name',
        'mail',
        'phone',
        'phone_desc',
        'dob',
        'insta',
        'state',
        'city',
        'postal_code',
        'address',
        'sch_id',
        'st_grade',
        'lead_id',
        'eduf_id',
        'partner_id',
        'event_id',
        'st_levelinterest',
        'graduation_year',
        'gap_year',
        'st_abryear',
        // 'st_abrcountry',
        'st_statusact',
        'st_note',
        'st_statuscli',
        // 'st_prospect_status',
        'st_password',
        'preferred_program',
        'is_funding',
        'register_as',
        'created_at',
        'updated_at',
    ];

    # attributes
    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => isset($this->last_name) ? $this->first_name . ' ' . $this->last_name : $this->first_name,
        );
    }

    protected function leadSource(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->lead != NULL ? $this->getLeadSource($this->lead->main_lead) : NULL
        );
    }

    protected function clientProgs(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->clientProgram != NULL ? $this->clientProgram : NULL
        );
    }

    protected function graduationYearReal(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->getGraduationYearFromView($this->id)
        );
    }

    protected function participated(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->getParticipatedFromView($this->id)
        );
    }

    public function scopeWhereRoleName(Builder $query, $role)
    {
        $query->whereHas('roles', function ($q) use ($role) {
            $q->when(gettype($role) == 'integer', function ($q2) use ($role) {
                $q2->where('id', $role);
            }, function ($q2) use ($role) {
                $q2->where('role_name', $role);
            });
        });
    }

    public function scopeWithAndWhereHas($query, $relation, $constraint)
    {
        return $query->whereHas($relation, $constraint)
            ->with([$relation => $constraint]);
    }

    public function getLeadSource($parameter)
    {
        switch ($parameter) {
            case "All-In Event":
                if ($this->event != NULL)
                    return "ALL-In Event - " . $this->event->event_title;
                else
                    return "ALL-In Event";
                break;

            case "External Edufair":
                if ($this->external_edufair->title != NULL)
                    return "External Edufair - " . $this->external_edufair->title;
                else
                    return "External Edufair - " . $this->external_edufair->organizerName;
                break;

            case "KOL":
                return "KOL - " . $this->lead->sub_lead;
                break;

            default:
                return $this->lead->main_lead;
        }
    }

    public function getGraduationYearFromView($id)
    {
        return DB::table('client')->find($id)->graduation_year_real;
    }

    public function getParticipatedFromView($id)
    {
        return DB::table('client')->find($id)->participated;
    }


    # relation
    public function additionalInfo()
    {
        return $this->hasMany(UserClientAdditionalInfo::class, 'client_id', 'id');
    }

    public function parents()
    {
        return $this->belongsToMany(UserClient::class, 'tbl_client_relation', 'child_id', 'parent_id')->withTimestamps();
    }

    public function childrens()
    {
        return $this->belongsToMany(UserClient::class, 'tbl_client_relation', 'parent_id', 'child_id')->withTimestamps();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'tbl_client_roles', 'client_id', 'role_id')->withTimestamps();
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'sch_id', 'sch_id');
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class, 'lead_id', 'lead_id');
    }

    public function external_edufair()
    {
        return $this->belongsTo(EdufLead::class, 'eduf_id', 'id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'event_id');
    }

    public function destinationCountries()
    {
        return $this->belongsToMany(Tag::class, 'tbl_client_abrcountry', 'client_id', 'tag_id')->withTimestamps();
    }

    public function interestUniversities()
    {
        return $this->belongsToMany(University::class, 'tbl_dreams_uni', 'client_id', 'univ_id')->withTimestamps();
    }

    public function interestPrograms()
    {
        return $this->belongsToMany(Program::class, 'tbl_interest_prog', 'client_id', 'prog_id')->withTimestamps();
    }

    public function interestMajor()
    {
        return $this->belongsToMany(Major::class, 'tbl_dreams_major', 'client_id', 'major_id')->withTimestamps();
    }

    public function clientProgram()
    {
        return $this->hasMany(ClientProgram::class, 'client_id', 'id');
    }

    public function clientEvent()
    {
        return $this->hasMany(ClientEvent::class, 'client_id', 'id');
    }

    public function viewClientProgram()
    {
        return $this->hasMany(ViewClientProgram::class, 'client_id', 'id');
    }

    public function clientMentor()
    {
        return $this->hasManyThrough(User::class, ClientProgram::class, 'client_id', 'users.id', 'id', 'clientprog_id');
    }

    public function leadStatus()
    {
        return $this->belongsToMany(InitialProgram::class, 'tbl_client_lead_tracking', 'client_id', 'initialprogram_id')->using(ClientLeadTracking::class)->withTimestamps();
    }

    public function universityAcceptance()
    {
        return $this->belongsToMany(University::class, 'tbl_client_acceptance', 'client_id', 'univ_id')->using(ClientAcceptance::class)->withPivot('id', 'status', 'major_id')->withTimestamps();
    }
}
