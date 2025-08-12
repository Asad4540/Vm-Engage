<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;


class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'ad_preview',
        'ad_name',
        'campaign_id',
        'campaign_type',
        'status',
        'url',
        'delivered',
        'remaining',
        'clicks',
        'impressions',
        'mobile',
        'desktop',
        'country',
        'percentage',
        'date',
        'single_adpreview',
        'single_size',
        'single_clicks',
        'single_impressions',
    ];

    protected $casts = [
        'multiple_ads' => 'array',  // in Campaign model
    ];


    // protected $casts = [
    //     'url' => 'array',
    // ];



    // Relationship to Client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function getHashidAttribute()
    {
        return Hashids::encode($this->id);
    }

    public function getTotalClicksAttribute()
    {
        $clicks = json_decode($this->clicks ?? '[]', true);
        return is_array($clicks) ? array_sum($clicks) : 0;
    }

    public function getTotalImpressionsAttribute()
    {
        $impressions = json_decode($this->impressions ?? '[]', true);
        return is_array($impressions) ? array_sum($impressions) : 0;
    }
}



