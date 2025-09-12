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
        Schema::create('deals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id')->constrained()->onDelete('cascade');
            $table->foreignId('customers_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->unsignedInteger('amount');
            $table->unsignedInteger('deal_status_id');
            $table->date('expected_close_at')->nullable();
            $table->timestamp('won_at')->nullable();
            $table->unsignedInteger('position')->default(0);
            $table->softDeletes()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deals');
    }
};
