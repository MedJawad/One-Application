<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Production
 *
 * @property int $id
 * @property string $horaire
 * @property float $value
 * @property int $productionable_id
 * @property string $productionable_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $productionable
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Production newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Production newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Production query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Production whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Production whereHoraire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Production whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Production whereProductionableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Production whereProductionableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Production whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Production whereValue($value)
 * @mixin \Eloquent
 */
class Production extends Model
{
    protected $table = "productions";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'horaire','value',
    ];

    /**
     * Get the centrale that owns these infos
     */
    public function productionable()
    {
//        return $this->belongsTo('App\BarrageInfos','barrage_infos_id');
        return $this->morphTo();
    }

}
