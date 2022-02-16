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
            $table->decimal('alma', 30, 4)->nullable();
            $table->decimal('macd', 30, 4)->nullable();
            $table->decimal('macd_signal', 30, 4)->nullable();
            $table->decimal('macd_hist', 30, 4)->nullable();
            $table->decimal('ma_20', 30, 4)->nullable();
            $table->decimal('ma_50', 30, 4)->nullable();
            $table->decimal('ma_100', 30, 4)->nullable();
            $table->decimal('ma_200', 30, 4)->nullable();
            $table->decimal('rsi', 30, 4)->nullable();
            $table->decimal('cci', 30, 4)->nullable();
            $table->decimal('atr', 30, 4)->nullable();
            $table->decimal('sts', 30, 4)->nullable();
            $table->decimal('williams_r', 30, 4)->nullable();
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
