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
                'alma' => $row['alma'] == 'nan' ? null : $row['alma'],
                'macd' => $row['macd'] == 'nan' ? null : $row['macd'],
                'macd_signal' => $row['macd_signal'] == 'nan' ? null : $row['macd_signal'],
                'macd_hist' => $row['macd_hist'] == 'nan' ? null : $row['macd_hist'],
                'ma_20' => $row['ma_20'] == 'nan' ? null : $row['ma_20'],
                'ma_50' => $row['ma_50'] == 'nan' ? null : $row['ma_50'],
                'ma_100' => $row['ma_100'] == 'nan' ? null : $row['ma_100'],
                'ma_200' => $row['ma_200'] == 'nan' ? null : $row['ma_200'],
                'rsi' => $row['rsi'] == 'nan' ? null : $row['rsi'],
                'cci' => $row['cci'] == 'nan' ? null : $row['cci'],
                'atr' => $row['atr'] == 'NULL' ? null : $row['atr'],
                'sts' => $row['sts'] == 'nan' ? null : $row['sts'],
                'williams_r' => $row['williams_r'] == 'nan' ? null : $row['williams_r'],
                'trix' => $row['trix'] == 'nan' ? null : $row['trix'],
                'psar' => $row['psar'] == 'nan' ? null : $row['psar'],
                'ema_9' => $row['ema_9'] == 'nan' ? null : $row['ema_9'],
                'pct_change' => $row['pct_change'] == 'nan' ? null : $row['pct_change'],
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
