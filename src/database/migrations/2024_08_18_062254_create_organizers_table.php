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
        Schema::create('organizers', function (Blueprint $table) {
            $table->id();
            $table->string('business_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('domain_name')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('mobile_no_2')->nullable();
            $table->string('home_address')->nullable();
            $table->string('image_url')->nullable();
            $table->string('thumbnail_url')->nullable();
            $table->string('profile_url')->nullable();
            $table->string('profile_thumb_url')->nullable();
            $table->json('social_media_data')->nullable();
            $table->text('remarks')->nullable();
            $table->boolean('active')->default(1);
            $table->boolean('organizer_type')->default(0);
            $table->string('slug', 20)->nullable();
            $table->softDeletes();
        });

        DB::table('organizers')->insert([
            [ 'business_name' => 'Arcdev','first_name' => 'Andrew', 'last_name' => 'Arciaga', 'middle_name' => 'Catindig', 'email' => 'drew_arciaga@yahoo.com' ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizers');
    }
};
