<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
//use App\Http\Controllers\Controller;
use App\Http\Requests\Api\WeappAuthorizationRequest;


class AuthorizationsController extends Controller
{
    public function weappStore(WeappAuthorizationRequest $request)
    //public function weappStore(Request $request)
    {
        $code = $request->code;
        $data = [];
        // 根据 code 获取微信 openid 和 session_key
        $miniProgram = \EasyWeChat::miniProgram();
        $data_code = $miniProgram->auth->session($code);

        // 如果结果错误，说明 code 已过期或不正确，返回 401 错误
        if (isset($data_code['errcode'])) {
            $data['code'] = 999;
            return $data;
            //return $this->response->errorUnauthorized('code 不正确');
        }

        // 找到 openid 对应的用户
        $user = User::where('weapp_openid', $data_code['openid'])->first();

        $attributes['weixin_session_key'] = $data_code['session_key'];

        if (!$user) {
            $data['code'] = 10000;
            //return $this->response->errorForbidden('用户不存在');
            return $data;
        }
        /*
        // 未找到对应用户则需要提交用户名密码进行用户绑定
        if (!$user) {
            // 如果未提交用户名密码，403 错误提示
            if (!$request->username) {
                return $this->response->errorForbidden('用户不存在');
            }

            $username = $request->username;

            // 用户名可以是邮箱或电话
            filter_var($username, FILTER_VALIDATE_EMAIL) ?
                $credentials['email'] = $username :
                $credentials['phone'] = $username;

            $credentials['password'] = $request->password;

            // 验证用户名和密码是否正确
            if (!Auth::guard('api')->once($credentials)) {
                return $this->response->errorUnauthorized('用户名或密码错误');
            }

            // 获取对应的用户
            $user = Auth::guard('api')->getUser();
            $attributes['weapp_openid'] = $data['openid'];
        }
*/
        // 更新用户数据
        $user->update($attributes);

        // 为对应用户创建 JWT
        $token = \Auth::guard('api')->fromUser($user);
        $para['token'] = $token;
        $para['uid'] = $user->id;
        $data['data'] = $para;
	$data['code'] = 0;
	return $data;
        //return $this->respondWithToken($token)->setStatusCode(201);
    }
}
