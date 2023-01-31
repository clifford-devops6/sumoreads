<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $fillable=['name','email','subject_id','status','message'];

    public function subject(){
        return $this->belongsTo(Subject::class);
    }
}
