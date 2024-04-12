<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Projectuser;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected function _comments($post_id)
    {
        $perPage = 25;
        // ->with('user:id,name')
        $comments = Comment::where('post_id', '=', $post_id)->latest()->paginate($perPage);
        return $comments;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $posts = Post::where('title', 'LIKE', "%$keyword%")
                ->orWhere('content', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $posts = Post::latest()->paginate($perPage);
        }
        return view('home.posts.index', compact('posts'));
    }

    public function todo(Request $request, $project_id){
        if(!hasAccess($project_id, 0, 'posts_view')){
            return redirect('projects')->with('flash_message', 'You can not op this project!');
        }
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $posts = Post::where('type','bug')->where('project_id', $project_id)->where('title', 'LIKE', "%$keyword%")
                ->orWhere('content', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $posts = Post::where('type','todo')->where('project_id', $project_id)->latest()->paginate($perPage);
        }
        $type = 'todo';
        return view('home.posts.index', compact('posts','type','project_id'));
    }

    public function bug(Request $request, $project_id){
        if(!hasAccess($project_id, 0, 'posts_view')){
            return redirect('projects')->with('flash_message', 'You can not op this project!');
        }
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $posts = Post::where('type','bug')->where('project_id', $project_id)->where('title', 'LIKE', "%$keyword%")
                ->orWhere('content', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $posts = Post::where('type','bug')->where('project_id', $project_id)->latest()->paginate($perPage);
        }
        $type = 'bug';
        return view('home.posts.index', compact('posts','type','project_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        $type = $request->get('type');
        $type = $type == "todo" ? "todo" : "bug";
        return view('home.posts.create', compact('type'));
    }
    
    public function createtodo(Request $request, $project_id)
    {
        if(!hasAccess($project_id, 0, 'posts_createtodo')){
            return redirect('projects')->with('flash_message', 'You can not op this project!');
        }
        $projectusers = Projectuser::where('project_id',$project_id)->get();
        $type = 'todo';
        return view('home.posts.create', compact('type', 'project_id','projectusers'));
    }
    
    public function createbug(Request $request, $project_id)
    {
        if(!hasAccess($project_id, 0, 'posts_createbug')){
            return redirect('projects')->with('flash_message', 'You can not op this project!');
        }
        $projectusers = Projectuser::where('project_id',$project_id)->get();
        $type = 'bug';
        return view('home.posts.create', compact('type', 'project_id','projectusers'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $type = 'todo' ? 'todo' : 'bug';
        $requestData = $request->all();
        if($type == 'todo' && !hasAccess($requestData['project_id'], 0, 'posts_createtodo')){
            return redirect('projects')->with('flash_message', 'You can not op this project!');
        }
        if($type == 'bug' && !hasAccess($requestData['project_id'], 0, 'posts_createbug')){
            return redirect('projects')->with('flash_message', 'You can not op this project!');
        }
        $this->validate($request, [
			'title' => 'required|max:50'
		]);
        $requestData['type'] = $requestData['type'] == 'todo' ? 'todo' : 'bug';
        $requestData['user_id'] = auth()->user()->id;
        
        Post::create($requestData);
        if($requestData['type'] == 'todo'){
            return redirect('posts/todo/' . $requestData['project_id'])->with('flash_message', 'Post added!');
        }
        return redirect('posts/bug/' . $requestData['project_id'])->with('flash_message', 'Post added!');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        if(!hasAccess(0, $id, 'posts_view')){
            return redirect('projects')->with('flash_message', 'You can not op this project!');
        }
        $post = Post::findOrFail($id);

        $projectusers = Projectuser::where('project_id',$post['project_id'])->get();
        $comments = $this->_comments($id);
        return view('home.posts.show', compact('post','comments','projectusers'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        if(!hasAccess(0, $id, 'posts_op')){
            return redirect('projects')->with('flash_message', 'You can not op this project!');
        }
        $post = Post::findOrFail($id);

        $type = $post['type'];
        $project_id = $post['project_id'];
        $projectusers = Projectuser::where('project_id',$project_id)->get();

        return view('home.posts.edit', compact('post','type','project_id','projectusers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        if(!hasAccess(0, $id, 'posts_op')){
            return redirect('projects')->with('flash_message', 'You can not op this project!');
        }
        $this->validate($request, [
			'title' => 'required|max:10'
		]);
        $requestData = $request->all();
        
        $post = Post::findOrFail($id);

        $post->update($requestData);
        if($requestData['type'] == 'todo'){
            return redirect('posts/todo/'.$post['project_id'])->with('flash_message', 'Post added!');
        }
        return redirect('posts/bug/'.$post['project_id'])->with('flash_message', 'Post updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        if(!hasAccess(0, $id, 'posts_del')){
            return redirect('projects')->with('flash_message', 'You can not op this project!');
        }
        $post = Post::findOrFail($id);
        Post::destroy($id);

        return redirect('posts')->with('flash_message', 'Post deleted!');
    }
}
