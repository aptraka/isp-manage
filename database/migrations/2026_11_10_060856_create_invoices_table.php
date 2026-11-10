<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();

            $table->foreignId('customer_id')
                ->constrained('customers')
                ->restrictOnDelete();

            $table->string('invoice_number')->unique();

            $table->date('billing_period');

            $table->decimal('amount', 12, 2);

            $table->enum('payment_status', [
                'belum_bayar',
                'lunas'
            ])->default('belum_bayar');

            $table->timestamp('paid_at')->nullable();

            $table->timestamps();

            $table->unique(['customer_id', 'billing_period']);
            $table->index('payment_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
