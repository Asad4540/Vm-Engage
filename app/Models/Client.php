<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Hashids\Hashids;
use Vinkla\Hashids\Facades\Hashids; 

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo',
        'details',
        'status',
    ];

    public function campaigns()
    {
        return $this->hasMany(Campaign::class);
    }


    // public function getHashidAttribute()
    // {
    //     $hashids = new Hashids(config('app.key'), 10);
    //     return $hashids->encode($this->id);
    //     // return Hashids::encode($this->id);
    // }


    public function getHashidAttribute()
    {
        return Hashids::encode($this->id);
    }

}


