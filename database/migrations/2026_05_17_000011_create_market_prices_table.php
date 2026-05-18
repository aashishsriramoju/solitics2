<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('market_prices', function (Blueprint $table) {
            $table->id();
            $table->string('crop_name');
            $table->string('market_name');
            $table->string('state')->default('Telangana');
            $table->string('district')->nullable();
            $table->decimal('min_price', 10, 2)->default(0);
            $table->decimal('max_price', 10, 2)->default(0);
            $table->decimal('modal_price', 10, 2)->default(0);
            $table->string('unit')->default('Quintal');
            $table->string('trend')->default('stable'); // up / down / stable
            $table->float('change_pct')->default(0);
            $table->date('price_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('market_prices');
    }
};
