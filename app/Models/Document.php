<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Document extends Model
{
    use HasFactory;


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
        'nested_height_in',
        'product_weight_kg'
    ];




    public function getAuthorAttribute($value) {
        $author = User::find($this->user_id);
        return $author->name.' '.strtoupper($author->lastname);
    }

    public function getDocNoAttribute($value) {
        return 'D'.$this->document_no.' R'.$this->revision;
    }





    public static function getTableModel() {

        return  [

            'id' => [
                'label' => 'No',
                'visibility' => true,
                'sortable' => false,
                'hasViewLink' => true,
            ],

            'user_id' => [
                'label' => 'Prepared By',
                'visibility' => false,
                'sortable' => false,
                'hasViewLink' => false,
            ],

            'company_id' => [
                'label' => 'Company',
                'visibility' => false,
                'sortable' => false,
                'hasViewLink' => false,
            ],

            'document_no' => [
                'label' => 'Document No',
                'visibility' => true,
                'sortable' => true,
                'hasViewLink' => false,
            ],

            'title' => [
                'label' => 'Title',
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
