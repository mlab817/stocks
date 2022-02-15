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

        for ($i = 15; $i <= 278; $i++) {

            $file = fopen(database_path('csv/stock_' . $i . '.csv'), 'r');
            $header = true;
            $n = 0;

            while ($csvLine = fgetcsv($file, 0, ',')) {

                if ($header) {
                    $header = false;
                } else {
                    $trix = floatval($csvLine[2]) > 10**18 ? null: (! floatval($csvLine[2]) ? null : floatval($csvLine[2]));
                    $psar = floatval($csvLine[3]) > 10**18 ? null: (! floatval($csvLine[3]) ? null : floatval($csvLine[3]));
                    $ema_9    = floatval($csvLine[4]) > 10**18 ? null: (! floatval($csvLine[4]) ? null : floatval($csvLine[4]));
                    HistoricalPrice::where('company_id', $csvLine[0])
                        ->where('date', $csvLine[1])
                        ->update([
                            'trix' => $trix,
                            'psar' => $psar,
                            'ema_9' => $ema_9,
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
