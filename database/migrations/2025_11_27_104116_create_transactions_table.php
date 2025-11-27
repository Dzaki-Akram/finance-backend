<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            $table->enum('type', ['income', 'expense']);
            $table->string('category');
            $table->text('description')->nullable();
            $table->decimal('amount', 15, 2);
            $table->date('date');
            $table->string('payment_method')->nullable();
            $table->string('status')->default('completed');

            $table->timestamps();

            // index untuk kinerja (sesuai kebutuhan non-fungsional)
            $table->index(['user_id', 'date']);
            $table->index(['user_id', 'amount']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
