<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->string('session_id');
            $table->enum('status', ['baru', 'dihubungi', 'deal', 'batal'])->default('baru');
            $table->text('whatsapp_message')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamps();

            $table->index('session_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};