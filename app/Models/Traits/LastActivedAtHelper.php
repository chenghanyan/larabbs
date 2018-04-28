<?php

namespace App\Models\Traits;

use Redis;
use Carbon\Carbon;

trait LastActivedAtHelper
{
	//缓存相关
	protected $hash_prefix = 'larabbs_last_actived_at_';
	protected $field_prefix = 'user_';

	public function recordLastActiveAt()
	{
		//获取今天的日期
		// $date = Carbon::now()->toDateString();

		//Redis 哈希表的命名，如：larabbs_last_actived_at_2017-10-21
		// $hash = $this->hash_prefix . $date;
		//上面两名成一句，复用性
		$hash = $this->getHashFromDateString(Carbon::now()->toDateString());

		//字段名称 如：user_1
		// $field = $this->field_prefix . $this->id;
		$field = $this->getHashField();
		// dd(Redis::hGetAll($hash));
		//当前时间，如：2017-10-21
		$now = Carbon::now()->toDateTimeString();

		//数据写入Redis,字段已存在会被更新
		Redis::hSet($hash, $field, $now);
	}
	public function syncUserActivedAt()
	{
		//获取昨天日期，格式如：2018-10-28
		// $yesterday_date = Carbon::yesterday()->toDateString();
		//Redis哈希表的命名，如larabbs_last_actived_at_2018-10-28
		// $hash = $this->hash_prefix . $yesterday_date;
		$hash = $this->getHashFromDateString(Carbon::yesterday()->toDateString());

		//从Reids中获取所有的哈希表里的数据
		$dates = Redis::hGetAll($hash);

		//遍历，并同步到数据库中
		foreach ($dates as $user_id => $actived_at) {
			//会将user_1转换为1
			$user_id = str_replace($this->field_prefix, '', $user_id);

			//只有当用户存在 时才更新到数据库中
			if ($user = $this->find($user_id)) {
				$user->last_actived_at = $actived_at;
				$user->save();
			}
		}
		//以数据库为中心的存储，既已同步 ，即可删除
		Redis::del($hash);
	}
	public function getLastActivedAtAttribute($value)
	{
		//获取今天的日期
		// $date = Carbon::now()->toDateString();

		//Redis哈希表的命名，如larabbs_last_actived_at_2018-10-21
		// $hash = $this->hash_prefix . $date;
		$hash = $this->getHashFromDateString(Carbon::now()->toDateString());

		//字段名称，如user_1
		// $field = $this->field_prfix . $this->id;
		$field = $this->getHashField();

		//三元运算符，优先选择redis的数据，否则使用数据中
		$datetime = Redis::hGet($hash, $field) ? : $value;

		//存在返回时间对应的Carbon实体
		if ($datetime) {
			return new Carbon($datetime);
		} else {
			//否则用户注册时间
			return $this->created_at;
		}
	}
	public function getHashFromDateString($date)
	{
		//Redis哈希表的命名，如：larabbs_last_actived_at_2018-10-28
		return $this->hash_prefix . $date;
	}
	public function getHashField()
	{
		//字段名称,如user_1
		return $this->field_prefix . $this->id;
	}
}