<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\User;

class UserController extends Controller
{
    public function view()
    {
        $ep = EndProduct::find(request('id'));

        $attachments = Attachment::where('model_name','EndProduct')->where('model_item_id',request('id'))->get(); 


        return view('end_product.ep-view',[

            'ep' => $ep,
            'attachments' => $attachments,
            'canEdit' => true

        ]);


    }




    public function form()
    {
        $user = false;

        $available_usr_perms = [];
        $available_usr_roles = [];

        if (request('id')) {

            $user = User::find(request('id'));
            $action = 'update';

            foreach ($user->roles as $role) {
                $available_usr_roles[] = $role->id;
            }

            foreach ($user->permissions as $perm) {
                $available_usr_perms[] = $perm->id;
            }
        }

        return view('admin.users.usr-form', [
            'user' => $user,
            'roles' => Role::all()->sortBy('name'),
            'permissions' => Permission::all()->sortBy('name'),
            'available_usr_perms' => $available_usr_perms,
            'available_usr_roles' => $available_usr_roles,
        ]);


    }





    public function store(Request $request)
    {
        $id = false;

        if ( isset($request->id) && !empty($request->id)) {

            $validated = $request->validate([
                'name' => ['required|min:2'],
                'lastname' => ['required|min:2'],
                'email' => ['required|email'],
            ]);

            // $props['user_id'] = Auth::id();
            $props['name'] = $request->name;
            $props['lastname'] = $request->lastname;
            $props['email'] = $request->email;

            // update
            User::find($request->id)->update($props);
            $user = User::find($request->id);
            $id = $request->id;
        } else {

            $validated = $request->validate([
                'name' => ['required'],
                'lastname' => ['required'],
                'email' => ['required|email', 'unique:users'],
            ]);

            // $props['user_id'] = Auth::id();
            $props['name'] = $request->name;
            $props['lastname'] = $request->lastname;
            $props['email'] = $request->email;

            // create
            $user = User::create($props);
            $id = $user->id;
        }

        // ROLES
        $roles = Role::all()->sortBy('name');
        $selected_roles = [];

        foreach ($roles as $role) {

            $degisken = 'role'.$role->id;

            if (request($degisken)) {
                $selected_roles[] = Role::find($role->id);
            }
        }

        $user->syncRoles($selected_roles);

        // USER PERMISSIONS
        $permissions = Permission::all()->sortBy('name');
        $selected_perms = [];

        foreach ($permissions as $permission) {

            $degisken = 'perm'.$permission->id;

            if (request($degisken)) {
                $selected_perms[] = Permission::find($permission->id);
            }
        }

        $user->syncPermissions($selected_perms);

        return redirect('/admin/users/view/'.$id);
    }






    public function getProductNo() {

        $counter = Counter::find(1111);
        $new_no = $counter->product_no+1;
        $counter->update(['product_no' => $new_no]);         // Update Counter

        return $new_no;
    }



}
