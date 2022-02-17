<?php

namespace App\Observers;

use App\Models\Trade;

class TradeObserver
{
    /**
     * observer gets applies to both creating/updating
     *
     * @param Trade $trade
     */
    public function saving(Trade $trade)
    {
        $base_cost = $trade->price * $trade->shares;
        $commission = $base_cost * 0.0025;
        $vat = $commission * 0.12;
        $sccp_fee = $base_cost * 0.0001;
        $pse_fee = $base_cost * 0.00005;

        if ($trade->trade_type == 'sell') {
            $sales_tax = $base_cost * 0.006;
        } else {
            $sales_tax = 0;
        }

        $trade->commission  = $commission;
        $trade->vat         = $vat;
        $trade->sccp_fee    = $sccp_fee;
        $trade->pse_fee     = $pse_fee;
        $trade->sales_tax   = $sales_tax;
        $trade->user_id     = auth()->id() ?? 1;
    }

    /**
     * Handle the Trade "created" event.
     *
     * @param  \App\Models\Trade  $trade
     * @return void
     */
    public function created(Trade $trade)
    {
        //
    }

    /**
     * Handle the Trade "updated" event.
     *
     * @param  \App\Models\Trade  $trade
     * @return void
     */
    public function updated(Trade $trade)
    {
        //
    }

    /**
     * Handle the Trade "deleted" event.
     *
     * @param  \App\Models\Trade  $trade
     * @return void
     */
    public function deleted(Trade $trade)
    {
        //
    }

    /**
     * Handle the Trade "restored" event.
     *
     * @param  \App\Models\Trade  $trade
     * @return void
     */
    public function restored(Trade $trade)
    {
        //
    }

    /**
     * Handle the Trade "force deleted" event.
     *
     * @param  \App\Models\Trade  $trade
     * @return void
     */
    public function forceDeleted(Trade $trade)
    {
        //
    }
}
