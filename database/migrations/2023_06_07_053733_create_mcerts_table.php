<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mcerts', function (Blueprint $table) {
            $table->id();
            $table->text('mcert_registry_no')->nullable();
            $table->text('mcert_province')->nullable();
            $table->text('mcert_municipality')->nullable();
            $table->text('mcert_received_by')->nullable();
            $table->date('mcert_date_of_receipt')->nullable();
            $table->integer('mcert_marriage_license_no')->nullable();
            $table->date('mcert_date_of_issuance')->nullable();
            // groom details
            $table->text('mcert_g_first_name')->nullable();
            $table->text('mcert_g_middle_name')->nullable();
            $table->text('mcert_g_last_name')->nullable();
            $table->date('mcert_g_date_of_birth')->nullable();
            $table->integer('mcert_g_age')->nullable();
            $table->text('mcert_g_place_of_birth_city')->nullable();
            $table->text( 'mcert_g_place_of_birth_province')->nullable();
            $table->text('mcert_g_place_of_birth_country')->nullable();
            $table->text('mcert_g_sex')->nullable();
            $table->text('mcert_g_residence')->nullable();
            $table->text('mcert_g_citizenship')->nullable();
            $table->text('mcert_g_religion')->nullable();
            $table->text('mcert_g_civil_status')->nullable();
            // if groom marriage dissolved
            $table->text('mcert_g_marriage_dissolved')->nullable();
            $table->text('mcert_g_marriage_dissolved_place_city')->nullable();
            $table->text('mcert_g_marriage_dissolved_place_province')->nullable();
            $table->text('mcert_g_marriage_dissolved_place_country')->nullable();
            $table->text('mcert_g_marriage_dissolved_date')->nullable();
            $table->text('mcert_g_marriage_dissolved_relationship')->nullable();
            // groom father
            $table->text('mcert_g_fathers_first_name')->nullable();
            $table->text('mcert_g_fathers_middle_name')->nullable();
            $table->text('mcert_g_fathers_last_name')->nullable();
            $table->text('mcert_g_fathers_citizenship')->nullable();
            $table->text('mcert_g_fathers_residence')->nullable();
            // groom mother
            $table->text('mcert_g_mothers_first_name')->nullable();
            $table->text('mcert_g_mothers_middle_name')->nullable();
            $table->text('mcert_g_mothers_last_name')->nullable();
            $table->text('mcert_g_mothers_citizenship')->nullable();
            $table->text('mcert_g_mothers_residence')->nullable();
            // person who gave consent
            $table->text('mcert_g_consent_given_by')->nullable();
            $table->text('mcert_g_consent_given_relationship')->nullable();
            $table->text('mcert_g_consent_given_citizenship')->nullable();
            $table->text('mcert_g_consent_given_residence')->nullable();

            // bride details
            $table->text('mcert_b_first_name')->nullable();
            $table->text('mcert_b_middle_name')->nullable();
            $table->text('mcert_b_last_name')->nullable();
            $table->date('mcert_b_date_of_birth')->nullable();
            $table->integer('mcert_b_age')->nullable();
            $table->text('mcert_b_place_of_birth_city')->nullable();
            $table->text( 'mcert_b_place_of_birth_province')->nullable();
            $table->text('mcert_b_place_of_birth_country')->nullable();
            $table->text('mcert_b_sex')->nullable();
            $table->text('mcert_b_residence')->nullable();
            $table->text('mcert_b_citizenship')->nullable();
            $table->text('mcert_b_religion')->nullable();
            $table->text('mcert_b_civil_status')->nullable();
            // if bride marriage dissolved
            $table->text('mcert_b_marriage_dissolved')->nullable();
            $table->text('mcert_b_marriage_dissolved_place_city')->nullable();
            $table->text('mcert_b_marriage_dissolved_place_province')->nullable();
            $table->text('mcert_b_marriage_dissolved_place_country')->nullable();
            $table->date('mcert_b_marriage_dissolved_date')->nullable();
            $table->text('mcert_b_marriage_dissolved_relationship')->nullable();
            // bride father
            $table->text('mcert_b_fathers_first_name')->nullable();
            $table->text('mcert_b_fathers_middle_name')->nullable();
            $table->text('mcert_b_fathers_last_name')->nullable();
            $table->text('mcert_b_fathers_citizenship')->nullable();
            $table->text('mcert_b_fathers_residence')->nullable();
            // bride mother
            $table->text('mcert_b_mothers_first_name')->nullable();
            $table->text('mcert_b_mothers_middle_name')->nullable();
            $table->text('mcert_b_mothers_last_name')->nullable();
            $table->text('mcert_b_mothers_citizenship')->nullable();
            $table->text('mcert_b_mothers_residence')->nullable();
            // person who gave consent
            $table->text('mcert_b_consent_given_by')->nullable();
            $table->text('mcert_b_consent_given_relationship')->nullable();
            $table->text('mcert_b_consent_given_citizenship')->nullable();
            $table->text('mcert_b_consent_given_residence')->nullable();
            // Subscribed and sworn
            $table->text('mcert_subscribed_blank1')->nullable();
            $table->text('mcert_subscribed_blank2')->nullable();
            $table->text('mcert_subscribed_blank3')->nullable();
            $table->text('mcert_subscribed_blank4')->nullable();
            $table->text('mcert_subscribed_blank5')->nullable();
            $table->text('mcert_subscribed_blank6')->nullable();
            $table->text('mcert_subscribed_blank7')->nullable();
            $table->text('mcert_subscribed_blank8')->nullable();
            $table->text('mcert_subscribed_name_of_CR')->nullable();
            //scanned file
            $table->boolean('mcert_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mcerts');
    }
};
