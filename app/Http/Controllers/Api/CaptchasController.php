<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Gregwar\Captcha\CaptchaBuilder;
use App\Http\Requests\Api\CaptchaRequest;

class CaptchasController extends Controller
{
    /*
     * 用手机号请求生成图片验证码
     */
    public function store(CaptchaRequest $request, CaptchaBuilder $CaptchaBuilder)
    {
    	$key = 'captcha-' . str_random(15);
    	$phone = $request->phone;

    	$captcha = $CaptchaBuilder->build();
    	$expiredAt = now()->addMinutes(2);
    	\Cache::put($key, ['phone' => $phone, 'code' => $captcha->getPhrase()], $expiredAt);

    	$result = [
    		'captcha_key' => $key,
    		'expired_at' => $expiredAt->toDateTimeString(),
    		'captcha_imagte_content' => $captcha->inline()
    	];
    	return $this->response->array($result)->setStatusCode(201);
    }
}
