<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('symbol');
            $table->foreignId('subsector_id')->nullable()->constrained()->nullOnDelete();
            $table->date('listing_date');
            $table->integer('cmpy_id');
            $table->integer('security_id');
            $table->boolean('psei')->default(0);
            $table->boolean('active')->default(1);
            $table->timestamps();
        });

        $file = fopen(database_path('migrations') . '/companies.csv','r');

        for ($i = 0; $row = fgetcsv($file); ++$i) {
            // Do something will $row array
            if ($i != 0) {
                \Illuminate\Support\Facades\DB::table('companies')->insert([
                    'name' => $row[0],
                    'symbol' => $row[1],
                    'subsector_id' => $row[2],
                    'listing_date' => $row[3],
                    'cmpy_id' => $row[4],
                    'security_id' => $row[5],
                    'psei' => $row[6],
                ]);
            }
        }

        fclose($file);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
