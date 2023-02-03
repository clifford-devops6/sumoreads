<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Advertisement extends Model implements  HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $fillable=[
        'title','description','url','status', 'start','expiry','price','remarks'
    ];

    protected $appends = ["image"];

    public function getImageAttribute()
    { return $this->getFirstMediaUrl('image','thumb'); }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->height(300);

    }

}
