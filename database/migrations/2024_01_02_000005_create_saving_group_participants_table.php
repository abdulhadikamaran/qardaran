<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('saving_group_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('saving_group_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->boolean('has_won')->default(false);
            $table->integer('won_round')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saving_group_participants');
    }
};
