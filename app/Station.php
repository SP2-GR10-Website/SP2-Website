<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
	protected $fillable = array('stationId', 'naam', 'stad', 'active');
    protected $table = 'STATIONS';
    protected $primaryKey = 'stationId';
    public $timestamps = false;
}
