<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('welcome_page_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organizer_id')->nullable()->constrained()->onDelete('cascade');
            $table->longText('main_banner')->nullable();
            $table->longText('main_categories')->nullable();
            $table->longText('overview')->nullable();
            $table->longText('carousel')->nullable();
            $table->longText('features')->nullable();
            $table->longText('services')->nullable();
            $table->longText('about_us')->nullable();
            $table->longText('topics')->nullable();
            $table->longText('swiper_gallery')->nullable();
            $table->longText('gallery')->nullable();
            $table->longText('brands')->nullable();
            $table->longText('footers')->nullable();
            $table->longText('virtual_tours')->nullable();
            $table->longText('pos_ads')->nullable();
            $table->longText('maps')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('welcome_page_settings');
    }
};
