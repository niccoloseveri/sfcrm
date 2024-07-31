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
        Schema::table('customers', function (Blueprint $table) {
            //
            $table->string('citta_f')->nullable()->after('stato_c');
            $table->string('prov_f')->nullable()->after('citta_f');
            $table->string('via_f')->nullable()->after('prov_f');
            $table->string('cap_f')->nullable()->after('via_f');
            $table->string('stato_f')->nullable()->after('cap_f');
            $table->boolean('same_as_fatt')->after('stato_f')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            //
        });
    }
};
