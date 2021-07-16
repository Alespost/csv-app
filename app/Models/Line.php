<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Line
 *
 * @mixin IdeHelperLine
 */
class Line extends Model
{
    use HasFactory;

    public function values()
    {
        return $this->hasMany(Value::class);
    }

    public function csv()
    {
        return $this->belongsTo(Csv::class);
    }
}
