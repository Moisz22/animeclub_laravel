<?php

namespace App\Observers;

use App\Models\Gender;

class GenderObserver
{
    /**
     * Handle the Gender "created" event.
     *
     * @param  \App\Models\Gender  $gender
     * @return void
     */
    public function created(Gender $gender)
    {
        //
    }

    /**
     * Handle the Gender "updated" event.
     *
     * @param  \App\Models\Gender  $gender
     * @return void
     */
    public function updated(Gender $gender)
    {
        //
    }

    /**
     * Handle the Gender "deleted" event.
     *
     * @param  \App\Models\Gender  $gender
     * @return void
     */
    public function deleted(Gender $gender)
    {
        //
    }

    /**
     * Handle the Gender "restored" event.
     *
     * @param  \App\Models\Gender  $gender
     * @return void
     */
    public function restored(Gender $gender)
    {
        //
    }

    /**
     * Handle the Gender "force deleted" event.
     *
     * @param  \App\Models\Gender  $gender
     * @return void
     */
    public function forceDeleted(Gender $gender)
    {
        //
    }
}
