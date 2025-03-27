<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class News extends Model
{
    use HasFactory;

    public $fillable = [
        'thumbnail',
        'title',
        'slug',
        'content',
        'date'
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        return $this->thumbnail ? Storage::url($this->thumbnail) : asset('assets/img/default-thumbnail.jpg');
    }
}
