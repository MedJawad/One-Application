<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Centrale extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom', 'adresse', 'description', 'type'
    ];

    /**
     * Get the infos of the centrale
     */
    public function infos()
    {
        switch (strtolower($this->type)) {
            case "barrage":
                return $this->hasMany('App\BarrageInfos');
            case "thermique a charbon":
                return $this->hasMany('App\TACInfos');
            case "turbine a gaz":
                return $this->hasMany('App\TAGInfos');
            case "solaire":
                return $this->hasMany('App\SolaireInfos');
            case "eolien":
                return $this->hasMany('App\EolienInfos');
            case "cycle combine":
                return $this->hasMany('App\CycleCombineInfos');
            case "interconnexion":
                return $this->hasMany('App\InterconnexionInfos');
        }
    }

    public function user() {
        return $this->belongsTo('App\User','user_id');
    }
}
