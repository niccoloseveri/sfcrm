<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Livewire\after;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            //
            $table->boolean('is_azienda')->default(false)->after('description');
            $table->string('nome_az')->nullable()->after('is_azienda');
            $table->string('rag_sociale')->nullable()->after('nome_az');
            $table->string('cf_azienda')->nullable()->after('rag_sociale');
            $table->string('piva')->nullable()->after('cf_azienda');
            $table->string('email_az')->nullable()->after('piva');
            $table->string('tel_az')->nullable()->after('email_az');
            $table->string('website')->nullable()->after('tel_az');
            $table->string('citta_az')->nullable()->after('website');
            $table->string('prov_az')->nullable()->after('citta_az');
            $table->string('via_az')->nullable()->after('prov_az');
            $table->string('cap_az')->nullable()->after('via_az');
            $table->string('stato_az')->nullable()->after('cap_az');
            $table->string('cod_univoco')->nullable()->after('stato_az');
            $table->string('cf')->nullable()->after('cod_univoco');
            $table->string('citta_r')->nullable()->after('cf');
            $table->string('prov_r')->nullable()->after('citta_r');
            $table->string('via_r')->nullable()->after('prov_r');
            $table->string('cap_r')->nullable()->after('via_r');
            $table->string('stato_r')->nullable()->after('cap_r');
            $table->string('citta_c')->nullable()->after('stato_r');
            $table->string('prov_c')->nullable()->after('citta_c');
            $table->string('via_c')->nullable()->after('prov_c');
            $table->string('cap_c')->nullable()->after('via_c');
            $table->string('stato_c')->nullable()->after('cap_c');
            $table->longText('altreinfo')->nullable()->after('stato_c');
            $table->foreignId('settore_id')->after('altreinfo');
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
