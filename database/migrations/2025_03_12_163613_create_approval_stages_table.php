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
        Schema::create('approval_stages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_permit_letter_id')->constrained()->onDelete('cascade');
            $table->foreignId('approver_id')->constrained();
            $table->string('position', 150);
            $table->tinyInteger('level')->unsigned();
            $table->string('signature');
            $table->enum('status', ['waiting', 'approved', 'rejected'])->default('waiting');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approval_stages');
    }
};
