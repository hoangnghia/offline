<?php
/**
 * Created by PhpStorm.
 * User: Ong Lo
 * Date: 7/29/2019
 * Time: 1:35 PM
 */

namespace App\Shop\Sms;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class SmsLog extends Model
{
    use Notifiable;
    protected $table = 'sms_log';
    protected $fillable = [
        'code_result',
        'smsid',
        'content',
        'phone',
        'customer_log_id',
        'message',
        'user_id',
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
