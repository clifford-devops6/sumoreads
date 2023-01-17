<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory;

    protected $fillable=[
        'token','payment_id','account_id','expiry','balance_id','slots'
    ];

    public function balance(){
        return $this->belongsTo(Balance::class);
    }
    public function account(){
        return $this->belongsTo(Account::class);
    }

    public function payment(){
        return $this->belongsTo(Payment::class);
    }
}
