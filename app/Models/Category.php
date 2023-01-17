<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Category extends Model
{
    use HasFactory,Sluggable,SluggableScopeHelpers;
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    protected $fillable=['name','status_id','icon'];

    public  function  status(){
        return $this->belongsTo(Status::class);
    }
    public  function articles(){
        return $this->hasMany(Article::class);
    }

    public  function accounts(){
        return $this->belongsToMany(Account::class);
    }

    public  function users(){
        return $this->belongsToMany(Account::class);
    }
}
