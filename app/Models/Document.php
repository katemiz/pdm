<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;


    protected $table = 'documents';

    protected $fillable = [

        'user_id',
        'updated_uid',
        'document_no',
        'revision',
        'is_latest',
        'doc_type',
        'title',
        'remarks',
        'checker_id',
        'approver_id',
        'reject_reason_check',
        'reject_reason_app',
        'check_reviewed_at',
        'status',
        'nested_height_in',
        'product_weight_kg'
    ];






}
