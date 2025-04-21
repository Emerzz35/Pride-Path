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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200)->nullable();
            $table->string('phone', 14);
            $table->string('cpf', 14)->nullable();
            $table->date('day_of_birth')->nullable();
            $table->string('email', 200)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 300);
            $table->string('cep', 9);
            $table->foreignId('state_id')->constrained('states');
            $table->string('address_street', 200);
            $table->string('address_complement', 200)->nullable();
            $table->smallInteger('address_number');
            $table->string('address_city', 200);
            $table->string('corporate_reason', 200)->nullable();
            $table->string('state_registration', 20)->nullable();
            $table->string('responsable', 200)->nullable();
            $table->string('cnpj', 18)->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
