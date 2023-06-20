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
        Schema::create('mcert_app_files', function (Blueprint $table) {
            $table->id();
            $table->text('mcert_app_file_registry_no')->nullable();
            $table->string('mcert_app_file_groom_name')->nullable();
            $table->string('mcert_app_file_bride_name')->nullable();
            $table->string('mcert_app_file_attach_document')->nullable();
            $table->string('mcert_app_file_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mcert_app_files');
    }
};
