<?php

namespace Modules\Category\Repositories;

use Modules\Category\Entities\Category;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class CategoryRepository
 * @package Modules\Platform\User\Repositories
 */
class CategoryRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Category::class;
    }

    /**
     * Save a new entity in repository
     *
     * @param array $attributes
     *
     * @return Category
     * @throws ValidatorException
     *
     */
    public function create(array $attributes)
    {
        return parent::create($attributes);
    }

    /**
     * Update a entity in repository by id
     *
     * @param array $attributes
     * @param       $id
     *
     * @return Category
     * @throws ValidatorException
     *
     */
    public function update(array $attributes, $id)
    {
        return parent::update($attributes, $id);
    }

    /**
     * @param $filter
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getCategories($filter)
    {
        $query = Category::query();
        if ($filter) {
            $query->where('name', 'LIKE', '%' . $filter . '%')
                ->orWhere('code', 'LIKE', '%' . $filter . '%');
        }
        return $query->get();
    }

    /**
     * @param $attributes
     * @param $category
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function setAttributes($attributes, $category)
    {
        foreach ($attributes as $key => $attribute) {
            if (isset($attribute['id']) && $attribute['id'] != null) {
                $arrId[] = $attribute['id'];
            } else {
                unset($attribute['id']);
                $attr = $category->attributes()->create($attribute);
                $arrId[] = $attr->id;
            }
        }
        $category->attributes()->syncWithoutDetaching($arrId);
        return Category::query()->find($category->id);
    }
}
