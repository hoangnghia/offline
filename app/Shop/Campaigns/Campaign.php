<?php

namespace App\Shop\Campaigns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Campaign extends Model
{
    use Notifiable;
    protected $table = 'campaign';
    protected $fillable = [
        'name',
        'note',
        'time_start',
        'time_end',
        'address',
        'taget',
        'cost',
        'age',
        'agency_id',
        'status',
        'created_at',
        'updated_at'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

}
