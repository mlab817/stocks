<?php

namespace App\Observers;

use App\Models\CashTransaction;

class CashTransactionObserver
{
    /**
     * Handle the CashTransaction "created" event.
     *
     * @param  \App\Models\CashTransaction  $cashTransaction
     * @return void
     */
    public function created(CashTransaction $cashTransaction)
    {
        $cashTransaction->user_id = auth()->id();
    }

    /**
     * Handle the CashTransaction "updated" event.
     *
     * @param  \App\Models\CashTransaction  $cashTransaction
     * @return void
     */
    public function updated(CashTransaction $cashTransaction)
    {
        //
    }

    /**
     * Handle the CashTransaction "deleted" event.
     *
     * @param  \App\Models\CashTransaction  $cashTransaction
     * @return void
     */
    public function deleted(CashTransaction $cashTransaction)
    {
        //
    }

    /**
     * Handle the CashTransaction "restored" event.
     *
     * @param  \App\Models\CashTransaction  $cashTransaction
     * @return void
     */
    public function restored(CashTransaction $cashTransaction)
    {
        //
    }

    /**
     * Handle the CashTransaction "force deleted" event.
     *
     * @param  \App\Models\CashTransaction  $cashTransaction
     * @return void
     */
    public function forceDeleted(CashTransaction $cashTransaction)
    {
        //
    }
}
