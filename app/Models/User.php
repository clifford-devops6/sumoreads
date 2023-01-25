<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, HasPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'last_name',
        'account_id'
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
    ];

    public function  account(){
        return $this->belongsTo(Account::class);
    }
    public function  administrator(){
        return $this->hasOne(Administrator::class);
    }

    public function verifiable(){
        return $this->morphMany(Verify::class,'verifiable');
    }
    public  function sources(){
        return $this->belongsToMany(Source::class);
    }
    public  function categories(){
        return $this->belongsToMany(Category::class);
    }

    public function readlist(){
        return $this->hasMany(Readlist::class);
    }

    public function sender(){
        return $this->hasMany(Share::class,'sender_id');
    }
    public function shares(){
        return $this->morphToMany(Share::class,'shareable');
    }


}
