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
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('password');
            $table->string('agent_code')->unique();

            $table->boolean('is_master_agent')->default(false);
            $table->boolean('is_active')->default(true);

            $table->string('street_addr');
            $table->integer('ward');
            $table->foreignId('local_body_id')->constrained();
            $table->foreignId('district_id')->constrained();
            $table->foreignId('state_id')->constrained();

            $table->foreignId('user_id')->nullable()->constrained();

            $table->decimal('balance', 10, 2)->default(0);
            $table->foreignId('referrer_id')->nullable()->constrained('agents');

            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};
