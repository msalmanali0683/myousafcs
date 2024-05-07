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
        Schema::create('product_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('bags')->nullable();
            $table->double('rate')->nullable();
            $table->double('weight')->nullable();
            $table->enum('invoice_type', ['sale', 'purchase']);
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Define foreign key
            $table->foreignId('invoice_id')->constrained()->onDelete('cascade'); // Define foreign key
            $table->foreignId('logistic_id')->constrained()->onDelete('cascade');
            $table->foreignId('labour_id')->constrained()->onDelete('cascade'); // Define foreign key
            $table->double('labour_amount')->nullable();
            $table->double('logistic_amount')->nullable();
            $table->string('driver_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_transactions');
    }
};
