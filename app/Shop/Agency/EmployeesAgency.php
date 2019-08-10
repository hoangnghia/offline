<?php
/**
 * Created by PhpStorm.
 * User: Ong Lo
 * Date: 7/29/2019
 * Time: 1:35 PM
 */

namespace App\Shop\Agency;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class EmployeesAgency extends Model
{
    use Notifiable;
    protected $table = 'employees_agency';
    protected $fillable = [
        'agency_id',
        'employees_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

}
