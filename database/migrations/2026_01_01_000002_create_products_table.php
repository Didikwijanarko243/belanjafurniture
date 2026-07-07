<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->unique()->nullable();
            $table->longText('description')->nullable();
            $table->string('short_description', 500)->nullable();

            // Harga & stok
            $table->decimal('price', 12, 2);
            $table->decimal('sale_price', 12, 2)->nullable();
            $table->integer('stock')->default(0);

            // Spesifik furniture: dimensi & berat wajib jelas untuk customer
            $table->decimal('weight', 8, 2)->comment('berat dalam kg, untuk kalkulasi ongkir');
            $table->decimal('length', 8, 2)->nullable()->comment('cm');
            $table->decimal('width', 8, 2)->nullable()->comment('cm');
            $table->decimal('height', 8, 2)->nullable()->comment('cm');
            $table->string('material')->nullable()->comment('kayu jati, besi, rotan, dll');
            $table->string('finishing')->nullable()->comment('natural, duco, melamik, dll');

            // Custom order / lead time
            $table->boolean('is_custom_order')->default(false);
            $table->integer('production_days')->nullable()->comment('estimasi hari produksi jika custom');

            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('views_count')->default(0);

            // SEO fields (konsisten dengan project sebelumnya)
            $table->string('meta_title')->nullable();
            $table->string('meta_description', 500)->nullable();
            $table->string('canonical_url')->nullable();
            $table->string('og_title')->nullable();
            $table->string('og_description', 500)->nullable();
            $table->string('og_image')->nullable();

            $table->timestamps();

            $table->index(['is_active', 'is_featured']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
