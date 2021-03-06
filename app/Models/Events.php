<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Events extends Model implements HasMedia
{
    use HasFactory;

    use InteractsWithMedia;

    protected $guarded = [];

    public function author()
    {
        return $this->hasOne(User::class, 'id', 'author');
    }
}
