<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\TAGInfos
 *
 * @property int $id
 * @property string|null $horaire
 * @property string $date
 * @property float|null $production_totale_brut
 * @property float|null $production_totale_net
 * @property int $centrale_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Centrale $centrale
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Production[] $productions
 * @property-read int|null $productions_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TAGInfos newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TAGInfos newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TAGInfos query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TAGInfos whereCentraleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TAGInfos whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TAGInfos whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TAGInfos whereHoraire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TAGInfos whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TAGInfos whereProductionTotaleBrut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TAGInfos whereProductionTotaleNet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TAGInfos whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TAGInfos extends Model
{
    protected $table = "tag_infos";
    protected $fillable = [
        'horaire','date','production_totale_brut','production_totale_net'
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
