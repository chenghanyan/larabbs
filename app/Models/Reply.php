<?php

namespace App\Models;

class Reply extends Model
{
    protected $fillable = [ 'content'];
    /*
    一个回复属于一个话题
     */
    public function topic()
    {
    	return $this->belongsTo(Topic::class);
    }
    /*
    一个回复属于一个用户
     */
    public function user()
    {
    	return $this->belongsTo('\App\Models\User');
    	// return $this->belongsTo(User::class);
    }
}
