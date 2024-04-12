<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Project;
use App\Models\Projectuser;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Closure;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;
        $project_ids = Projectuser::where('user_id', auth()->user()->id)->select(['project_id'])->get()->toArray();
        $project_ids = array_column($project_ids, 'project_id');
        $projects = Project::whereIn('id', $project_ids)->latest()->paginate($perPage);
        return view('home.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $total = Projectuser::where('user_id', auth()->user()->id)->select(['project_id'])->count();
        if($total > 100){
            return redirect('projects')->with('flash_message', 'Project max 100!');
        }
        return view('home.projects.create');
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
        $this->validate($request, [
			'title' => 'required|max:50'
		]);
        $requestData = $request->all();
        $requestData['user_id'] = auth()->user()->id;
        $data = Project::create($requestData);
        Projectuser::create(['user_id'=>$requestData['user_id'], 'project_id'=>$data->id,'role'=>'owner']);

        return redirect('projects')->with('flash_message', 'Project added!');
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
        if(!hasAccess($id, 0, 'projects_view')){
            return redirect('projects')->with('flash_message', 'You can not op this project!');
        }

        $project = Project::findOrFail($id);
        $testers = Projectuser::where('project_id', $id)->where('role','tester')->get();
        $developers = Projectuser::where('project_id', $id)->where('role','developer')->get();
        $managers = Projectuser::where('project_id', $id)->where('role','manager')->get();

        return view('home.projects.show', compact('project', 'testers', 'developers', 'managers'));
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
        if(!hasAccess($id, 0, 'projects_op')){
            return redirect('projects')->with('flash_message', 'You can not op this project!');
        }

        $project = Project::findOrFail($id);

        return view('home.projects.edit', compact('project'));
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
        if(!hasAccess($id, 0, 'projects_op')){
            return redirect('projects')->with('flash_message', 'You can not op this project!');
        }
        $this->validate($request, [
			'title' => 'required|max:50'
		]);
        $requestData = $request->all();
        
        $project = Project::findOrFail($id);
        $project->update($requestData);

        return redirect('projects')->with('flash_message', 'Project updated!');
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
        if(!hasAccess($id, 0, 'projects_del')){
            return redirect('projects')->with('flash_message', 'You can not op this project!');
        }
        Project::destroy($id);
        Projectuser::where('project_id', $id)->delete();
        return redirect('projects')->with('flash_message', 'Project deleted!');
    }

    public function adduser(Request $request){
        $user = User::where('name', $request->get('name'))->first();
        $user_id = $user ? $user->id : 0;
        $this->validate($request, [
			'name' => [
                'required',
                Rule::exists('users', 'name'),
                function (string $attribute, mixed $value, Closure $fail) use ($request) {
                    $d = User::join('projectusers', 'projectusers.user_id','=','users.id')->where('users.name', $value)->where('projectusers.project_id',$request->get('project_id'))->first();
                    if ($d) {
                        $fail("The {$attribute} has in this project.");
                    }
                },
            ]
		],[
            'name.exists'  => '没有对应的用户信息',
        ]);
        $project_id = $request->get('project_id');
        if(!hasAccess($project_id, 0, 'projects_op')){
            return redirect('projects')->with('flash_message', 'You can not op this project!');
        }

        Projectuser::create(['user_id'=>$user['id'], 'project_id'=>$project_id,'role'=>$request->get('role')]);

        return redirect('projects/'.$project_id)->with('flash_message', 'Project added!');
    }

    public function deluser($id)
    {
        $projectuser = Projectuser::findOrFail($id);
        if(!hasAccess($projectuser['project_id'], 0, 'projects_op')){
            return redirect('projects')->with('flash_message', 'You can not op this project!');
        }
        Projectuser::destroy($id);

        return redirect('projects/'.$projectuser['project_id'])->with('flash_message', 'Project deleted!');
    }

    public function changeuser($id, $role){
        $projectuser = Projectuser::findOrFail($id);
        if(!hasAccess($projectuser['project_id'], 0, 'projects_op')){
            return redirect('projects')->with('flash_message', 'You can not op this project!');
        }
        $projectuser->update(['role'=>$role]);
        return redirect('projects/'.$projectuser['project_id'])->with('flash_message', 'Project deleted!');
    }
}
