<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if ( !Schema::hasColumn('organizers', 'waiver') ) {
            Schema::table('organizers', function ( Blueprint $table ) {
                $table->text('waiver')->nullable()->after('remarks');
            });
        }

        if ( !Schema::hasColumn('organizers', 'payment_qr_codes') ) {
            Schema::table('organizers', function ( Blueprint $table ) {
                $table->json('payment_qr_codes')->nullable()->after('waiver');
            });
        }
    }

    public function down(): void
    {
        Schema::table('organizers', function ( Blueprint $table ) {
            if ( Schema::hasColumn('organizers', 'payment_qr_codes') ) {
                $table->dropColumn('payment_qr_codes');
            }

            if ( Schema::hasColumn('organizers', 'waiver') ) {
                $table->dropColumn('waiver');
            }
        });
    }
};
