<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


class Source extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia,Sluggable,SluggableScopeHelpers;

    protected $fillable=['name','category_id','status_id','domain', 'country_id','pulls'];

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

    public  function  status(){
        return $this->belongsTo(Status::class);
    }

    public  function  category(){
        return $this->belongsTo(Category::class);
    }

    public  function  country(){
        return $this->belongsTo(Country::class);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('logo-icon')
            ->height(100);

    }
}
