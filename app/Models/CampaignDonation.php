<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignDonation extends Model
{
    use HasFactory;

    public $fillable = [
        'campaign_id',
        'user_id',
        'value',
        'status'
    ];
}
