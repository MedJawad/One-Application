<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\EchangeEnergie
 *
 * @property int $id
 * @property string $horaire
 * @property float $recu
 * @property float $fourni
 * @property int $infos_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\InterconnexionInfos $infos
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EchangeEnergie newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EchangeEnergie newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EchangeEnergie query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EchangeEnergie whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EchangeEnergie whereFourni($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EchangeEnergie whereHoraire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EchangeEnergie whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EchangeEnergie whereInfosId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EchangeEnergie whereRecu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EchangeEnergie whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EchangeEnergie extends Model
{
    protected $table = "echanges_energie";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'horaire','fourni','recu'
    ];

    /**
     * Get the centrale that owns these infos
     */
    public function infos()
    {
        return $this->belongsTo("App\InterconnexionInfos",'interconnexion_infos_id');
    }
}
