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
        Schema::create('work_permit_letters', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('vendor_id')->constrained();
            $table->foreignId('work_type_id')->constrained();
            $table->foreignId('work_location_id')->constrained();
            $table->text('description');
            $table->date('started_at');
            $table->date('ended_at');
            $table->string('external_pic_name', 150);
            $table->string('external_pic_number', 15);
            $table->string('internal_pic_name', 150)->nullable();
            $table->string('internal_pic_number', 15)->nullable();
            $table->string('application_letter');
            $table->string('job_safety_analysis_document')->nullable();
            $table->enum('status', ['submitted', 'verified', 'approved', 'rejected'])->default('submitted');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_permit_letters');
    }
};
