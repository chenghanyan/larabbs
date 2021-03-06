<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use App\Models\Category;
use App\Models\Link;
use Auth;
class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index(Request $request, Topic $topic, User $user, Link $link)
	{
		//方法 with() 提前加载了我们后面需要用到的关联属性 user 和 category，并做了缓存后面即使是在遍历数据时使用到这两个关联属性，数据已经被预加载并缓存，因此不会再产生多余的 SQL 查询
		$topics = Topic::withOrder($request->order)->paginate(20);
		// $topics = Topic::paginate(30);//不可取
		$active_users = $user->getActiveUsers();
		$links = $link->getAllCached();
		// dd($active_users);
		return view('topics.index', compact('topics', 'active_users','links'));
	}

    public function show(Request $request, Topic $topic)
    {
    	 // URL 矫正
    	if ( ! empty($topic->slug) && $topic->slug != $request->slug) {
            return redirect($topic->link(), 301);
        }
        $replies = $topic->replies;
        $user = $topic->user;
        return view('topics.show', compact('topic','replies', 'user'));
    }

	public function create(Topic $topic)
	{
		$categories = Category::all();
		return view('topics.create_and_edit', compact('topic', 'categories'));
	}

	public function store(TopicRequest $request, Topic $topic)
	{
		$topic->fill($request->all());
		//XSS攻击防止
		// $topic->body = clean($topic->body, 'user_topic_body');
		$topic->user_id = Auth::id();
		$topic->save();
		// return redirect()->route('topics.show', $topic->id)->with('message', '成功创建主题！');
		return redirect()->to($topic->link())->with('success', '成功创建话题！');
	}

	public function edit(Topic $topic)
	{
        $this->authorize('update', $topic);
        $categories = Category::all();
		return view('topics.create_and_edit', compact('topic','categories'));
	}

	public function update(TopicRequest $request, Topic $topic)
	{
		$this->authorize('update', $topic);
		$topic->update($request->all());

		return redirect()->to($topic->link())->with('message', '更新成功！');
	}

	public function destroy(Topic $topic)
	{
		$this->authorize('destroy', $topic);
		$topic->delete();

		return redirect()->route('topics.index')->with('message', '成功删除！');
	}
	public function uploadImage(Request $request, ImageUploadHandler $uploader)
	{
		//初始化返回数据，默认是失败的
		$data = [
			'success' => false,
			'msg' => '上传失败!',
			'file_path' => ''
		];
		//判断是否有上传文件，并赋值给$file
		if($file = $request->upload_file) {
			//保存图片到本地
			$result = $uploader->save($request->upload_file, 'topics', \Auth::id(), 1024);
			if($result) {
				$data['file_path'] = $result['path'];
				$data['msg'] = '上传成功!';
				$data['success'] = trie;
			}
		}
		return $data;
	}
}