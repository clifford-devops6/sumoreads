<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Invitation extends Model
{
    use HasFactory, Notifiable;
    protected $fillable=['account_id','email','status','token'];
    public function account(){
        return $this->belongsTo(Account::class);
    }
}
