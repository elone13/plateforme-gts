<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
        'image',
        'prix',
    ];

    /**
     * Get the items for the service.
     */
    public function items()
    {
        return $this->hasMany(Item::class, 'service_id', 'id');
    }
}
