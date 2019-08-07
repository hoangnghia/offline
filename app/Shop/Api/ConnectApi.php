<?php
/**
 * Created by PhpStorm.
 * User: Ong Lo
 * Date: 7/8/2019
 * Time: 10:55 AM
 */

namespace App\Shop\Api;


use Illuminate\Database\Eloquent\Model;

trait ConnectApi
{
    public function httpGetCategoryZalo($url)
    {
        $timeout = 30;
        $connectTimeout = 30;
        $sslVerifyPeer = false;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $connectTimeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "Authorization: " . config('constants.CARE_SOFT_PASSWORD')));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $sslVerifyPeer);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
    public function httpZalo($url, $str_data)
    {
        $timeout = 30;
        $connectTimeout = 30;
        $sslVerifyPeer = false;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $connectTimeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "Authorization: " . config('constants.CARE_SOFT_PASSWORD')));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $sslVerifyPeer);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $str_data);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
    public function httpUploadZalo($url, $str_data)
    {
        $timeout = 30;
        $connectTimeout = 30;
        $sslVerifyPeer = false;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $connectTimeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "Authorization: " . config('constants.CARE_SOFT_PASSWORD')));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $sslVerifyPeer);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $str_data);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}