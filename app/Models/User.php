<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;
use Spatie\Permission\Traits\HasRoles;
class User extends Authenticatable
{
    use Traits\ActiveUserHelper;//活跃用户
    use Traits\LastActivedAtHelper;//用户最后登录时间
    use HasRoles;
    use Notifiable {
        notify as protected laravelNotify;
    }

    //Eloquent修改器 修改密码属性
    public function setPasswordAttribute($value)
    {
        //如果值的长度等于60，即认为是已经做过加密的情况
        if (strlen($value) != 60) {
            $value = bcrypt($value); //未加密在此加密
        }
        $this->attributes['password'] = $value;
    }
    public function setAvatarAttribute($path)
    {
        // 如果不是'http',字符串开头，那就是从后台上传的，需要补全ur
         if (!starts_with($path, 'http')) {
            //拼接完整的URL
            $path = config('app.url') . "/uploads/images/avatars/$path";

            $this->attributes['avatar'] = $path;
         }
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
        'name', 'email', 'password', 'introduction', 'avatar', 'phone','weixin_openid','weixin_unionid'
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
