<?php

namespace App\Shop\Customer;

use App\Shop\Addresses\Address;
use App\Shop\Orders\Order;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Cashier\Billable;
use Nicolaslopezj\Searchable\SearchableTrait;

class CustomerCRM extends Authenticatable
{


    use Notifiable;
    protected $table = 'oad_customer_validate';
    protected $fillable = [
        'ho_ten', 'phone', 'dich_vu', 'nguon_phieu','vung_mien','chi_nhanh','user_id','user_care','ticket_id','chi_tiet_nguon','type','campain_id','status','created_at','updated_at','status_validate','title','type_source','lead_id','is_exist_ticket','is_exist_lead','is_map_to_customer','object'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dates = ['deleted_at'];

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'customers.name' => 10,
            'customers.email' => 5
        ]
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function addresses()
    {
        return $this->hasMany(Address::class)->whereStatus(true);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * @param $term
     *
     * @return mixed
     */
    public function searchCustomer($term)
    {
        return self::search($term);
    }
}
