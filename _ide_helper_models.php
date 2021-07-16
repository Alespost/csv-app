<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Csv
 *
 * @property int $id
 * @property string $title
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Header[] $headers
 * @property-read int|null $headers_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Line[] $lines
 * @property-read int|null $lines_count
 * @method static \Illuminate\Database\Eloquent\Builder|Csv newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Csv newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Csv query()
 * @method static \Illuminate\Database\Eloquent\Builder|Csv whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Csv whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Csv whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Csv whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperCsv extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Header
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property int $order
 * @property int $csv_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Csv $csv
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Value[] $values
 * @property-read int|null $values_count
 * @method static \Illuminate\Database\Eloquent\Builder|Header newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Header newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Header query()
 * @method static \Illuminate\Database\Eloquent\Builder|Header whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Header whereCsvId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Header whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Header whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Header whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Header whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Header whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperHeader extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Line
 *
 * @property int $id
 * @property int $order
 * @property int $csv_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Csv $csv
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Value[] $values
 * @property-read int|null $values_count
 * @method static \Illuminate\Database\Eloquent\Builder|Line newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Line newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Line query()
 * @method static \Illuminate\Database\Eloquent\Builder|Line whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Line whereCsvId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Line whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Line whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Line whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperLine extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Value
 *
 * @property int $id
 * @property string $value
 * @property int $header_id
 * @property int $line_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Header $header
 * @property-read \App\Models\Line $line
 * @method static \Illuminate\Database\Eloquent\Builder|Value newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Value newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Value query()
 * @method static \Illuminate\Database\Eloquent\Builder|Value whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Value whereHeaderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Value whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Value whereLineId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Value whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Value whereValue($value)
 * @mixin \Eloquent
 */
	class IdeHelperValue extends \Eloquent {}
}

