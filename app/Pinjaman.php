<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pinjaman extends Model
{
   protected $table = 'pinjaman';

   /**
    * [cicilan description]
    * @return [type] [description]
    */
   public function cicilan()
   {	
   		return $this->hasMany('App\Cicilan', 'pinjaman_id', 'id');
   }

   /**
    * [user description]
    * @return [type] [description]
    */
   public function user()
   {
   		return $this->hasOne('App\ModelUser', 'id', 'user_id');
   }
}
