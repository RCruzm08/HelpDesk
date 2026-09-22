<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('department_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('title', 150);
            $table->string('requester_name', 100);
            $table->string('priority', 20);
            $table->text('description');
            $table->string('status', 30)->default('Aberto');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
