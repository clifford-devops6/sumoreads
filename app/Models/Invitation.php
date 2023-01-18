<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;
    protected $fillable=['account_id','email','status'];
    public function account(){
        return $this->belongsTo(Account::class);
    }
}
