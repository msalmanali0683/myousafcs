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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->double('total_amount')->nullable();
            $table->enum('invoice_type', ['sale', 'purchase']);
            $table->date('date');
            $table->foreignId('customer_id')->constrained()->onDelete('cascade'); // Define foreign key
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Define foreign key

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
