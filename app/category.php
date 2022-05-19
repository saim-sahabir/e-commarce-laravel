<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
      public function categories()
    {
        return $this->hasMany('App\category','parent_id');
    }
}
