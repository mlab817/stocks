<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubsectorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subsectors', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->foreignId('sector_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });

        $data = [
            ['label'=>'ETF-Equity', 'sector_id'=>1],
            ['label'=>'Banks', 'sector_id'=>2],
            ['label'=>'Other Financial Institutions', 'sector_id'=>2],
            ['label'=>'Holding Firms', 'sector_id'=>3],
            ['label'=>'Chemicals', 'sector_id'=>4],
            ['label'=>'Construction, Infra. & Allied Services', 'sector_id'=>4],
            ['label'=>'Electrical Components & Equipment', 'sector_id'=>4],
            ['label'=>'Electricity, Energy, Power & Water', 'sector_id'=>4],
            ['label'=>'Food, Beverage & Tobacco', 'sector_id'=>4],
            ['label'=>'Other Industrials', 'sector_id'=>4],
            ['label'=>'Mining', 'sector_id'=>5],
            ['label'=>'Oil', 'sector_id'=>5],
            ['label'=>'Property', 'sector_id'=>6],
            ['label'=>'Casinos & Gaming', 'sector_id'=>7],
            ['label'=>'Education', 'sector_id'=>7],
            ['label'=>'Hotel & Leisure', 'sector_id'=>7],
            ['label'=>'Information Technology', 'sector_id'=>7],
            ['label'=>'Media', 'sector_id'=>7],
            ['label'=>'Other Services', 'sector_id'=>7],
            ['label'=>'Retail', 'sector_id'=>7],
            ['label'=>'Telecommunications', 'sector_id'=>7],
            ['label'=>'Transportation Services', 'sector_id'=>7],
            ['label'=>'Small, Medium & Emerging Board', 'sector_id'=>8],
            ['label'=>'SME', 'sector_id'=>9],
        ];

        foreach ($data as $d) {
            \Illuminate\Support\Facades\DB::table('subsectors')->insert([
                'label' => $d['label'],
                'sector_id' => $d['sector_id'],
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
        Schema::dropIfExists('subsectors');
    }
}
