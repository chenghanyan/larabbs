<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
class UserController extends Controller
{
	/**
	 * 个人中心
	 * @Author   chy
	 * @DateTime 2018-04-17
	 * @param    User       $user [description]
	 * @return   [type]           [description]
	 */
    public function show(User $user)
    {
    	return view('users.show' , compact('user'));
    }
    /**
     * [edit description]
     * @Author   chy
     * @DateTime 2018-04-17
     * @param    [type]
     * @param    User       $user [description]
     * @return   [type]           [description]
     */
    public function edit(User $user)
    {
    	return view('users.edit', compact('user'));
    }
    /**
     * 更新操作
     * @Author   chy
     * @DateTime 2018-04-17
     * @param    [type]     $user [description]
     * @return   [type]           [description]
     */
    public function update(UserRequest $request , User $user)
    {
    	$user->update($request->all());
    	return redirect()->route('users.show' , $user->id)->with('success' , '个资料更新成功');
    }
}
