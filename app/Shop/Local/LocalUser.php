<?php
/**
 * Created by PhpStorm.
 * User: Ong Lo
 * Date: 7/29/2019
 * Time: 1:35 PM
 */

namespace App\Shop\Local;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class LocalUser extends Model
{
    use Notifiable;
    protected $table = 'local_user';
    protected $fillable = [
        'user_id',
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
