<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory,Sluggable,SluggableScopeHelpers;
    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    protected $fillable=['name','account_id'];

    public function account(){
        return $this->belongsTo(Account::class);
    }

    public  function sources(){
        return $this->belongsToMany(Source::class);
    }

    public function categories(){
        return $this->belongsToMany(Category::class);
    }
    public function users(){
        return $this->belongsToMany(User::class);
    }
}
