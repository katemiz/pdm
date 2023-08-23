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

class RoleController extends Controller
{
    public function view()
    {
        $role = Role::find(request('id'));
        //$attachments = Attachment::where('model_name','EndProduct')->where('model_item_id',request('id'))->get();

        return view('admin.roles.role-view',[
            'role' => $role,
            'canEdit' => true
        ]);
    }




    public function form()
    {
        $role = false;

        $available_usr_perms = [];
        $available_usr_roles = [];

        if (request('id')) {
            $role = Role::find(request('id'));
            $action = 'update';
        }

        return view('admin.roles.role-form', [
            'role' => $role,
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
            Role::find($request->id)->update($props);
            $role = Role::find($request->id);
            $id = $request->id;
        } else {
            // create
            $role = Role::create($props);
            $id = $role->id;
        }

        return redirect('/admin/roles/view/'.$id);
    }






    // public function getProductNo() {

    //     $counter = Counter::find(1111);
    //     $new_no = $counter->product_no+1;
    //     $counter->update(['product_no' => $new_no]);         // Update Counter

    //     return $new_no;
    // }

    public function delete($id) {
        Role::find($id)->delete();
        session()->flash('message','Role deleted successfully!!');
        return redirect('/admin/roles');
    }

}
