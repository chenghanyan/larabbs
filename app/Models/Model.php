<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel
{
    public function scopeRecent($query)
    {
    	dd(33);
        return $query->orderBy('id', 'desc');
    }

    public function scopeOrdered($query)
    {
    	dd(33);
        return $query->orderBy('order', 'desc');
    }


}
