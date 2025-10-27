<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('spares', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('part_number')->nullable(); // remove ->unique()

            $table->integer('quantity')->default(0);
            $table->decimal('price', 10, 2)->default(0);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spares');
    }
};

