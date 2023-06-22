<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BcertFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'bcert_file_registry_no',
        'bcert_file_birth_name',
        'bcert_file_date_of_birth',
        'bcert_file_attach_document',
        'bcert_file_path'
    ];
}
