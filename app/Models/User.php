<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

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

}
