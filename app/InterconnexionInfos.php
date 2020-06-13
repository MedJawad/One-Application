<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InterconnexionInfos extends Model
{
    /**
     * Get the centrale that owns these infos
     */
    public function centrale()
    {
        return $this->belongsTo('App\Centrale');
    }
}
