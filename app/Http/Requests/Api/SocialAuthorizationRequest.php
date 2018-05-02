<?php

namespace App\Http\Requests\Api;
use Dingo\Api\Http\FormRequest;

class SocialAuthorizationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *获取授权码=https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx9d573da5b448fba5&redirect_uri=http://larabbs.app&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect
     *得到授权码code=071zMzTV10IppW0B6yRV1S4QTV1zMzT6&state=STATE
     *获取access_token = https://api.weixin.qq.com/sns/oauth2/access_token?appid=wx9d573da5b448fba5&secret=c5fb5ca170df1a507082872b4ccf239b&code=011QejAW1lNNtT0SUYzW1AonAW1QejAR&grant_type=authorization_code
     *得到access_token=
     *通过access_token获取个人信息https://api.weixin.qq.com/sns/userinfo?access_token=9_RNtsCyZfq4mEElWIxcaOM6Vnqtrt3Hsg3djUtYCOg9txe-C8eTWx0EgNVP_zYAklNpTyXriCyLv1q6xrin2o6g&openid=o3umcwAdV-3YZoWVuHKF_kKleP_A&lang=zh_CN
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
       $rules = [
            'code' => 'required_without:access_token|string',
            'access_token' => 'required_without:code|string',
        ];
        if($this->social_type == 'weixin' && !$this->code ) {
            $rules['openid'] = 'required|string';
        }
        return $rules;
    }
}
