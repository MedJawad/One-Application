<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Prevision
 *
 * @property int $id
 * @property string $horaire
 * @property float $value
 * @property int $previsionable_id
 * @property string $previsionable_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $previsionable
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prevision newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prevision newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prevision query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prevision whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prevision whereHoraire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prevision whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prevision wherePrevisionableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prevision wherePrevisionableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prevision whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prevision whereValue($value)
 * @mixin \Eloquent
 */
class Prevision extends Model
{
    protected $table = "previsions";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'horaire','value',
    ];

    /**
     * Get the centraleInfos that owns these previsions
     */
    public function previsionable()
    {
        return $this->morphTo();
    }

}
