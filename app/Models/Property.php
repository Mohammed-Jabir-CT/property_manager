<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'region_id',
        'type',
        'location',
        'status',
        'featured_image'
    ];
    

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}
