<?php

namespace Modules\Image\Repositories;

use Modules\Image\Entities\Image;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class ImageRepository
 * @package Modules\Platform\User\Repositories
 */
class ImageRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Image::class;
    }

    /**
     * Save a new entity in repository
     *
     * @throws ValidatorException
     *
     * @param array $attributes
     *
     * @return Image
     */
    public function create(array $attributes)
    {
        return parent::create($attributes);
    }

    /**
     * Update a entity in repository by id
     *
     * @throws ValidatorException
     *
     * @param array $attributes
     * @param       $id
     *
     * @return Image
     */
    public function update(array $attributes, $id)
    {
        return parent::update($attributes, $id);
    }
}