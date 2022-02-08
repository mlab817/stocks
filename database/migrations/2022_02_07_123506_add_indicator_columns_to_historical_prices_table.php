<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndicatorColumnsToHistoricalPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('historical_prices', function (Blueprint $table) {
            $table->decimal('alma', 20, 2)->nullable();
            $table->decimal('macd', 20, 2)->nullable();
            $table->decimal('macd_signal', 20, 2)->nullable();
            $table->decimal('macd_hist', 20, 2)->nullable();
            $table->decimal('ma_20', 20, 2)->nullable();
            $table->decimal('ma_50', 20, 2)->nullable();
            $table->decimal('ma_100', 20, 2)->nullable();
            $table->decimal('ma_200', 20, 2)->nullable();
            $table->decimal('rsi', 20, 2)->nullable();
            $table->decimal('cci', 20, 2)->nullable();
            $table->decimal('atr', 20, 2)->nullable();
            $table->decimal('sts', 20, 2)->nullable();
            $table->decimal('williams_r', 20, 2)->nullable();
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
