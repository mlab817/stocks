<?php

namespace App\Imports;

use App\Models\HistoricalPrice;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class HistoricalPricesImport implements ToCollection, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    use Importable;

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            HistoricalPrice::create([
                'company_id' => $row['company_id'],
                'date' => $row['date'],
                'open' => $row['open'],
                'high' => $row['high'],
                'low' => $row['low'],
                'close' => $row['close'],
                'value' => $row['value'],
                'alma' => $row['alma'] == 'NaN' ? null : $row['alma'],
                'macd' => $row['macd'] == 'NaN' ? null : $row['macd'],
                'macd_signal' => $row['macd_signal'] == 'NaN' ? null : $row['macd_signal'],
                'macd_hist' => $row['macd_hist'] == 'NaN' ? null : $row['macd_hist'],
                'ma_20' => $row['ma_20'] == 'NaN' ? null : $row['ma_20'],
                'ma_50' => $row['ma_50'] == 'NaN' ? null : $row['ma_50'],
                'ma_100' => $row['ma_100'] == 'NaN' ? null : $row['ma_100'],
                'ma_200' => $row['ma_200'] == 'NaN' ? null : $row['ma_200'],
                'rsi' => $row['rsi'] == 'NaN' ? null : $row['rsi'],
                'cci' => $row['cci'] == 'NaN' ? null : $row['cci'],
                'atr' => $row['atr'] == 'NaN' ? null : $row['atr'],
                'sts' => $row['sts'] == 'NaN' ? null : $row['sts'],
                'williams_r' => $row['williams_r'] == 'NaN' ? null : $row['williams_r']
            ]);
        }
    }

    /**
     * @return int
     */
    public function batchSize(): int
    {
        return 250;
    }

    /**
     * @return int
     */
    public function chunkSize(): int
    {
        return 250;
    }
}
