<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable=[
        'first_name','last_name','phone_number','email', 'amount',
        'currency','reference','description','status','tracking_id','payment_method',
        'account_id','user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function account(){
        return $this->belongsTo(Account::class);
    }
}
