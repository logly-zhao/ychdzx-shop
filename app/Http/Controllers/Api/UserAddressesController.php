<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\UserRequest;
use Illuminate\Http\Request;
use App\Models\UserAddress;
use App\Http\Requests\UserAddressRequest;

class UserAddressesController extends Controller
{
    public function index(Request $request)
    {
        $data = [];
        $count = 0;
        $para = [];
        $addresses = $request->user()->addresses;
        foreach($addresses as $address) {
            $item = [];
            $item['id'] = $address->id ;
            $item['linkMan'] = $address->contact_name ;
            $item['mobile'] = $address->contact_phone;
            //$item['address'] = $address->province.$address->city.$address->district.$address->address;
            $item['address'] = $address->getFullAddressAttribute();
            $count ++;
            array_push($para, $item);
        }
        if($count == 0)
            $data['code'] = 700;
        else
            $data['code'] = 0;
        $data['data'] = $para;
        return $data;
    }

    public function store(UserAddressRequest $request)
    {
        $request->user()->addresses()->create($request->only([
            'province',
            'city',
            'district',
            'address',
            'zip',
            'contact_name',
            'contact_phone',
        ]));
        $data['code'] = 0;
        return $data;
    }

    public function edit(Request $request)
    {
        $address = UserAddress::query()->where('id', $request->product)->first();

        $data = [];
        $para = [];
        $para['id'] = $address->id ;
        $para['linkMan'] = $address->contact_name ;
        $para['mobile'] = $address->contact_phone;
        $para['address'] = $address->address;
        $para['provinceStr'] = $address->province;
        $para['cityStr'] = $address->city;
        $para['areaStr'] = $address->district;
        $para['code'] = $address->zip;

        if($address)
            $data['code'] = 0;
        else
            $data['code'] = 700;
        $data['data'] = $para;
        return $data;

//        return view('user_addresses.create_and_edit', ['address' => ]);*/
    }

    public function update(UserRequest $request)
    {
        $user_address = UserAddress::query()->where('id', $request->product)->first();

        $this->authorize('own', $user_address);

        $user_address->update($request->only([
            'province',
            'city',
            'district',
            'address',
            'zip',
            'contact_name',
            'contact_phone',
        ]));

        $data['code'] = 0;
        return $data;
    }

    public function destroy(Request $request)
    {
        $user_address = UserAddress::query()->where('id', $request->product)->first();
        $this->authorize('own', $user_address);
        $user_address->delete();
        return [];
    }
}
