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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('participant_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('item_name');
            $table->unsignedInteger('quantity');
            $table->unsignedInteger('unit_price')->nullable();
            $table->text('memo')->nullable();

            $table->tinyInteger('status')->default(0);
            $table->text('reject_reason')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
