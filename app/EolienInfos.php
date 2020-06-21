<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\EolienInfos
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EolienInfos newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EolienInfos newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EolienInfos query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EolienInfos whereCentraleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EolienInfos whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EolienInfos whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EolienInfos whereHoraire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EolienInfos whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EolienInfos whereProductionTotaleBrut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EolienInfos whereProductionTotaleNet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EolienInfos whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EolienInfos whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EolienInfos extends Model
{
    protected $table = "eolien_infos";
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
