<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Panel;
use App\Models\Role;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Edwink\FilamentUserActivity\Traits\UserActivityTrait;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use \LaraZeus\Thunder\Concerns\ManageOffice;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable, UserActivityTrait, ManageOffice;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'accepts_tickets',
        'accepts_new_customers',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return true; // @todo Change this to check for access level
        // return $this->role->name === 'Admin';
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function isAdmin(): bool
    {
        if (!$this->relationLoaded('role')) {
            $this->load('role');
        }

        return $this->role->name === 'Admin' || $this->role->name === 'Developer';
    }

    function isDev() : bool {
        if (!$this->relationLoaded('role')) {
            $this->load('role');
        }

        return $this->role->name === 'Developer';
    }

    function isCustomer() : bool {
        if (!$this->relationLoaded('role')) {
            $this->load('role');
        }

        return $this->role->name === 'Customer';
    }

    function isAssistente() : bool {
        if (!$this->relationLoaded('role')) {
            $this->load('role');
        }

        return $this->role->name === 'Assistente';
    }

    function isPt() : bool {
        if (!$this->relationLoaded('role')) {
            $this->load('role');
        }

        return $this->role->name === 'Personal Trainer';
    }

    function isEmployee() : bool {
        if (!$this->relationLoaded('role')) {
            $this->load('role');
        }

        return $this->role->name === 'Employee';
    }

    /**
     * Get all of the appointments for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function appointments(): BelongsToMany
    {
        return $this->belongsToMany(Appointment::class,);
    }
}
