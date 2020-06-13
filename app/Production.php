<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
