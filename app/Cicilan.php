<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cicilan extends Model
{
    protected $table = 'cicilan';

    /**
     * [pinjaman description]
     * @return [type] [description]
     */
    public function pinjaman()
    {
    	return $this->hasOne('App\Pinjaman', 'id', 'pinjaman_id');
    }
}
