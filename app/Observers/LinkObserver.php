<?php

namespace App\Observers;

use App\Models\Link;
use Cache;

class LinkObserver
{

	public function saved(Link $link)
	{
		//在保存时清空cache_key对应的缓存
		Cache::forget($link->cache_key);
	}
}