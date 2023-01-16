<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrator extends Model
{
    use HasFactory;
    protected $fillable=['user_id','account_id','slot'];

    public function  account(){
        return $this->belongsTo(Account::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
