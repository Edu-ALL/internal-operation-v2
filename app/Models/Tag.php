<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Tag extends Model
{
    use HasFactory;

    protected $table = 'tbl_tag';

    protected $fillable = [
        'name',
        'sub_country',
        'score'
    ];

    public function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => date('M d, Y H:i:s', strtotime($value)),
        );
    }

    public function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => date('M d, Y H:i:s', strtotime($value)),
        );
    }

    public function universities()
    {
        return $this->hasMany(University::class, 'tag', 'id');
    }

    public function client()
    {
        return $this->belongsToMany(UserClient::class, 'tbl_client_abrcountry', 'tag_id', 'client_id');
    }
}
