<?php

/**
 * 请求的路由名称转换成css类名称，作用是允许我针对不同页面作定制
 * @Author   chy
 * @DateTime 2018-04-15
 * @param    [type]
 * @return   [type]     [description]
 */
function route_class()
{
	return str_replace(',', '-', Route::currentRouteName());
}

function make_excerpt($value, $length=200)
{
	$excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));
	return str_limit($excerpt, $length);
}