<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('package_id')
                ->constrained('internet_packages')
                ->restrictOnDelete();

            $table->string('name');
            $table->string('phone', 20)->unique();
            $table->text('address');

            $table->decimal('package_price', 12, 2);

            $table->enum('status', [
                'aktif',
                'suspend',
                'terputus'
            ])->default('aktif');

            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
