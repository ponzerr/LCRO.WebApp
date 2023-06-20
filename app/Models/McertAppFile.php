<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class McertAppFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'mcert_app_file_registry_no',
        'mcert_app_file_groom_name',
        'mcert_app_file_bride_name',
        'mcert_app_file_attach_document',
        'mcert_app_file_path'
    ];
}
