<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;
class User extends Authenticatable
{
    use Notifiable {
        notify as protected laravelNotify;
    }
    public function notify($instance)
    {
        // 如果要通知的人是当前用户，就不必通知了！
        if ($this->id == Auth::id()) {
            return;
        }
        $this->increment('notification_count');
        $this->laravelNotify($instance);
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'introduction', 'avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    /*
    一个用对应多个话题
     */
    public function topics()
    {
        return $this->hasMany(Topic::class);
    }
    /*
    授权操作
     */
    public function isAuthorOf($model)
    {
        return $this->id == $model->user_id;
    }
    /*
    一个用户有很多回复 一对多
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
    /**
     * 清楚消息
     */
    public function markAsRead()
    {
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }

}
