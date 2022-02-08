<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sectors', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->timestamps();
        });

        // insert data
        $data = [
            'ETF-Equity',
            'Financials',
            'Holding Firms',
            'Industrial',
            'Mining and Oil',
            'Property',
            'Services',
            'Small, Medium & Emerging Board',
            'SME',
        ];

        foreach ($data as $d) {
            \Illuminate\Support\Facades\DB::table('sectors')->insert([
                'label' => $d,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sectors');
    }
}
