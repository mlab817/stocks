<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBopisColumnsToHistoricalPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('historical_prices', function (Blueprint $table) {
            $table->decimal('trix', 20, 2)->nullable();
            $table->decimal('psar', 20, 2)->nullable();
            $table->decimal('ema_9', 20, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('historical_prices', function (Blueprint $table) {
            //
        });
    }
}
