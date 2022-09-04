<?php

namespace App\Models;

use App\Observers\UserObserver;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class User extends Authenticatable implements Auditable, MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, AuditableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'phone_number',
        'email',
        'password',
        'admin',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::observe(UserObserver::class);
    }

    public function userable()
    {
        return $this->morphTo();
    }

    public function credits()
    {
        return $this->hasMany(Credit::class);
    }

    public function addresses()
    {
        return $this->hasMany(User::class);
    }

    public function setPasswordAttribute(?string $value = null)
    {
        if (isset($value)) {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    public function scopeAdmin($query)
    {
        $query->where('admin', 1);
    }

    public function creditBalance() {
        return $this->credits()
                    ->in()
                    ->whereHas('transaction', function($q) {
                        $q->confirmed();
                    })
                    ->sum('amount') - 
                $this->credits()
                     ->out()
                     ->sum('amount');
    }
}
