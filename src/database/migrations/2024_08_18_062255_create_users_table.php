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
            $table->string('username');
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->foreignId('organizer_id')->nullable()->constrained()->onDelete('cascade');
            $table->unsignedSmallInteger('user_type')->default(0);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('mobile_no')->nullable();
            $table->boolean('active')->default(true);
            $table->boolean('locked')->default(false);
            $table->boolean('super_admin')->default(false);
            $table->string('image_url')->nullable();
            $table->string('thumbnail_url')->nullable();
            $table->text('remarks')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        DB::table('users')->insert([
            [ 'organizer_id' => 1, 'username' => 'drew', 'first_name' => 'Andrew', 'last_name' => 'Arciaga', 'middle_name' => 'Catindig', 'email' => 'drew_arciaga@yahoo.com', 'password' => '$2y$12$/nShVivG5IjHKSWBLxwB2ebDGBT9YH6Ej0FVtsgyqdvoMd6OYaII6',
              'active' => 1, 'locked' => 0, 'super_admin' => 1 ],
        ]);

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
