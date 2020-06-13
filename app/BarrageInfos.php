<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BarrageInfos extends Model
{
    protected $table = "barrage_infos";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'horaire','date','cote', 'turbine', 'irrigation','lache','production_totale_brut','production_totale_net'
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
        return $this->morphMany('App\Production','productionable');
    }
}
