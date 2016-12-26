<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
	protected $fillable = array('naam','active');
    protected $table = 'STATIONS';
    protected $primaryKey = 'id';
    public $timestamps = false;

}
