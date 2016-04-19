<?php

namespace App\Orms;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    //
     protected $table = 'activity';
         /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];
}
