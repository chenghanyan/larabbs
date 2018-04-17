<?php

namespace App\Handlers;

class ImageUploadHandler
{
	//只允许以下后缀名的图片文件上传
	protected $allowed_ext = ['png', 'jpg', 'gif', 'jpeg'];

	public function save($file, $folder, $file_prefix)
	{
		//文件夹切割能让查找效率更高uploads/images/avatars/201709/21/
		$folder_name = "uploads/images/$folder/" . date('Ym', time()) . '/' . date('d', time()) . '/';
		// 文件具体存储的物理路径puclic_path() public下的路径
		$upload_path = public_path() . '/' . $folder_name;
		// 获取文件的后缀名，因图片从剪贴板里粘贴时后缀名为空，所以此处确保后缀一直存在
		$extension = strtolower($file->getClientOriginalExtension()) ? :'png' ;
		// 拼接文件名，加前缀是为了增加辨析度，前缀可以是相关数据模型的id如：1_1493521050_7BVc9v9ujP.png
		$filename = $file_prefix . '_' . time() . '_' . str_random(10) . '.' . $extension;
		// 如果上传的不是图片将终止操作
		if (!in_array($extension, $this->allowed_ext)) {
			return false;
		}
		//将图片移动到我们的目标存储路径中
		$file->move($upload_path, $filename);

		return [
			'path' => config('app.url') . "/$folder_name/$filename"
		];
	}
}