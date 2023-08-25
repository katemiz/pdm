<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Mail;
use App\Mail\AppMail;

use App\Models\CR;
use App\Models\User;
use App\Models\Attachment;


class CrController extends Controller
{
    public function view()
    {
        $cr = CR::find(request('id'));

        //$attachments = Attachment::where('model_name','EndProduct')->where('model_item_id',request('id'))->get();


        return view('talep.cr.cr-view',[

            'cr' => $cr,
            'canEdit' => true
        ]);


    }




    public function form()
    {
        $cr = false;

        $available_usr_perms = [];
        $available_usr_roles = [];

        if (request('id')) {

            $cr = CR::find(request('id'));
            $action = 'update';
        }

        return view('talep.cr.cr-form', [
            'cr' => $cr,
        ]);


    }





    public function store(Request $request)
    {
        $id = false;

        $validated = $request->validate([
            'topic' => ['required','min:10'],
            'description' => ['required','min:20'],
        ]);

        $props['user_id'] = Auth::id();
        $props['topic'] = $request->topic;
        $props['description'] = $request->input('description');
        $props['is_for_ecn'] = 0;

        if ($request->input('is_for_ecn')) {
            $props['is_for_ecn'] = 1;
        }

        if ( isset($request->id) && !empty($request->id)) {
            // update
            CR::find($request->id)->update($props);
            $cr = CR::find($request->id);
            $id = $cr->id;
        } else {

            // create
            $cr = CR::create($props);
            $id = $cr->id;
        }

        return redirect('/cr/view/'.$id);
    }


    public function delete($id) {
        User::find($id)->delete();
        session()->flash('message','CR deleted successfully!!');
        return redirect('/cr');
    }




    public function mailUserCreated($props)
    {
        $mData = [
            'from_name' => config('appconstants.app.name'),
            'blade' => 'emails.simple',
            'title' => 'New User Created / Yeni Kullanıcı Hesabı',
            'subject' => 'New User Created / Yeni Kullanıcı Hesabı',
            'greeting' => 'Dear '.$props['name'].' '.$props['lastname'],
            'salute' => 'Best Regards',
            'body' => 'Your account has been created with the following password.',
            'signature' => 'PDM - Product Data management',
            'password' => $props['password']
        ];

        Mail::to($props['email'])->send(new AppMail($mData));

        //dd("Email is sent successfully 2222.");
    }















}
