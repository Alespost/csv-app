<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Value
 *
 * @mixin IdeHelperValue
 */
class Value extends Model
{
    use HasFactory;

    public function header()
    {
        return $this->belongsTo(Header::class);
    }

    public function line()
    {
        return $this->belongsTo(Line::class);
    }
}
