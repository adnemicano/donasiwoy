<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'campaign_id',
        'amount',
        'payment_status',
        'payment_method',
        'transaction_id'
    ];

    // Tambahkan default value untuk mencegah null
    protected $attributes = [
        'amount' => 0,
        'payment_status' => 'pending',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class)->withDefault([
            'title' => 'Campaign Tidak Tersedia',
            'image' => 'images/default-campaign.png'
        ]);
    }
}