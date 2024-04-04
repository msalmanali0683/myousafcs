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
        Schema::create('customer_balances', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['credit', 'debit']);
            $table->enum('category', ['customer', 'employee', 'expense', 'logistics', 'labour', 'purchase_product', 'sale_product']);
            $table->double('amount')->nullable();
            $table->string('details')->nullable();
            $table->string('account')->nullable();
            $table->string('category_id')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Define foreign key
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_balances');
    }
};