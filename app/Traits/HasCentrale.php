<?php
namespace App\Traits;
trait HasCentrale
{

    /**
     * Get the centrale that owns these infos
     */
    public function centrale()
    {
        return $this->belongsTo('App\Centrale');
    }
}
