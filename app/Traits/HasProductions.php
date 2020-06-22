<?php
namespace App\Traits;
trait HasProductions
{

    /**
     * Get the list of productions inserted for this CentraleInfos
     */
    public function productions()
    {
        if(isset($this->type) && strcasecmp($this->type,"previsions")==0) return null; //The case of Eolien/Solaire Infos of previsions
        return $this->morphMany('App\Production','productionable');
    }
}
