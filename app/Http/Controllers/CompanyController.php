<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;



use Mail;
use App\Mail\AppMail;

use App\Models\User;
use App\Models\Company;

class CompanyController extends Controller
{
    public function view()
    {
        $company = Company::find(request('id'));
        //$attachments = Attachment::where('model_name','EndProduct')->where('model_item_id',request('id'))->get();

        return view('admin.companies.company-view',[
            'company' => $company,
            'canEdit' => true
        ]);
    }




    public function form()
    {
        $company = false;

        if (request('id')) {
            $company = Company::find(request('id'));
            $action = 'update';
        }

        return view('admin.companies.company-form', [
            'company' => $company,
        ]);
    }





    public function store(Request $request)
    {
        $id = false;

        $validated = $request->validate([
            'shortname' => ['required','min:2'],
        ]);

        $props['shortname'] = $validated['shortname'];

        if ( isset($request->id) && !empty($request->id)) {
            // update
            Company::find($request->id)->update($props);
            $company = Company::find($request->id);
            $id = $request->id;
        } else {
            // create
            $company = Company::create($props);
            $id = $company->id;
        }

        return redirect('/admin/companies/view/'.$id);
    }

    public function delete($id) {
        Company::find($id)->delete();
        session()->flash('message','Company deleted successfully!!');
        return redirect('/admin/companies');
    }

}
