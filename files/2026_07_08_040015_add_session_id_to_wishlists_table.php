<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('wishlists', function (Blueprint $table) {
            $table->string('session_id')->nullable()->after('user_id');
            $table->index('session_id');
        });

        // Kalau kolom user_id sebelumnya NOT NULL, longgarkan supaya guest bisa wishlist juga.
        // Butuh doctrine/dbal (composer require doctrine/dbal) kalau change() error di environment kamu.
        Schema::table('wishlists', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('wishlists', function (Blueprint $table) {
            $table->dropColumn('session_id');
        });
    }
};
