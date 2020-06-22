<?php

namespace App;

use App\Traits\HasCentrale;
use App\Traits\HasPrevisions;
use App\Traits\HasProductions;
use Illuminate\Database\Eloquent\Model;

/**
 * App\SolaireInfos
 *
 * @property int $id
 * @property string $type
 * @property string|null $horaire
 * @property string $date
 * @property float|null $production_totale_brut
 * @property float|null $production_totale_net
 * @property int $centrale_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Centrale $centrale
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SolaireInfos newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SolaireInfos newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SolaireInfos query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SolaireInfos whereCentraleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SolaireInfos whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SolaireInfos whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SolaireInfos whereHoraire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SolaireInfos whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SolaireInfos whereProductionTotaleBrut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SolaireInfos whereProductionTotaleNet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SolaireInfos whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SolaireInfos whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SolaireInfos extends Model
{
    use HasCentrale,HasProductions,HasPrevisions;

    protected $table = "solaire_infos";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type','horaire','date','production_totale_brut','production_totale_net'
    ];
//
//    /**
//     * Get the list of productions inserted for this CentraleInfos
//     */
//    public function productions()
//    {
//        if(strcasecmp($this->type,"productions")==0) return $this->morphMany('App\Production','productionable');
//    }

}
