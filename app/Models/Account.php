<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    protected $fillable=[
        'type_id','status_id','name','billing_date'
    ];
    public function type(){
        return $this->belongsTo(Type::class);
    }
    public  function administrator(){
        return $this->hasOne(Administrator::class);
    }
    public  function company(){
        return $this->hasOne(Company::class);
    }
    public  function sources(){
        return $this->belongsToMany(Source::class);
    }
    public  function categories(){
        return $this->belongsToMany(Category::class);
    }

    public function users(){
        return $this->hasMany(User::class);
    }
    public function balances(){
        return $this->hasMany(Balance::class);
    }
    public function invitations() {
        return $this->hasMany(Invitation::class);
    }

    public function groups() {
        return $this->hasMany(Group::class);
    }

    public function tokens()
    {
        return  $this->hasMany(Token::class);

    }
}
