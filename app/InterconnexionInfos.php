<?php

namespace App;

use App\Traits\HasCentrale;
use App\Traits\HasProductions;
use Illuminate\Database\Eloquent\Model;

/**
 * App\InterconnexionInfos
 *
 * @property int $id
 * @property int $centrale_id
 * @property string $horaire
 * @property string $date
 * @property float|null $production_totale_recu
 * @property float|null $production_totale_fourni
 * @property float|null $production_gazoil
 * @property float|null $livraison_fioul
 * @property float|null $consommation_fioul
 * @property float|null $transfert_fioul
 * @property float|null $livraison_gazoil
 * @property float|null $consommation_gazoil
 * @property float|null $transfert_gazoil
 * @property float|null $livraison_charbon
 * @property float|null $consommation_charbon
 * @property float|null $transfert_charbon
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Centrale $centrale
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\EchangeEnergie[] $echanges
 * @property-read int|null $echanges_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InterconnexionInfos newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InterconnexionInfos newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InterconnexionInfos query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InterconnexionInfos whereCentraleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InterconnexionInfos whereConsommationCharbon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InterconnexionInfos whereConsommationFioul($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InterconnexionInfos whereConsommationGazoil($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InterconnexionInfos whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InterconnexionInfos whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InterconnexionInfos whereHoraire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InterconnexionInfos whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InterconnexionInfos whereLivraisonCharbon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InterconnexionInfos whereLivraisonFioul($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InterconnexionInfos whereLivraisonGazoil($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InterconnexionInfos whereProductionGazoil($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InterconnexionInfos whereProductionTotaleFourni($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InterconnexionInfos whereProductionTotaleRecu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InterconnexionInfos whereTransfertCharbon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InterconnexionInfos whereTransfertFioul($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InterconnexionInfos whereTransfertGazoil($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InterconnexionInfos whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InterconnexionInfos extends Model
{
    use HasCentrale;

    protected $table = "interconnexion_infos";
    protected $fillable = [
        'horaire','date','production_totale_recu','production_totale_fourni'
    ];

    /**
     * Get the list of productions inserted for this CentraleInfos
     */
    public function echanges()
    {
        return $this->hasMany('App\EchangeEnergie');
    }
}
