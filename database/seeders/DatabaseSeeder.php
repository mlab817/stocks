<?php

namespace Database\Seeders;

use App\Imports\HistoricalPricesImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Excel;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        (new HistoricalPricesImport())
            ->import(database_path() . '/seeders/historical_prices.csv', null, Excel::CSV);
    }
}
