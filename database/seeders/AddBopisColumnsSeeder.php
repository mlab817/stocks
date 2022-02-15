<?php

namespace Database\Seeders;

use App\Models\HistoricalPrice;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class AddBopisColumnsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::disableQueryLog();

        for ($i = 1; $i <= 278; $i++) {

            $file = fopen(database_path('csv/stock_' . $i . '.csv'), 'r');
            $header = true;
            $n = 0;

            while ($csvLine = fgetcsv($file, 0, ',')) {

                if ($header) {
                    $header = false;
                } else {
                    HistoricalPrice::where('company_id', $csvLine[0])
                        ->where('date', $csvLine[1])
                        ->update([
                            'trix' => floatval($csvLine[2]) ?? null,
                            'psar' => floatval($csvLine[3]) ?? null,
                            'ema_9' => floatval($csvLine[4]) ?? null,
                        ]);
                }

                print('Updated ' . $n . '\n');
                $n += 1;
            }

            printf('Done with ' . $i);
        }

        DB::enableQueryLog();
    }
}
