<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
