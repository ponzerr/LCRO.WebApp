<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class McertFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'mcert_file_registry_no',
        'mcert_file_groom_name',
        'mcert_file_bride_name',
        'mcert_file_date_of_marriage',
        'mcert_file_attach_document',
        'mcert_file_path'
    ];
}
