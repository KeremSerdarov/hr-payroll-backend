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
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            // PostgreSQL-da tinyint görnüşi smallint hökmünde saklanýar.
            $table->unsignedTinyInteger('month');
            $table->unsignedSmallInteger('year');
            $table->decimal('base_salary', 10, 2);
            $table->decimal('bonus', 10, 2)->default(0);
            $table->decimal('deduction', 10, 2);
            $table->decimal('tax', 10, 2);
            $table->decimal('net_salary', 10, 2);
            $table->enum('status', ['draft', 'paid'])->default('draft');
            $table->unique(['employee_id', 'month', 'year']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
