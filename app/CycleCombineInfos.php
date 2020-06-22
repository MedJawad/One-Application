<?php

namespace App;

use App\Traits\HasCentrale;
use App\Traits\HasProductions;
use Illuminate\Database\Eloquent\Model;

/**
 * App\CycleCombineInfos
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CycleCombineInfos newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CycleCombineInfos newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CycleCombineInfos query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CycleCombineInfos whereCentraleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CycleCombineInfos whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CycleCombineInfos whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CycleCombineInfos whereHoraire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CycleCombineInfos whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CycleCombineInfos whereProductionTotaleBrut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CycleCombineInfos whereProductionTotaleNet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CycleCombineInfos whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CycleCombineInfos extends Model
{
    use HasProductions,HasCentrale;

    protected $table = "cycle_combine_infos";
    protected $fillable = [
        'horaire','date','production_totale_brut','production_totale_net'
    ];

}
