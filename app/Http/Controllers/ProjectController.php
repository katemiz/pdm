<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;



use Mail;
use App\Mail\AppMail;

use App\Models\User;
use App\Models\Project;

class ProjectController extends Controller
{
    public function view()
    {
        $project = Project::find(request('id'));
        //$attachments = Attachment::where('model_name','EndProduct')->where('model_item_id',request('id'))->get();

        return view('admin.projects.project-view',[
            'project' => $project,
            'canEdit' => true
        ]);
    }




    public function form()
    {
        $project = false;

        if (request('id')) {
            $project = Project::find(request('id'));
            $action = 'update';
        }

        return view('admin.projects.project-form', [
            'project' => $project,
        ]);
    }





    public function store(Request $request)
    {
        $id = false;

        $validated = $request->validate([
            'shortname' => ['required','min:2'],
            'fullname' => ['required','min:10'],

        ]);

        $props['shortname'] = $validated['shortname'];
        $props['fullname'] = $validated['fullname'];
        $props['remarks'] = $request->input('remarks');


        if ( isset($request->id) && !empty($request->id)) {
            // update
            Project::find($request->id)->update($props);
            $project = Project::find($request->id);
            $id = $request->id;
        } else {
            // create
            $project = Project::create($props);
            $id = $project->id;
        }

        return redirect('/admin/projects/view/'.$id);
    }

    public function delete($id) {
        Project::find($id)->delete();
        session()->flash('message','Project deleted successfully!!');
        return redirect('/admin/projects');
    }

}
