<?php
/**
 * Created by PhpStorm.
 * User: Ong Lo
 * Date: 7/29/2019
 * Time: 1:35 PM
 */

namespace App\Shop\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class CronJobLog extends Model
{
    use Notifiable;
    protected $table = 'cron_job_log';
    protected $fillable = [
        'name',
        'note',
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
