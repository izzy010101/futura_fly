<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('flights', function (Blueprint $table) {
            $table->string('flight_duration')->nullable()->after('arrival_time');
        });
    }

    public function down()
    {
        Schema::table('flights', function (Blueprint $table) {
            $table->dropColumn('flight_duration');
        });
    }

};
