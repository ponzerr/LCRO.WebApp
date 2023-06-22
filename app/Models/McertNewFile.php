<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class McertNewFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'mcert_new_file_registry_no',
        'mcert_new_file_groom_name',
        'mcert_new_file_bride_name',
        'mcert_new_file_date_of_marriage',
        'mcert_new_file_attach_document',
        'mcert_new_file_path'
    ];
}
