<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrateur extends Model
{
    use HasFactory;

    protected $primaryKey = 'idadministrateur';

    protected $fillable = [
        'user_id',
        'type',
    ];

    /**
     * Get the user that owns the administrator.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if administrator is a manager.
     */
    public function isManager()
    {
        return $this->type === 'manager';
    }

    /**
     * Check if administrator is a commercial.
     */
    public function isCommercial()
    {
        return $this->type === 'commercial';
    }
}
