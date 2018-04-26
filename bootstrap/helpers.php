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
function model_admin_link($title, $model)
{
	return model_link($title, $model, 'admin');
}
function model_link ($title, $model, $prefix='')
{
	//获取数据模型的复数蛇形命名
	$model_name = model_plural_name($model);

	//初始化前缀
	$prefix = $prefix ? "/$prefix/" : '/';

	//使用站点URL拼接全量 URL
	$url = config('app.url') . $prefix . $model_name . '/' . $model->id;

	//拼接HTML A标签，并返回
	return '<a href="'. $url .'" target="_blank">' . $title . '</a>';
}
function model_plural_name($model)
{
	//从实体中获取完整类名，例如：App\Models\User
	$full_class_name = get_class($model);


}