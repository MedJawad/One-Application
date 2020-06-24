<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

///**
// * Centrale
// *
// * @mixin Eloquent
// */
/**
 * App\Centrale
 *
 * @property int $id
 * @property string $nom
 * @property string|null $adresse
 * @property string|null $description
 * @property string $type
 * @property string $subtype
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Centrale newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Centrale newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Centrale query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Centrale whereAdresse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Centrale whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Centrale whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Centrale whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Centrale whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Centrale whereSubtype($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Centrale whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Centrale whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Centrale whereUserId($value)
 * @mixin \Eloquent
 */
class Centrale extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom', 'adresse', 'description', 'type' , 'subtype'
    ];

    /**
     * Get the infos of the centrale
     */
    public function infos()
    {
        switch (strtolower($this->type)) {
            case "barrage":
                return $this->hasMany('App\BarrageInfos');
            case "solaire":
                return $this->hasMany('App\SolaireInfos');
            case "eolien":
                return $this->hasMany('App\EolienInfos');
            case "thermique a charbon":
                return $this->hasMany('App\TACInfos');
            case "cycle combine":
                return $this->hasMany('App\CycleCombineInfos');
            case "turbine a gaz":
                return $this->hasMany('App\TAGInfos');
            case "interconnexion":
                return $this->hasMany('App\InterconnexionInfos');
        }
    }

    public function user() {
        return $this->belongsTo('App\User','user_id');
    }
}
