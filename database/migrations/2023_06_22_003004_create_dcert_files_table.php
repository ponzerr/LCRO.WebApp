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
        Schema::create('dcert_files', function (Blueprint $table) {
            $table->id();
            $table->text('dcert_file_registry_no')->nullable();
            $table->string('dcert_file_death_name')->nullable();
            $table->date('dcert_file_date_of_death')->nullable();
            $table->string('dcert_file_attach_document')->nullable();
            $table->string('dcert_file_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dcert_files');
    }
};
