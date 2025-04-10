<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    public $fillable = [
        'thumbnail',
        'title',
        'slug',
        'story',
        'target',
        'end_date'
    ];

    public function donations()
    {
        return $this->hasMany(CampaignDonation::class);
    }

    public function getTotalDonationsAttribute()
    {
        return $this->donations()->where('status', 'succes')->sum('value');
    }

    public function getDonorsCountAttribute()
    {
        return $this->donations()->where('status', 'succes')->distinct('user_id')->count('user_id');
    }
}
