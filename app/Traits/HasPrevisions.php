<?php
namespace App\Traits;
trait HasPrevisions
{

    /**
     * Get the list of previsions inserted for this CentraleInfos
     */
    public function previsions()
    {
        if(strcasecmp($this->type,"previsions")==0) return $this->morphMany('App\Prevision','previsionable');
    }
}
