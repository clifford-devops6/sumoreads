<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    use HasFactory;

    protected $fillable=[
        'sender_id','article_id','read_status','comment','email'
    ];

    public function article(){
        return $this->belongsTo(Article::class);
    }
    public function sender(){
        return $this->belongsTo(User::class,'sender_id');
    }
    public function groups()
    {
        return $this->morphedByMany(Group::class,'shareable');
    }

    public function users()
    {
        return $this->morphedByMany(User::class,'shareable');
    }
}
