<?php

namespace App\Http\Controllers\Admin\Commerce;

use App\Http\Controllers\Controller;
use App\Shop\Permissions\Repositories\PermissionRepository;
use App\Shop\Tools\Config;
use Illuminate\Http\Request;

class CommerceController extends Controller
{
    /**
     * @var PermissionRepository
     */
    private $permRepo;

    /**
     * PermissionController constructor.
     *
     * @param PermissionRepository $permissionRepository
     */
    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->permRepo = $permissionRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $quantityBuy = Config::where('name', 'quantity_buy')->first();
        $timerBuy = Config::where('name', 'timer_buy')->first();
        return view('admin.commerce.edit',
            [
                'quantityBuy' => $quantityBuy,
                'timerBuy' => $timerBuy
            ]);
    }

    public function update(Request $request)
    {
        if (isset($request['quantity_buy'])) {
            $config = Config::where('name', 'quantity_buy')->first();
            $config->value = $request['quantity_buy'];
            $config->save();
        }
        if (isset($request['timer_buy'])) {
            $config = Config::where('name', 'timer_buy')->first();
            $config->value = $request['timer_buy'];
            $config->save();
        }
        return redirect('admin/commerce')
            ->with('message', 'Cập nhật thành công');
    }
}
