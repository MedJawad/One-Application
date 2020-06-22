<?php

namespace App;

use App\Traits\HasCentrale;
use App\Traits\HasProductions;
use Illuminate\Database\Eloquent\Model;

/**
 * App\BarrageInfos
 *
 * @property int $id
 * @property int $centrale_id
 * @property string $horaire
 * @property string $date
 * @property float|null $cote
 * @property float|null $cote2
 * @property float|null $volume_pompe
 * @property float|null $turbine
 * @property float|null $irrigation
 * @property float|null $lache
 * @property float|null $production_totale_brut
 * @property float|null $production_totale_net
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Centrale $centrale
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Production[] $productions
 * @property-read int|null $productions_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BarrageInfos newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BarrageInfos newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BarrageInfos query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BarrageInfos whereCentraleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BarrageInfos whereCote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BarrageInfos whereCote2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BarrageInfos whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BarrageInfos whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BarrageInfos whereHoraire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BarrageInfos whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BarrageInfos whereIrrigation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BarrageInfos whereLache($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BarrageInfos whereProductionTotaleBrut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BarrageInfos whereProductionTotaleNet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BarrageInfos whereTurbine($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BarrageInfos whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BarrageInfos whereVolumePompe($value)
 * @mixin \Eloquent
 */
class BarrageInfos extends Model
{
    use HasProductions,HasCentrale;
    protected $table = "barrage_infos";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'horaire','date','cote','cote2','volume_pompe', 'turbine', 'irrigation','lache','production_totale_brut','production_totale_net'
    ];

}
