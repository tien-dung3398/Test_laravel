<?php

namespace Modules\Image\Entities;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Image
 * @property int $id
 * @package Modules\Image\Entities
 * @property string $url
 * @property int $imageable_id
 * @property string $imageable_type
 * @property $created_at
 * @property $updated_at
 * @property Collection | Image [] | $imageable
 */
class Image extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'url', 'imageable_id', 'imageable_type'
    ];

    /**
     * @var string[]
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function imageable()
    {
        return $this->morphTo();
    }
}

?>
