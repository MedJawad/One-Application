<?php

namespace App;

use App\Traits\HasCentrale;
use App\Traits\HasPrevisions;
use App\Traits\HasProductions;
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Production[] $productions
 * @property-read int|null $productions_count
 */
class EolienInfos extends Model
{
    use HasCentrale,HasProductions,HasPrevisions;

    protected $table = "eolien_infos";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type','horaire','date','production_totale_brut','production_totale_net'
    ];

}
