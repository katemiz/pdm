<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Mail;
use App\Mail\AppMail;

use App\Models\CRequest;
use App\Models\User;
use App\Models\Attachment;


class CrController extends Controller
{
    public function view()
    {
        $cr = CRequest::find(request('id'));

        //$attachments = Attachment::where('model_name','EndProduct')->where('model_item_id',request('id'))->get();


        return view('talep.cr.cr-view',[

            'cr' => $cr,
            'canEdit' => true
        ]);


    }




    public function form()
    {
        $cr = false;
        $approver = false;

        if (request('id')) {
            $cr = CRequest::find(request('id'));
            $action = 'update';
        }

        // Does user have CR Approver permission?
        if ( Auth::user()->can('cr_approver') ) {
            $approver = Auth::user();
        } else {
            $cr_approvers = User::permission('cr_approver')->get();
            if ($cr_approvers->count() == 1 ) {
                $approver = $cr_approvers['0'];
            }
        }

        // dd($cr_approvers);

        return view('talep.cr.cr-form', [
            'cr' => $cr,
            'cr_approvers' => $cr_approvers,
            'cr_approver' => $approver
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

        $props['req_app_id'] = $request->input('cr_approver');


        if ($request->input('is_for_ecn')) {
            $props['is_for_ecn'] = 1;
        }

        if ( isset($request->id) && !empty($request->id)) {
            // update
            CRequest::find($request->id)->update($props);
            $cr = CRequest::find($request->id);
            $id = $cr->id;
        } else {

            // create
            $cr = CRequest::create($props);
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
