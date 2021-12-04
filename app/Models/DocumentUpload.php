<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentUpload extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'upload_type', 'id_card_type', 'document_name', 'document_path'];
}
