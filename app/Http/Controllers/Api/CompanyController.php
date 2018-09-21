<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
{
    public function index() {
        $data['code'] = 0;
        $para = [];
        $banner1['businessId'] = 1;
        $banner1['picUrl'] = "https://www.52hairycrab.com/storage/img/us1.jpg";
        $banner2['businessId'] = 2;
        $banner2['picUrl'] = "https://www.52hairycrab.com/storage/img/us3.jpg";
        $banner3['businessId'] = 3;
        $banner3['picUrl'] = "https://www.52hairycrab.com/storage/img/us2.jpg";
        $banner4['businessId'] = 4;
        $banner4['picUrl'] = "https://www.52hairycrab.com/storage/img/us4.jpg";
        $banner5['businessId'] = 5;
        $banner5['picUrl'] = "https://www.52hairycrab.com/storage/img/us5.jpg";
        array_push($para, $banner1, $banner2, $banner3, $banner4, $banner5);
        $data['banners'] = $para;
        $data['address'] = "江苏省昆山市";
        $data['weixin'] = "xianshagnxianxia";
        $data['qq'] = "12345678";
        $data['mobile'] = '18551111111';
        return $data;
    }
}