<?php
/**
 * Created by PhpStorm.
 * User: Ong Lo
 * Date: 7/29/2019
 * Time: 1:35 PM
 */

namespace App\Shop\LocalCampaign;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class LocalCampaign extends Model
{
    use Notifiable;
    protected $table = 'local_campaign';
    protected $fillable = [
        'local_id',
        'campaign_id',
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
