<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->enum('trade_type',['buy','sell']);
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('shares')->default(0);
            $table->date('date');
            $table->decimal('price',10,2)->default(0);
            $table->decimal('commission',10,2)->default(0);
            $table->decimal('vat',10,2)->default(0);
            $table->decimal('sales_tax',10,2)->default(0);
            $table->decimal('sccp_fee',10,2)->default(0);
            $table->decimal('pse_fee',10,2)->default(0);
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
        Schema::dropIfExists('trades');
    }
}
