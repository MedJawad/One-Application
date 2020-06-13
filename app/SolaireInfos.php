<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SolaireInfos extends Model
{
    protected $table = "solaire_infos";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type','horaire','date','production_totale_brut','production_totale_net'
    ];

    /**
     * Get the centrale that owns these infos
     */
    public function centrale()
    {
        return $this->belongsTo('App\Centrale');
    }
    /**
     * Get the list of productions inserted for this CentraleInfos
     */
    public function productions()
    {
        if(strcasecmp($this->type,"productions")==0) return $this->morphMany('App\Production','productionable');
    }
    /**
     * Get the list of previsions inserted for this CentraleInfos
     */
    public function previsions()
    {
        if(strcasecmp($this->type,"previsions")==0) return $this->morphMany('App\Prevision','previsionable');
    }
}
