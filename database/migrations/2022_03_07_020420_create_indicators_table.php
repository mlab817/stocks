<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndicatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('indicators', function (Blueprint $table) {
            $table->foreignId('historical_price_id')->constrained()->cascadeOnDelete();
            $table->decimal('volume_adi',30,4)->nullable();
            $table->decimal('volume_obv',30,4)->nullable();
            $table->decimal('volume_cmf',30,4)->nullable();
            $table->decimal('volume_fi',30,4)->nullable();
            $table->decimal('volume_em',30,4)->nullable();
            $table->decimal('volume_sma_em',30,4)->nullable();
            $table->decimal('volume_vpt',30,4)->nullable();
            $table->decimal('volume_vwap',30,4)->nullable();
            $table->decimal('volume_mfi',30,4)->nullable();
            $table->decimal('volume_nvi',30,4)->nullable();
            $table->decimal('volatility_bbm',30,4)->nullable();
            $table->decimal('volatility_bbh',30,4)->nullable();
            $table->decimal('volatility_bbl',30,4)->nullable();
            $table->decimal('volatility_bbw',30,4)->nullable();
            $table->decimal('volatility_bbp',30,4)->nullable();
            $table->decimal('volatility_bbhi',30,4)->nullable();
            $table->decimal('volatility_bbli',30,4)->nullable();
            $table->decimal('volatility_kcc',30,4)->nullable();
            $table->decimal('volatility_kch',30,4)->nullable();
            $table->decimal('volatility_kcl',30,4)->nullable();
            $table->decimal('volatility_kcw',30,4)->nullable();
            $table->decimal('volatility_kcp',30,4)->nullable();
            $table->decimal('volatility_kchi',30,4)->nullable();
            $table->decimal('volatility_kcli',30,4)->nullable();
            $table->decimal('volatility_dcl',30,4)->nullable();
            $table->decimal('volatility_dch',30,4)->nullable();
            $table->decimal('volatility_dcm',30,4)->nullable();
            $table->decimal('volatility_dcw',30,4)->nullable();
            $table->decimal('volatility_dcp',30,4)->nullable();
            $table->decimal('volatility_atr',30,4)->nullable();
            $table->decimal('volatility_ui',30,4)->nullable();
            $table->decimal('trend_macd',30,4)->nullable();
            $table->decimal('trend_macd_signal',30,4)->nullable();
            $table->decimal('trend_macd_diff',30,4)->nullable();
            $table->decimal('trend_sma_fast',30,4)->nullable();
            $table->decimal('trend_sma_slow',30,4)->nullable();
            $table->decimal('trend_ema_fast',30,4)->nullable();
            $table->decimal('trend_ema_slow',30,4)->nullable();
            $table->decimal('trend_vortex_ind_pos',30,4)->nullable();
            $table->decimal('trend_vortex_ind_neg',30,4)->nullable();
            $table->decimal('trend_vortex_ind_diff',30,4)->nullable();
            $table->decimal('trend_trix',30,4)->nullable();
            $table->decimal('trend_mass_index',30,4)->nullable();
            $table->decimal('trend_dpo',30,4)->nullable();
            $table->decimal('trend_kst',30,4)->nullable();
            $table->decimal('trend_kst_sig',30,4)->nullable();
            $table->decimal('trend_kst_diff',30,4)->nullable();
            $table->decimal('trend_ichimoku_conv',30,4)->nullable();
            $table->decimal('trend_ichimoku_base',30,4)->nullable();
            $table->decimal('trend_ichimoku_a',30,4)->nullable();
            $table->decimal('trend_ichimoku_b',30,4)->nullable();
            $table->decimal('trend_stc',30,4)->nullable();
            $table->decimal('trend_adx',30,4)->nullable();
            $table->decimal('trend_adx_pos',30,4)->nullable();
            $table->decimal('trend_adx_neg',30,4)->nullable();
            $table->decimal('trend_cci',30,4)->nullable();
            $table->decimal('trend_visual_ichimoku_a',30,4)->nullable();
            $table->decimal('trend_visual_ichimoku_b',30,4)->nullable();
            $table->decimal('trend_aroon_up',30,4)->nullable();
            $table->decimal('trend_aroon_down',30,4)->nullable();
            $table->decimal('trend_aroon_ind',30,4)->nullable();
            $table->decimal('trend_psar_up',30,4)->nullable();
            $table->decimal('trend_psar_down',30,4)->nullable();
            $table->decimal('trend_psar_up_indicator',30,4)->nullable();
            $table->decimal('trend_psar_down_indicator',30,4)->nullable();
            $table->decimal('momentum_rsi',30,4)->nullable();
            $table->decimal('momentum_stoch_rsi',30,4)->nullable();
            $table->decimal('momentum_stoch_rsi_k',30,4)->nullable();
            $table->decimal('momentum_stoch_rsi_d',30,4)->nullable();
            $table->decimal('momentum_tsi',30,4)->nullable();
            $table->decimal('momentum_uo',30,4)->nullable();
            $table->decimal('momentum_stoch',30,4)->nullable();
            $table->decimal('momentum_stoch_signal',30,4)->nullable();
            $table->decimal('momentum_wr',30,4)->nullable();
            $table->decimal('momentum_ao',30,4)->nullable();
            $table->decimal('momentum_roc',30,4)->nullable();
            $table->decimal('momentum_ppo',30,4)->nullable();
            $table->decimal('momentum_ppo_signal',30,4)->nullable();
            $table->decimal('momentum_ppo_hist',30,4)->nullable();
            $table->decimal('momentum_pvo',30,4)->nullable();
            $table->decimal('momentum_pvo_signal',30,4)->nullable();
            $table->decimal('momentum_pvo_hist',30,4)->nullable();
            $table->decimal('momentum_kama',30,4)->nullable();
            $table->decimal('others_dr',30,4)->nullable();
            $table->decimal('others_dlr',30,4)->nullable();
            $table->decimal('others_cr',30,4)->nullable();
            // custom indicators
            $table->decimal('alma',30,4)->nullable();
            $table->decimal('lag_macd_diff', 30, 4)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('indicators');
    }
}
