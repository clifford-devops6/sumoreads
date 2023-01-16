<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;
    protected $fillable=[
        'name', 'price','status_id'
    ];

    public  function status(){
        return $this->belongsTo(Status::class);
    }
    public function accounts(){
        return $this->hasMany(Account::class);
    }
}
