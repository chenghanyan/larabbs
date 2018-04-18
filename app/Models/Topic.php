<?php

namespace App\Models;

class Topic extends Model
{
    protected $fillable = ['title', 'body', 'user_id', 'category_id', 'reply_count', 'view_count', 'last_reply_user_id', 'order', 'excerpt', 'slug'];
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
}
