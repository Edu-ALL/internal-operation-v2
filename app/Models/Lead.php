<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $table = 'tbl_lead';

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $fillable = [
        'lead_id',
        'main_lead',
        'sub_lead',
        'score',
        'department_id',
        'color_code',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($query) {
            $query->color_code = self::getColorCodeAttribute();
        });
    }

    public static function getColorCodeAttribute()
    {
        return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    }

    public function leadName(): Attribute
    {
        if ($this->sub_lead != null) {

            return Attribute::make(
                get: fn ($value) => $this->main_lead . ' : ' . $this->sub_lead,
            );
        }
            
            
        return Attribute::make(
            get: fn ($value) => $this->main_lead,
        );
        
    }

    public static function whereLeadId($id)
    {
        if (is_array($id) && empty($id)) return new Collection;

        $instance = new static;

        return $instance->newQuery()->where('lead_id', $id)->first();
    }

    public static function whereLeadName($name)
    {
        if (is_array($name) && empty($name)) return new Collection;

        $instance = new static;

        return $instance->newQuery()->whereRaw('lower(main_lead) = ?', [$name])->first();
    }

    public function client()
    {
        return $this->hasMany(UserClient::class, 'lead_id', 'lead_id');
    }

    public function clientEvent()
    {
        return $this->hasMany(ClientEvent::class, 'lead_id', 'lead_id');
    }

    public function clientProgram()
    {
        return $this->hasMany(ClientProgram::class, 'lead_id', 'lead_id');
    }
}
