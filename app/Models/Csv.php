<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Csv
 *
 * @mixin IdeHelperCsv
 */
class Csv extends Model
{
    use HasFactory;

    public function headers()
    {
        return $this->hasMany(Header::class);
    }

    public function lines()
    {
        return $this->hasMany(Line::class);
    }
}
