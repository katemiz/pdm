<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

use App\Models\User;

class Document extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $table = 'documents';

    protected $fillable = [
        'user_id',
        'company_id',
        'updated_uid',
        'document_no',
        'revision',
        'is_html',
        'is_latest',
        'doc_type',
        'language',
        'title',
        'remarks',
        'toc',
        'checker_id',
        'approver_id',
        'reject_reason_check',
        'reject_reason_app',
        'check_reviewed_at',
        'status',
        'updated_at'
    ];

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


    public static function getTableModel() {

        return  [

            'id' => [
                'label' => 'No',
                'visibility' => false,
                'sortable' => false,
                'hasViewLink' => false,
            ],

            'user_id' => [
                'label' => 'Prepared By',
                'visibility' => false,
                'sortable' => false,
                'hasViewLink' => false,
            ],


            'DocNo' => [
                'label' => 'Document No',
                'visibility' => true,
                'sortable' => true,
                'hasViewLink' => true,
            ],

            'company_id' => [
                'label' => 'Company',
                'visibility' => false,
                'sortable' => false,
                'hasViewLink' => false,
            ],

            'title' => [
                'label' => 'Title',
                'visibility' => true,
                'sortable' => true,
                'hasViewLink' => false,
            ],


            'Author' => [
                'label' => 'Author',
                'visibility' => true,
                'sortable' => true,
                'hasViewLink' => false,
            ],

            'created_at' => [
                'label' => 'Created At',
                'visibility' => true,
                'sortable' => true,
                'hasViewLink' => false,
            ],

            'updated_at' => [
                'label' => 'Updated At',
                'visibility' => false,
                'sortable' => false,
                'hasViewLink' => false,
            ],

        ];
    }







}
