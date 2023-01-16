<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    use HasFactory;
    protected $fillable=[
        'account_id','amount','status','description','payment_id','balance_id','expires','slots',
        'balance_type'
    ];

    public function account(){
        return $this->belongsTo(Account::class);
    }


}
