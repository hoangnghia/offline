<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/**
 * Admin routes
 */
Route::namespace('Admin')->group(function () {
    Route::get('admin/login', 'LoginController@showLoginForm')->name('admin.login');
    Route::post('admin/login', 'LoginController@login')->name('admin.login');
    Route::get('admin/logout', 'LoginController@logout')->name('admin.logout');
});
Route::group(['prefix' => 'admin', 'middleware' => ['employee'], 'as' => 'admin.'], function () {
    Route::namespace('Admin')->group(function () {
        Route::group(['middleware' => ['role:admin|superadmin|clerk, guard:employee']], function () {
//            Route::get('/', 'DashboardController@index')->name('dashboard');
//            Route::get('getListDatCampaign', 'DashboardController@getListDatCampaign')->name('admin.getListDatCampaign');
//            Route::get('getListDataUser', 'DashboardController@getListDataUser')->name('admin.getListDataUser');


            Route::namespace('Products')->group(function () {
                Route::resource('products', 'ProductController');
                Route::get('sync-product-from-zalo', 'ProductController@synchronized')->name('product.sync.zalo');
                Route::get('remove-image-product', 'ProductController@removeImage')->name('product.remove.image');
                Route::get('remove-image-thumb', 'ProductController@removeThumbnail')->name('product.remove.thumb');
            });
            Route::namespace('Categories')->group(function () {
                Route::resource('categories', 'CategoryController');
                Route::get('sync-category-from-zalo', 'CategoryController@synchronized')->name('categories.sync.zalo');
                Route::get('remove-image-category', 'CategoryController@removeImage')->name('category.remove.image');
            });
            Route::namespace('Orders')->group(function () {
                Route::resource('orders', 'OrderController');
                Route::resource('order-statuses', 'OrderStatusController');
                Route::get('orders/{id}/invoice', 'OrderController@generateInvoice')->name('orders.invoice.generate');
            });
            Route::resource('addresses', 'Addresses\AddressController');
            Route::resource('countries', 'Countries\CountryController');
            Route::resource('countries.provinces', 'Provinces\ProvinceController');
            Route::resource('countries.provinces.cities', 'Cities\CityController');
            Route::resource('couriers', 'Couriers\CourierController');
            Route::resource('attributes', 'Attributes\AttributeController');
            Route::resource('attributes.values', 'Attributes\AttributeValueController');
            Route::resource('brands', 'Brands\BrandController');
        });
        Route::group(['middleware' => ['role:admin|superadmin, guard:employee']], function () {
            Route::resource('employees', 'EmployeeController');
            Route::get('employees/{id}/profile', 'EmployeeController@getProfile')->name('employee.profile');
            Route::put('employees/{id}/profile', 'EmployeeController@updateProfile')->name('employee.profile.update');
            Route::post('employees/status/{id}', 'EmployeeController@status')->name('employee.status');
            Route::resource('roles', 'Roles\RoleController');
            Route::resource('permissions', 'Permissions\PermissionController');
            Route::resource('commerce', 'Commerce\CommerceController');
            Route::put('commerce/{id}', 'CommerceController@update')->name('admin.commerce.update');
            Route::post('roles/{id}', 'RoleController@destroy')->name('roles.destroy');
            Route::get('employees/{id}/profile', 'EmployeeController@getProfile')->name('employee.profile');

            // Danh sach campaign
            Route::resource('campaigns', 'Campaigns\CampaignController');
            Route::get('campaign/status/{id}', 'Campaigns\CampaignController@status')->name('campaign.status');
            Route::get('campaign/edit/{id}', 'Campaigns\CampaignController@edit')->name('campaign.edit');
            Route::POST('campaign/editPosst', 'Campaigns\CampaignController@postEditCampaign')->name('campaign.editPosst');
            Route::get('campaign/delete/{id}', 'Campaigns\CampaignController@delete')->name('campaign.delete');
            Route::GET('campaign/create', 'Campaigns\CampaignController@getAddCampaign')->name('campaign.create');
            Route::POST('campaign/store', 'Campaigns\CampaignController@postAddCampaign')->name('campaign.store');
            Route::GET('campaign/getListData', 'Campaigns\CampaignController@getListData')->name('campaign.getListData');
            Route::get('campaign/user/{id}', 'Campaigns\CampaignController@user')->name('campaign.user');
            Route::POST('campaign/user', 'Campaigns\CampaignController@postUserCampaign')->name('campaign.user');


            // Danh sách chi nhánh
            Route::resource('branch', 'Branchs\BranchController');
            Route::GET('branchs/getListData', 'Branchs\BranchController@getListData')->name('branch.getListData');
            Route::GET('branch/create', 'Branchs\BranchController@getAddBranch')->name('branch.create');
            Route::POST('branch/store', 'Branchs\BranchController@postAddBranch')->name('branch.store');
            Route::GET('branch/{id}/edit', 'Branchs\BranchController@getEditBranch')->name('branch.edit');
//            Route::PUT('branchs/{id}/edit', 'Branchs\BranchController@updateEditBranch')->name('branch.update');
            Route::post('branch/{id}', 'Branchs\BranchController@destroy')->name('branch.destroy');
            Route::get('branchs/status/{id}', 'Branchs\BranchController@status')->name('branch.status');
            Route::get('branchs/edit/{id}', 'Branchs\BranchController@edit')->name('branch.edit');
            Route::get('branchs/delete/{id}', 'Branchs\BranchController@delete')->name('branch.delete');
            Route::POST('branchs/updata', 'Branchs\BranchController@updateEditBranch')->name('branch.updata');

            // Danh sách agencys
            Route::GET('agencys/index', 'Agencys\AgencyController@index')->name('agencys.index');
            Route::GET('agencys/getListData', 'Agencys\AgencyController@getListData')->name('agencys.getListData');
            Route::GET('agencys/create', 'Agencys\AgencyController@getAddAgency')->name('agencys.create');
            Route::POST('agencys/store', 'Agencys\AgencyController@postAddAgency')->name('agencys.store');
            Route::get('agencys/status/{id}', 'Agencys\AgencyController@status')->name('agencys.status');
            Route::get('agencys/delete/{id}', 'Agencys\AgencyController@delete')->name('agencys.delete');
            Route::get('agencys/edit/{id}', 'Agencys\AgencyController@edit')->name('agencys.edit');
            Route::post('agencys/destroy', 'Agencys\AgencyController@destroy')->name('agencys.destroy');
            // Danh sách dịch vụ
            Route::GET('services/index', 'Services\ServiceController@index')->name('services.index');
            Route::GET('services/getListData', 'Services\ServiceController@getListData')->name('services.getListData');
            Route::GET('services/create', 'Services\ServiceController@getAddService')->name('services.create');
            Route::POST('services/store', 'Services\ServiceController@postAddService')->name('services.store');
            Route::get('services/status/{id}', 'Services\ServiceController@status')->name('services.status');
            Route::get('services/delete/{id}', 'Services\ServiceController@delete')->name('services.delete');
            Route::get('services/edit/{id}', 'Services\ServiceController@edit')->name('services.edit');
            Route::post('services/destroy', 'Services\ServiceController@destroy')->name('services.destroy');

//            // Danh sách khách hàng đăng ký
//            Route::GET('customer/index', 'Customers\CustomerController@index')->name('customer.index');
//            Route::GET('customer/getListData', 'Customers\CustomerController@getListData')->name('customer.getListData');
//            Route::get('customer/detail/{id}', 'Customers\CustomerController@detail')->name('customer.detail');
//            Route::POST('customer/detailUpload', 'Customers\CustomerController@detailUpload')->name('customer.detailUpload');
//            Route::get('customer/status/{id}', 'Customers\CustomerController@status')->name('customer.status');
//            Route::get('customer/delete/{id}', 'Customers\CustomerController@delete')->name('customer.delete');
////            Route::POST('caresoft/put', 'Customers\CustomerController@postCareSoft')->name('caresoft.put');
//            Route::get('customer/export', 'Customers\CustomerController@export')->name('customer.export');
//            Route::get('customer/sms', 'Customers\CustomerController@smsCreate')->name('customer.sms');
//            Route::POST('customer/sent', 'Customers\CustomerController@smsSent')->name('customer.sent');
//            Route::get('customer/history', 'Customers\CustomerController@history')->name('customer.history');
//            Route::get('customer/getHistory', 'Customers\CustomerController@getHistory')->name('customer.getHistory');
//            Route::get('customer/careSoft', 'Customers\CustomerController@careSoft')->name('customer.careSoft');
////            Route::get('customer/sms', 'Customers\CustomerController@smsCreate')->name('customer.sms');
//            Route::POST('customer/careSoftSent', 'Customers\CustomerController@careSoftSent')->name('customer.careSoftSent');
        });
        Route::group(['middleware' => ['role:admin|superadmin|offline, guard:employee']], function () {
            Route::get('/', 'DashboardController@index')->name('dashboard');
            Route::get('getListDatCampaign', 'DashboardController@getListDatCampaign')->name('admin.getListDatCampaign');
            Route::get('getListDataUser', 'DashboardController@getListDataUser')->name('admin.getListDataUser');
// Danh sách khách hàng đăng ký
            Route::GET('customer/index', 'Customers\CustomerController@index')->name('customer.index');
            Route::GET('customer/getListData', 'Customers\CustomerController@getListData')->name('customer.getListData');
            Route::get('customer/detail/{id}', 'Customers\CustomerController@detail')->name('customer.detail');
            Route::POST('customer/detailUpload', 'Customers\CustomerController@detailUpload')->name('customer.detailUpload');
            Route::get('customer/status/{id}', 'Customers\CustomerController@status')->name('customer.status');
            Route::get('customer/delete/{id}', 'Customers\CustomerController@delete')->name('customer.delete');
//            Route::POST('caresoft/put', 'Customers\CustomerController@postCareSoft')->name('caresoft.put');
            Route::get('customer/export', 'Customers\CustomerController@export')->name('customer.export');
            Route::get('customer/sms', 'Customers\CustomerController@smsCreate')->name('customer.sms');
            Route::POST('customer/sent', 'Customers\CustomerController@smsSent')->name('customer.sent');
            Route::get('customer/history', 'Customers\CustomerController@history')->name('customer.history');
            Route::get('customer/getHistory', 'Customers\CustomerController@getHistory')->name('customer.getHistory');
            Route::get('customer/careSoft', 'Customers\CustomerController@careSoft')->name('customer.careSoft');
//            Route::get('customer/sms', 'Customers\CustomerController@smsCreate')->name('customer.sms');
            Route::POST('customer/careSoftSent', 'Customers\CustomerController@careSoftSent')->name('customer.careSoftSent');
            Route::get('customer/getCheckCareSoft', 'Customers\CustomerController@getCheckCareSoft')->name('customer.getCheckCareSoft');
        });
    });
});

Route::namespace('Front')->group(function () {
    Route::get('/', 'LoginController@showLoginForm')->name('front.login');
    Route::post('front/login', 'LoginController@login')->name('front.login');
    Route::get('front/logout', 'LoginController@logout')->name('front.logout');
});

Route::group(['middleware' => ['front']], function () {
    Route::namespace('Front')->group(function () {
        Route::get('employee/dashboard', 'HomeController@index')->name('employee.dashboard');
        Route::get('employee/add/{id}', 'HomeController@add')->name('employee.add');
        Route::get('employee/customer/{id}', 'HomeController@customer')->name('employee.customer');
        Route::POST('employee/add', 'HomeController@postAddCustomer')->name('employee.add');
        Route::get('employee/addRelatives/{id}', 'HomeController@AddRelatives')->name('employee.addRelatives');
        Route::POST('employee/postAddRelatives', 'HomeController@postAddRelatives')->name('employee.postAddRelatives');
    });
});

