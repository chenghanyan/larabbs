<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    /**
     * 更新用户授权方法，不是自己不能更新
     * @Author   chy
     * @DateTime 2018-04-18
     * @param    User       $currentUser [当前用户实例]
     * @param    User       $user        [授权的用户实例]
     * @return   [type]                  [description]
     */
    public function update(User $currentUser, User $user)
    {
        return $currentUser->id === $user->id;
    }

}
