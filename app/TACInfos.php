<?php

namespace App;

use App\Traits\HasCentrale;
use App\Traits\HasProductions;
use Illuminate\Database\Eloquent\Model;

/**
 * App\TACInfos
 *
 * @property int $id
 * @property string|null $horaire
 * @property string $date
 * @property float|null $autonomie_charbon
 * @property float|null $production_totale_brut
 * @property float|null $production_totale_net
 * @property int $centrale_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Centrale $centrale
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Production[] $productions
 * @property-read int|null $productions_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TACInfos newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TACInfos newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TACInfos query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TACInfos whereAutonomieCharbon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TACInfos whereCentraleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TACInfos whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TACInfos whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TACInfos whereHoraire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TACInfos whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TACInfos whereProductionTotaleBrut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TACInfos whereProductionTotaleNet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TACInfos whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TACInfos extends Model
{
    use HasProductions,HasCentrale;

    protected $table = "tac_infos";
    protected $fillable = [
        'horaire','date','autonomie_charbon','production_totale_brut','production_totale_net'
    ];

}
