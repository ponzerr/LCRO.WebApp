<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DcertFile extends Model
{
    use HasFactory;
    protected $fillable = [
        'dcert_file_registry_no',
        'dcert_file_death_name',
        'dcert_file_date_of_death',
        'dcert_file_attach_document',
        'dcert_file_path'
    ];
}
