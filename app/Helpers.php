<?php
use App\Models\Post;
use App\Models\Projectuser;
function hasAccess($project_id, $post_id, $op){
    $user_id = auth()->user()->id;
    if($project_id == 0){
        $post = Post::findOrFail($post_id);
        $project_id = $post['project_id'];
    }
    if($op == 'projects_view'){
        $data = Projectuser::where('user_id', $user_id)->where('project_id', $project_id)->whereIn('role',['owner','manager','tester','developer'])->count();
        if($data != 0){
            return true;
        }
    }
    // edit / operate tester/developer/manager
    if($op == 'projects_op'){
        $data = Projectuser::where('user_id', $user_id)->where('project_id', $project_id)->whereIn('role',['owner','manager'])->count();
        if($data != 0){
            return true;
        }
    }
    if($op == 'projects_del'){
        $data = Projectuser::where('user_id', $user_id)->where('project_id', $project_id)->whereIn('role',['owner'])->count();
        if($data != 0){
            return true;
        }
    }

    if($op == 'posts_createtodo'){
        $data = Projectuser::where('user_id', $user_id)->where('project_id', $project_id)->whereIn('role',['owner','manager'])->count();
        if($data != 0){
            return true;
        }
    }
    if($op == 'posts_createbug'){
        $data = Projectuser::where('user_id', $user_id)->where('project_id', $project_id)->whereIn('role',['owner','manager','tester'])->count();
        if($data != 0){
            return true;
        }
    }
    if($op == 'posts_view'){
        $data = Projectuser::where('user_id', $user_id)->where('project_id', $project_id)->whereIn('role',['owner','manager','tester','developer'])->count();
        if($data != 0){
            return true;
        }
    }

    if($op == 'posts_op'){
        $data = Projectuser::where('user_id', $user_id)->where('project_id', $project_id)->whereIn('role',['owner','manager'])->count();
        if($data != 0){
            return true;
        }
    }

    if($op == 'posts_del'){
        $data = Projectuser::where('user_id', $user_id)->where('project_id', $project_id)->whereIn('role',['owner','manager'])->count();
        if($data != 0){
            return true;
        }
    }

    if($op == 'posts_comment'){
        $data = Projectuser::where('user_id', $user_id)->where('project_id', $project_id)->whereIn('role',['owner','manager'])->count();
        if($data != 0){
            return true;
        }
        $data = Post::where('id', $post_id)->where('user_id_on', $user_id)->count();
        if($data != 0){
            return true;
        }
    }
    return false;
}