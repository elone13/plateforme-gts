<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'created_by_commercial',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the client profile associated with the user.
     */
    public function client()
    {
        return $this->hasOne(Client::class, 'user_id');
    }

    /**
     * Get the administrator profile associated with the user.
     */
    public function administrateur()
    {
        return $this->hasOne(Administrateur::class, 'user_id');
    }

    /**
     * Check if user is an admin.
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is a client.
     */
    public function isClient()
    {
        return $this->role === 'client';
    }

    /**
     * Get the demo requests associated with the user's email.
     */
    public function demandesDemo()
    {
        return $this->hasMany(DemandeDemo::class, 'email', 'email');
    }

    /**
     * Check if email verification is required for this user.
     */
    public function requiresEmailVerification(): bool
    {
        // Si c'est un client créé par un commercial, pas besoin de vérification
        if ($this->role === 'client' && $this->created_by_commercial) {
            return false;
        }
        
        // Pour tous les autres utilisateurs, vérification requise
        return true;
    }

    /**
     * Check if the user's email is verified (considering commercial creation).
     */
    public function isEmailVerified(): bool
    {
        // Si c'est un client créé par un commercial, considérer comme vérifié
        if ($this->role === 'client' && $this->created_by_commercial) {
            return true;
        }
        
        // Sinon, utiliser la logique standard
        return !is_null($this->email_verified_at);
    }
}
