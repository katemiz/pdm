<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;


use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Mail;
use App\Mail\AppMail;

use App\Models\User;
use App\Models\Attachment;

class PermissionController extends Controller
{
    public function view()
    {
        $permission = Permission::find(request('id'));
        //$attachments = Attachment::where('model_name','EndProduct')->where('model_item_id',request('id'))->get();

        return view('admin.permissions.permission-view',[
            'permission' => $permission,
            'canEdit' => true
        ]);
    }




    public function form()
    {
        $permission = false;

        if (request('id')) {
            $permission = Permission::find(request('id'));
            $action = 'update';
        }

        return view('admin.permissions.permission-form', [
            'permission' => $permission,
        ]);
    }





    public function store(Request $request)
    {
        $id = false;

        $validated = $request->validate([
            'name' => ['required','min:2'],
        ]);

        $props['name'] = $validated['name'];

        if ( isset($request->id) && !empty($request->id)) {
            // update
            Permission::find($request->id)->update($props);
            $permission = Permission::find($request->id);
            $id = $request->id;
        } else {
            // create
            $permission = Permission::create($props);
            $id = $permission->id;
        }

        return redirect('/admin/permissions/view/'.$id);
    }

    public function delete($id) {
        Permission::find($id)->delete();
        session()->flash('message','Permission deleted successfully!!');
        return redirect('/admin/permissions');
    }

}
