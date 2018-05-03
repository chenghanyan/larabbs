<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Image extends Model
{
    protected $fillable = ['type', 'path'];

    /*
     *	图片属于某个用户
     */
    public function user()
    {
    	return $this->belongTo(User::class);
    }
}
