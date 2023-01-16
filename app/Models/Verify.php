<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verify extends Model
{
    use HasFactory;
    protected $fillable=['code', 'verifiable_id', 'verifiable_type','email','status','token'];
    public function verifiable(){
        return $this->morphTo();
    }
}
