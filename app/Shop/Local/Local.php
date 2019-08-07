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

class Local extends Model
{
    use Notifiable;
    protected $table = 'local';
    protected $fillable = [
        'name',
        'branch_id',
        'taget',
        'address',
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
