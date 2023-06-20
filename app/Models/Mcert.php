<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mcert extends Model
{
    use HasFactory;

    protected $fillable = [
        'mcert_registry_no', //number
        'mcert_province',
        'mcert_municipality',
        'mcert_received_by',
        'mcert_date_of_receipt', //date
        'mcert_marriage_license_no', //integer
        'mcert_date_of_issuance', //date
        // new input 
        // groom details
        'mcert_g_first_name',
        'mcert_g_middle_name',
        'mcert_g_last_name',
        'mcert_g_date_of_birth', //date
        'mcert_g_age', //integer
        'mcert_g_place_of_birth_city',
        'mcert_g_place_of_birth_province',
        'mcert_g_place_of_birth_country',
        'mcert_g_sex',
        'mcert_g_citizenship',
        'mcert_g_residence',
        'mcert_g_religion',
        'mcert_g_civil_status', //dropdown
        // if groom marriage dissolved
        'mcert_g_marriage_dissolved',
        'mcert_g_marriage_dissolved_place_city',
        'mcert_g_marriage_dissolved_place_province',
        'mcert_g_marriage_dissolved_place_country',
        'mcert_g_marriage_dissolved_date',
        'mcert_g_marriage_dissolved_relationship',
        // groom father
        'mcert_g_fathers_first_name',
        'mcert_g_fathers_middle_name',
        'mcert_g_fathers_last_name',
        'mcert_g_fathers_citizenship',
        'mcert_g_fathers_residence',
        // groom mother
        'mcert_g_mothers_first_name',
        'mcert_g_mothers_middle_name',
        'mcert_g_mothers_last_name',
        'mcert_g_mothers_citizenship',
        'mcert_g_mothers_residence',
        // person who gave consent
        'mcert_g_consent_given_by',
        'mcert_g_consent_given_relationship',
        'mcert_g_consent_given_citizenship',
        'mcert_g_consent_given_residence',

        // bride details
        'mcert_b_first_name',
        'mcert_b_middle_name',
        'mcert_b_last_name',
        'mcert_b_date_of_birth',
        'mcert_b_age',
        'mcert_b_place_of_birth_city',
        'mcert_b_place_of_birth_province',
        'mcert_b_place_of_birth_country',
        'mcert_b_sex',
        'mcert_b_citizenship',
        'mcert_b_residence',
        'mcert_b_religion',
        'mcert_b_civil_status',
        // if bride marriage dissolved
        'mcert_b_marriage_dissolved',
        'mcert_b_marriage_dissolved_place_city',
        'mcert_b_marriage_dissolved_place_province',
        'mcert_b_marriage_dissolved_place_country',
        'mcert_b_marriage_dissolved_date',
        'mcert_b_marriage_dissolved_relationship',
        // bride father
        'mcert_b_fathers_first_name',
        'mcert_b_fathers_middle_name',
        'mcert_b_fathers_last_name',
        'mcert_b_fathers_citizenship',
        'mcert_b_fathers_residence',
        // bride mother
        'mcert_b_mothers_first_name',
        'mcert_b_mothers_middle_name',
        'mcert_b_mothers_last_name',
        'mcert_b_mothers_citizenship',
        'mcert_b_mothers_residence',
        // person who gave consent
        'mcert_b_consent_given_by',
        'mcert_b_consent_given_relationship',
        'mcert_b_consent_given_citizenship',
        'mcert_b_consent_given_residence',
        'mcert_status'

    ];

    public function approve()
    {
        $this->mcert_status = true;
        $this->save();
    }

    public function unapprove()
    {
        $this->mcert_status = false;
        $this->save();
    }
}
