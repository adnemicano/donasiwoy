<?php
// app/Models/CampaignDonation.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignDonation extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'user_id',
        'value',
        'status',
        'is_anonymous',
        'transaction_id',
        'snap_token',
        'payment_method',
        'donor_name',
        'message'
    ];

    // Define status constants for easier reference
    const STATUS_WAITING = 'waiting';
    const STATUS_PENDING = 'pending';
    const STATUS_SUCCESS = 'succes';
    const STATUS_SETTLEMENT = 'settlement';
    const STATUS_FAILED = 'failed';
    const STATUS_EXPIRED = 'expire';
    const STATUS_CHALLENGE = 'challenge';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    // Helper method to check if payment is completed
    public function isPaymentCompleted()
    {
        return in_array($this->status, [self::STATUS_SUCCESS, self::STATUS_SETTLEMENT]);
    }

    // Helper method to check if payment is pending
    public function isPaymentPending()
    {
        return in_array($this->status, [self::STATUS_PENDING, self::STATUS_CHALLENGE]);
    }

    // Helper method to check if payment is waiting
    public function isPaymentWaiting()
    {
        return $this->status === self::STATUS_WAITING;
    }

    // Helper method to check if payment failed
    public function isPaymentFailed()
    {
        return in_array($this->status, [self::STATUS_FAILED, self::STATUS_EXPIRED]);
    }
}
