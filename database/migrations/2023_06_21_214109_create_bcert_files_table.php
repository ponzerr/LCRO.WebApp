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
        Schema::create('bcert_files', function (Blueprint $table) {
            $table->id();
            $table->text('bcert_file_registry_no')->nullable();
            $table->string('bcert_file_birth_name')->nullable();
            $table->date('bcert_file_date_of_birth')->nullable();
            $table->string('bcert_file_attach_document')->nullable();
            $table->string('bcert_file_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bcert_files');
    }
};
