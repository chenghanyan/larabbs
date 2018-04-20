<?php

namespace App\Models;
class Topic extends Model
{
    protected $fillable = ['title', 'body', 'category_id', 'excerpt', 'slug'];
    /*
    一个话题对应一个分类
     */
    public function category()
    {
    	// return $this->belongsTo(Category::class);//App\Category
    	return $this->belongsTo('App\Models\Category');//App\Category
    }
    /*
    一个话题属于一个作者
     */
    public function user()
    {
    	return $this->belongsTo(User::class);
    	// return $this->belongsTo('App\Models\User');
    }
    /*
    处理排序问题
     */
    public function scopeWithOrder($query, $order)
    {
        //不同的排序，使用不同的数据读取逻辑
        switch ($order) {
            case 'recent':
                $quert = $this->recent($query);
                break;
            default:
                $quert = $this->recentReplied($query);
                break;
        }
        //预加载防止N+1问题
        return $query->with('user', 'category');
    }
    public function scopeRecentReplied($query)
    {
        //有话题回复时，我们将编写逻辑来更新话题模型的reply_count属性
        // 此时会自动触发框架对数据模型updated_at时间戳的更新
        return $query->orderBy('updated_at', 'desc');
    }
    public function scopeRecent($query)
    {
        //按照创建时间排序
        return $query->orderBy('created_at', 'desc');
    }
    public function link($params = [])
    {
        return route('topics.show', array_merge([$this->id, $this->slug], $params));
    }
    /*
    帖子回复
    *一个帖子有很多回复
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
}
