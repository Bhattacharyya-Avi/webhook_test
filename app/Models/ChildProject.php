<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChildProject extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
