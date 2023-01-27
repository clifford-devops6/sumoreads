<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReadStatus extends Model
{
    use HasFactory;

    protected $fillable=['user_id','share_id','status'];

    public function user(){
        return $this->belongsTo(User::class);

    }

    public function share(){
        return $this->belongsTo(Share::class);

    }
}
