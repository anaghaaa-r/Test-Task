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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            // assigned to user relationship
            $table->foreignId('assigned_to')->nullable()->constrained('users')->cascadeOnDelete();
            // relationship to category
            $table->foreignId('category_id')->nullable()->constrained('categories')->cascadeOnDelete();
            $table->date('deadline')->nullable();
            $table->string('file')->nullable();
            $table->integer('status')->comment('0 => not completed, 1 => completed')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
