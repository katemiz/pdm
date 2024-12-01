<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

use App\Models\User;
use App\Models\Company;


class Document extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $table = 'documents';

    protected $guarded = [];

    public function getAuthorAttribute($value) {
        $author = User::find($this->user_id);
        return $author->name.' '.strtoupper($author->lastname);
    }


    public function getDocNoAttribute($value) {
        return 'D'.$this->document_no.' R'.$this->revision;
    }


    public function getRevisionsAttribute($value) {
        //return Document::select('id','revision')->where('document_no',$this->document_no)->order_by('revision', 'ASC');
        return Document::select('id','revision')->where('document_no',$this->document_no)->get()->toArray();
    }

    public function getCompanyNameAttribute($value) {
        $comp = Company::find($this->company_id);
        return $comp->name;
    }

}
