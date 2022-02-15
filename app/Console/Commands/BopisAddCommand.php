<?php

namespace App\Console\Commands;

use App\Models\HistoricalPrice;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class BopisAddCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:bopis';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::disableQueryLog();

        $start = $this->ask('Where would you like to start');

        $bar = $this->output->createProgressBar(278 - $start + 1);

        $bar->start();

        for ($i = $start; $i <= 278; $i++) {

            $file = fopen(database_path('csv/stock_' . $i . '.csv'), 'r');
            $header = true;

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
            }

            printf('Done with ' . $i);
            $bar->advance();
        }

        $bar->finish();

        DB::enableQueryLog();

        $this->info('Successfully uploaded data');

        return 0;
    }
}
