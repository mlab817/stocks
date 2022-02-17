<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtherInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('other_information', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained();
            $table->unsignedBigInteger('issued_shares')->default(0);
            $table->unsignedBigInteger('listed_shares')->default(0);
            $table->unsignedBigInteger('outstanding_shares')->default(0);
            $table->string('free_float_level')->nullable();
            $table->decimal('market_capitalization', 30, 4)->default(0);
            $table->string('isin')->nullable();
            $table->string('issue_type')->nullable();
            $table->string('listing_date')->nullable();
            $table->decimal('board_lot', 30, 4)->default(0);
            $table->decimal('par_value', 30 ,4)->default(0);
            $table->string('foreign_ownership_limit')->nullable();
            $table->string('year_end_eps_period')->nullable();
            $table->decimal('year_end_eps', 30, 4)->default(0);
            $table->string('interim_eps')->nullable();
            $table->string('interim_period')->nullable();
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
        Schema::dropIfExists('other_information');
    }
}
