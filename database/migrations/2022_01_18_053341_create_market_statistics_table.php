<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('market_statistics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained();
            $table->year('year');
            $table->unsignedBigInteger('volume')->default(0);
            $table->decimal('value', 30, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('market_statistics');
    }
}
