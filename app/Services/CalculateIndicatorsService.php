<?php

namespace App\Services;

use App\Models\Company;
use Illuminate\Support\Collection;
use LupeCode\phpTraderNative\Trader;

class CalculateIndicatorsService
{
    // return indicators
    private $prices;

    private int $arrayLength;

    private array $macd;

    private string $symbol;

    private $company;

    public function __construct($symbol)
    {
        $this->symbol = $symbol;
        $this->company = Company::findBySymbol($this->symbol);

        $prices = $this->company->prices;
        $this->prices = $this->sortDataByDateAsc(collect($prices));
        $this->arrayLength = count($this->prices);
        $this->macd = $this->calculateMacdIndicators();
    }

    public function execute()
    {
        $prices = $this->prices;
        $lastPrice = count($prices) - 1;

        return response()->json([
            'alma'          => $this->calculateAlma(),
            'atr'           => $this->calculateAtr(),
            'cci'           => $this->calculateCci(),
            'macd'          => $this->calculateMacd(),
            'macd_hist'     => $this->calculateMacdHist(),
            'macd_signal'   => $this->calculateMacdSignal(),
            'rsi'           => $this->calculateRsi(),
            'willr'         => $this->calculateWillR(),
            'psar'          => $this->calculateSar(),
            'ema_9'         => $this->calculateEma9(),
            'trix'          => $this->calculateTrix(),
            'lag_macd_hist' => $this->calculateLagMacdHist(),
            'ma_20'         => $this->calculateMa(20),
            'ma_50'         => $this->calculateMa(50),
            'ma_100'        => $this->calculateMa(100),
            'ma_200'        => $this->calculateMa(200),
            'pct_change'    => $this->calculatePctChange(),
        ]);
    }

    public function sortDataByDateAsc($prices)
    {
        return $prices->sortBy('date');
    }

    private function calculateAlma()
    {
        $length = $this->arrayLength;

        if ($length < 9) {
            return null;
        }

        // get 9 entries
        $lastNineClosingPrice = $this->prices->slice($length - 9, 9)->values();

        $alma = 0;
        $weights = $this->calculateAlmaWeights();

        for ($i = 0; $i < 9; $i++) {
            $alma += $weights[$i] * $lastNineClosingPrice[$i]['close'];
        }

        return round($alma / collect($weights)->sum(), 4);
    }

    public function calculateAlmaWeights()
    {
        $window = 9;
        $offset = 0.85;
        $sigma = 6;

        $m = floor($offset * ($window - 1));
        $s = $window / $sigma;

        $weights = [];

        $i = 0;

        for ($i = 0; $i < $window; $i++) {
            $w = exp(-1 * (($i - $m) ** 2) / (2 * ($s ** 2)));
            array_push($weights, $w);
        }

        return $weights;
    }

    public function calculateMacd()
    {
        return $this->getCurrentIndicatorValue($this->macd['MACD']);
    }

    public function calculateMacdHist()
    {
        return $this->getCurrentIndicatorValue($this->macd['MACDHist']);
    }

    public function calculateMacdSignal()
    {
        return $this->getCurrentIndicatorValue($this->macd['MACDSignal']);
    }

    public function calculateMacdIndicators()
    {
        return Trader::macd($this->prices->pluck('close')->toArray());
    }

    public function calculateLagMacdHist()
    {
        $macdHist = $this->macd['MACDHist'];
        $length = count($macdHist);

        return round($macdHist[$length - 2], 4);
    }

    public function calculateRsi()
    {
        $indicator = Trader::rsi($this->prices->pluck('close')->toArray());

        return $this->getCurrentIndicatorValue($indicator);
    }

    public function calculateWillR()
    {
        $indicator = Trader::willr(
            $this->prices->pluck('high')->toArray(),
            $this->prices->pluck('low')->toArray(),
            $this->prices->pluck('close')->toArray(),
        );

        return $this->getCurrentIndicatorValue($indicator);
    }

    public function calculateSar()
    {
        $indicator = Trader::sar(
            $this->prices->pluck('high')->toArray(),
            $this->prices->pluck('low')->toArray(),
        );

        return $this->getCurrentIndicatorValue($indicator);
    }

    public function calculateCci()
    {
        $indicator = Trader::cci(
            $this->prices->pluck('high')->toArray(),
            $this->prices->pluck('low')->toArray(),
            $this->prices->pluck('close')->toArray(),
        );

        return $this->getCurrentIndicatorValue($indicator);
    }

    public function calculateEma9()
    {
        $indicator = Trader::ema($this->prices->pluck('close')->toArray(),9);

        return $this->getCurrentIndicatorValue($indicator);
    }

    public function calculateTrix()
    {
        $indicator = Trader::trix($this->prices->pluck('close')->toArray());

        return $this->getCurrentIndicatorValue($indicator);
    }

    public function calculateMa($timePeriod = 20)
    {
        $indicator = Trader::ma($this->prices->pluck('close')->toArray(), $timePeriod);

        return $this->getCurrentIndicatorValue($indicator);
    }

    public function calculatePctChange()
    {
        $length = count($this->prices);

        $lastClose = $this->prices->pluck('close')[$length-1];
        $previousClose = $this->prices->pluck('close')[$length-2];

        return round(($lastClose - $previousClose) / ($previousClose) * 100, 4);
    }

    public function calculateAtr()
    {
        $indicator = Trader::atr(
            $this->prices->pluck('high')->toArray(),
            $this->prices->pluck('low')->toArray(),
            $this->prices->pluck('close')->toArray(),
        );

        return $this->getCurrentIndicatorValue($indicator);
    }

    public function getCurrentIndicatorValue($indicator)
    {
        $length = count($indicator);

        return round($indicator[$length - 1], 4);
    }

}
