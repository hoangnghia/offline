<?php
/**
 * Created by PhpStorm.
 * User: Ong Lo
 * Date: 7/29/2019
 * Time: 1:35 PM
 */

namespace App\Shop\Branchs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Branch extends Model
{
    use Notifiable;
    protected $table = 'branchs';
    protected $fillable = [
        'name',
        'type',
        'description',
        'local',
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
