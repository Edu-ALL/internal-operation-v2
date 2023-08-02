<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientLeadTracking extends Model
{
    use HasFactory;

    protected $table = 'tbl_client_lead_tracking';
    protected $primaryKey = 'id';
    protected $appends = ['lead_status', 'program_status'];

    public $incrementing = false;

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $fillable = [
        'client_id',
        'initialprogram_id',
        'type',
        'total_result',
        'status',
        'reason_id'
    ];

    public function leadStatus(): Attribute
    {
        if ($this->type == 'Lead') {

            if($this->total_result >= 0.65){
                return Attribute::make(
                    get: fn ($value) => 'Hot',
                );
            }else if($this->total_result >= 0.35 && $this->total_result < 0.65){
                return Attribute::make(
                    get: fn ($value) => 'Warm',
                );
                
            }else if($this->total_result < 0.35){
                return Attribute::make(
                    get: fn ($value) => 'Cold',
                );
            }

        } else {
            return Attribute::make(
                get: fn ($value) => null,
            );
        }
    }

    public function programStatus(): Attribute
    {
        if ($this->type == 'Program') {

            if($this->total_result >= 0.5){
                return Attribute::make(
                    get: fn ($value) => 'Yes',
                );
            }else {
                return Attribute::make(
                    get: fn ($value) => 'No',
                );
            }

        } else {
            return Attribute::make(
                get: fn ($value) => null,
            );
        }
    }

    public function client()
    {
        return $this->belongsTo(UserClient::class, 'client_id', 'id');
    }
}
