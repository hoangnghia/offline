<?php

namespace App\Shop\Customer;

use App\Shop\Addresses\Address;
use App\Shop\Orders\Order;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class CustomerIntroduce extends Authenticatable
{
    use Notifiable;
    protected $table = 'customer_introduce';


    const NGO_THI_THUY_TRANG = 1;
    const DUONG_THI_HONG_DIEP = 2;
    const HOANG_LE_QUYEN = 3;
    const LE_THI_TUYET_NGA = 4;
    const HUYNH_THI_NGOC_DIEM = 5;
    const LE_VAN_THAO = 6;
    const PHI_TRONG_KHANH = 7;
    const TO_THI_CAM_HUONG = 8;
    const NGUYEN_THI_NHU_HUYNH = 9;
    const LE_THI_THUY = 10;
    const DO_THI_HUONG = 11;
    const MLO_HLIEU = 12;
    const TRUONG_MY_HIEP = 13;
    const LY_THI_HOA = 14;
    const NGUYENX_THI_HONG_LY = 15;
    const PHAM_THUY_DUONG = 16;
    const NGUYEN_LE_THANH_TRUC = 17;

    const NGUYEN_THI_THU_HANG = 18;
    const CHUNG_THUY_THUY_VI = 19;
//    const LE_THI_THUY = 20;
    const NGUYEN_THANH_TUYEN = 21;
    const NGUYEN_THI_KIM_NGOC = 22;
    const lE_TRAN_PHUONG_UYEN = 23;
//    const NGUYEN_THI_K_THUY = 24;
    const CAO_NHAT_ANH = 25;
    const NGUYEN_THI_K_THUY = 26;
    const PHAM_THI_TUYET_NGAN = 27;
    const CCS = 24;


    const USER_TEXT = [
        self::NGO_THI_THUY_TRANG => 'Ngô Thị Thùy Trang',
        self::DUONG_THI_HONG_DIEP => 'Dương Thị Hồng Điệp',
        self::HOANG_LE_QUYEN => 'Hoàng Lệ Quyên',
        self::LE_THI_TUYET_NGA => 'Lê Thị Tuyết Ngân',
//        self::HUYNH_THI_NGOC_DIEM => 'Huynh Thị Ngọc Diễm',
//        self::LE_VAN_THAO => 'Lê Vân Thảo',
        self::PHI_TRONG_KHANH => 'Phí  Trọng Khánh',
        self::TO_THI_CAM_HUONG => 'Tô Thị Cẩm Hương',
        self::NGUYEN_THI_NHU_HUYNH => 'Nguyễn Thị Như Huỳnh',
//        self::LE_THI_THUY => 'Lê Thị Thủy',
        self::DO_THI_HUONG => 'Đỗ Thị Hương',
        self::MLO_HLIEU => 'MLÔ HLiêu',
        self::TRUONG_MY_HIEP => 'Trương Mỹ Hiệp',
        self::LY_THI_HOA => 'Lý Thị Hoa',
        self::NGUYENX_THI_HONG_LY => 'Nguyễn Thị Hồng Ly',
        self::PHAM_THUY_DUONG => 'Phạm Thùy Dương',
        self::NGUYEN_LE_THANH_TRUC => 'Nguyễn Lê Thanh Trúc',

//        self::NGUYEN_THI_THU_HANG => 'Nguyễn Thị Thu Hằng',
//        self::CHUNG_THUY_THUY_VI => 'Chung Thùy Thúy Vi',
//        self::LE_THI_THUY => 'Lê Thị Thủy',
//        self::NGUYEN_THANH_TUYEN => 'Nguyễn Thanh Tuyền',
//        self::NGUYEN_THI_KIM_NGOC => 'Nguyễn Thị Kim Ngọc',
        self::lE_TRAN_PHUONG_UYEN => 'Lê Trần Phương Uyên',
//        self::NGUYEN_THI_KIM_THUY => 'Nguyễn Thị Kim Thùy',
        self::CAO_NHAT_ANH => 'Cao Nhật Anh',
        self::NGUYEN_THI_K_THUY => 'Trần Thị Kim Thùy',
        self::PHAM_THI_TUYET_NGAN => 'Phạm Thị Tuyết Ngân',
        self::CCS => 'CCS',

    ];

    protected $fillable = [
        'name',
        'phone',
        'birthday',
        'created_at',
        'updated_at',
        'branch',
        'name_introduce',
        'phone_introduce',
        'care_ccs',
        'care_offline',
        'status_moon',
        'note',
        'ticket_crm_id',
        'lead_id',
        'is_exist_ticket',
        'is_exist_lead',
        'Job_code',
        'team_of',
        'status_care'
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
